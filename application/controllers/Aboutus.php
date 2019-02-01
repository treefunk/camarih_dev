<?php

class Aboutus extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'destination_model'
        ]);
    }

    public function index(){
        $data['about'] = json_decode(file_get_contents(APPPATH.'/about.json'));

        $data['destinations'] = $this->destination_model->all();
        $this->wrapper([
            'data' => $data,
            'view' => 'aboutus'
        ]);
    }
}