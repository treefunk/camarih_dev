<?php


class Footer_details extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'footer_model'
        ]);

    }

    public function index(){

        $data = $this->footer_model->getAll();

        $this->wrapper([
            'data' => $data,
            'view' => 'admin/footer_details/edit'
        ]);
    }
    public function update(){
        $post = $this->input->post(null,TRUE);
 
        $changes = 0;

        if($this->footer_model->process_post($post))
        {
            $alert = [
                'type' => 'success',
                'message' => 'Footer Details Updated.'
            ];

            $this->session->set_flashdata('alert',$alert);
        }


        return redirect(base_url('footer_details'));



    }



}