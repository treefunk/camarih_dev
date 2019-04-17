<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Admin_Controller extends CI_Controller {

    protected $allowed = [ ];
    public function __construct()
    {
        parent::__construct();

        $this->allowed = ['login','auth'];

        if(!in_array($this->uri->segment(2),$this->allowed)){
            $this->checkIfAdmin();
        }
        $this->load->database();

    }

    public function wrapper($data = null)
    {

        // find admin data
        if($this->checkIfAdmin()){
            $id = $this->session->userdata('admin_id');
            $admindata['admin'] = $this->db->get_where('admins',[
                'id' => $id
            ])->row();
        }

        $this->load->view('admin/partials/header.php');
        $this->load->view('admin/partials/nav.php',$admindata);

        if(!isset($data['view'])){
            $this->load->view('admin/partials/main.php');
        }else{
            $this->load->view($data['view'],@$data['data']);
        }

        if(getenv('DEBUG') == 'true')
        {
            $this->load->view('debug.php',@$data['data']);
            $d = $this->output->enable_profiler(true);
        }
        
        $this->load->view('admin/partials/footer.php');

    }

    public function auth()
    {
        $post = $this->input->post();
        $post['username'] = htmlspecialchars($post['username']);

        $admin = $this->db->get_where('admins',['username' => $post['username']])->row();

        if($admin)
        {
            //user is found
            //check password
            if(password_verify($post['password'],$admin->password)){
                $this->session->set_userdata('admin_id',$admin->id);
                return redirect(base_url('admin'));
            }
        }

        // if not success
        $alert = [
            'type' => 'danger',
            'message' => 'Invalid Username or password.'
        ];

        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('admin/login'));

    }

    public function login()
    {
        if($this->session->has_userdata('admin_id'))
        {
            return redirect(base_url().'admin');
        }
        $this->load->view('admin/login.php');
    }
        
    public function logout()
    {
        $this->session->sess_destroy();
        return redirect(base_url().'admin/login');
    }

    public function checkIfAdmin()
    {
        if(!$this->session->has_userdata('admin_id'))
        {
            return redirect(base_url().'admin/login');
        }
        return true;
    }


	


    public function createAdmin()
    {
        $post = $this->input->post();
        
        if(!$this->admin_model->createAdmin($post)){
            $alert = [
                "type" => 'danger',
                "message" => "Username already exists."
            ];
            $this->session->set_flashdata('alert', $alert);
        }
        return redirect(base_url('admin/'));
    }

    public function editAdmin($id)
    {
        $post = $this->input->post();

        if($changes = $this->admin_model->updateAdmin($id,$post))
        {
            $alert = [
                "type" => 'success',
                "message" => "Admin Successfully Updated."
            ];
        }

        if($changes == -2){
            $alert = [
                "type" => 'danger',
                "message" => "Username already exists."
            ];
        }

        if($changes == -1)
        {
            $alert = [
                "type" => 'danger',
                "message" => "Password and confirm password does not match"
            ];
        }

        $this->session->set_flashdata('alert', $alert);
        return redirect(base_url('admin/'));
    }

    public function deleteAdmin($id)
    {
        $logout = false;

        if($this->session->userdata('admin_id') == $id){
            $logout = true;
        }


        if($this->admin_model->deleteAdmin($id))
        {
            if($logout){
                $this->session->sess_destroy();
                return redirect(base_url('admin'));
            }
            $alert = [
                "type" => 'success',
                "message" => "Admin Successfully Deleted."
            ];
        }else{
            $alert = [
                "type" => 'danger',
                "message" => "Oops! Something went wrong."
            ];
        }

        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('admin/'));
    }


}