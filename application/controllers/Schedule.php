<?php

class Schedule extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'tripschedule_model',
            'scheduledetails_model'
        ]);
    }

    public function index(){

        $data['schedules'] = $this->tripschedule_model->allByTripNum();
        $data['body'] = is_object($this->scheduledetails_model->getBody()) ? $this->scheduledetails_model->getBody()->value : "";

        $this->wrapper([
            'data' => $data,
            'view' => 'schedule'
        ]);

    }

}