<?php

class Schedule extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'tripschedule_model'
        ]);
    }

    public function index(){

        $data['schedules'] = $this->tripschedule_model->allByTripNum();

        $this->wrapper([
            'data' => $data,
            'view' => 'schedule'
        ]);

    }

}