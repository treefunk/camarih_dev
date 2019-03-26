<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('slider_model');
		$this->load->model('testimonial_model');
		$this->load->model('destination_model');
		$this->load->model('package_model');
	}


	public function index()
	{

		$data = [
			'sliders' => $this->slider_model->all(),
			'testimonials' => $this->testimonial_model->all(),
			'destinations' => $this->destination_model->getAllEndpoints(),
			'origins' => $this->destination_model->getAllOrigins(),
			'featured_package' => $this->package_model->getFeaturedPackage()
		];

		


		$this->wrapper([
			'view' => 'home',
			'data' => $data
		]);
	}
}
