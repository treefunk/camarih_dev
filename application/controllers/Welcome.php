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
		$this->load->model('packageimage_model');
	}


	public function index()
	{

		$slider_data = $this->slider_model->allWithFeaturedOffset();

		$data = [
			'sliders' => $slider_data['result'],
			'testimonials' => $this->testimonial_model->all(),
			'destinations' => $this->destination_model->getAllEndpoints(),
			'origins' => $this->destination_model->getAllOrigins(),
			'featured_package' => $this->package_model->getFeaturedPackage(),
			'default_slider' => $slider_data['offset']
		];

		


		$this->wrapper([
			'view' => 'home',
			'data' => $data
		]);
	}
}
