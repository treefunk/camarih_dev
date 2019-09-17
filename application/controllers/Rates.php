<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rates extends MY_Controller {

    public function index(){
    	$this->load->model('van_model', 'van_model');
    	$data['rates'] = $this->van_model->allWithRatesP();
        $this->wrapper([
            'view' => 'rates_table',
            'data' => $data
        ]);
    }
	
}
