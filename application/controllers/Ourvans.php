<?php

class Ourvans extends MY_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model([
            'van_model',
            'destination_model'
        ]);
    }

    public function index()
    {
        $data['vans'] = $this->van_model->allWithRates();
        $data['destinations'] = $this->destination_model->all();

        $this->wrapper([
            'data' => $data,
            'view' => 'our_vans'
        ]);
    }
}