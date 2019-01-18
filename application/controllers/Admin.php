<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('slider_model');
    }

    public function index() // ADMIN MANAGEMENT
    {
        $data['admins'] = $this->admin_model->all()
                                            ->result();

		$this->wrapper([
			'view' => 'admin/admin_management',
			'data' => $data
		]);
    }

    
    



}
