<?php

class Tripschedule extends Admin_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'tripschedule_model'
        ]);
    }

    public function index(){

    }
    
    public function create(){

        $this->wrapper([
            'view' => 'admin/schedule/create'
        ]);
        
    }
}