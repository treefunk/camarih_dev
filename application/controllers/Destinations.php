<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destinations extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('destination_model');
    }
    
    public function index()
    {
        $data['destinations'] = $this->destination_model->all();
        return $this->wrapper([
            'view' => 'admin/destinations/index',
            'data' => $data
        ]);
    }

    public function create()
    {
        return $this->wrapper([
            'view' => 'admin/destinations/create'
        ]);
    }

    public function store()
    {
        $post = $this->input->post();
        $this->db->trans_start();
        $this->load->library('form_validation');

        if(count($post))
        {
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('short_name','Short Name','required');
        }

        if($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            $this->wrapper([
                'view' => 'admin/destinations/create',
                'data' => $data
            ]);
            return;
        }

        if($this->destination_model->add($post)){
            $alert = [
                'type' => 'success',
                'message' => 'Destination Successfully added.'
            ];
            $this->db->trans_complete();
        }else{
            $alert = [
                'type' => 'danger',
                'message' => 'Something Went Wrong.'
            ];
            $this->db->trans_rollback();
        }


        $this->session->set_flashdata($alert);
        return redirect('destinations');
    }

    public function update($id)
    {
        $post = $this->input->post();
        $changes = 0;

        $this->load->library('form_validation');

        if(count($post))
        {
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('short_name','Short Name','required');
        }

        if($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata(['alert' => [
                'type' => 'danger',
                'message' => $errors
            ]]);
            return redirect('destinations/edit/' . $id);
        }

        $changes += $this->destination_model->update($id,$post);

        $alert = [
			'type' => 'success',
			'message' => 'Package Successfully Updated!'
		];

        if($changes){
			$this->session->set_flashdata('alert',$alert);
		}
		return redirect(base_url('destinations'));


    }

    public function edit($id)
    {
        $data['destination'] = $this->destination_model->findById($id);
        return $this->wrapper([
            'view' => 'admin/destinations/edit',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $destination = $this->destination_model->findById($id);

        if($this->destination_model->delete($id))
        {
            $this->db->trans_complete();
            $alert = [
                "type" => 'success',
                "message" => "Destination Successfully Deleted."
            ];
        }else{
            $this->db->trans_rollback();
            $alert = [
                "type" => 'danger',
                "message" => "Oops! Something went wrong."
            ];
        }

        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('destinations/'));
    }

    // API
    public function get_all_destinations()
    {
        $destinations = $this->destination_model->all();

        die(json_encode($destinations));
    }
}