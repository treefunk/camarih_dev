<?php




class Contact extends MY_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model([
            'contact_model'
        ]);
    }

    public function index(){
        $this->wrapper([
            'view' => 'contactus'
        ]);
    }

    public function send(){
        $post = $this->input->post(null,TRUE);
        $this->contact_model->sendMail($post);
    }

}