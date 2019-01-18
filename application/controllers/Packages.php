<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('package_model');
	}


	public function index()
	{
		$data = [
			'packages' => $this->package_model->all(),
		];

		$this->wrapper([
			'view' => 'packages',
			'data' => $data
		]);
	}
}
