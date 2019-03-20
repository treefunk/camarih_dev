<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'package_model',
			'destination_model'
		]);
	}


	public function index()
	{
		$data = [
			'packages' => $this->package_model->all(),
			'destinations' => $this->destination_model->all()
		];

		$this->wrapper([
			'view' => 'packages',
			'data' => $data
		]);
	}

	public function selected($id)
	{
		$data['package'] = $this->package_model->find($id);
		$data['destinations'] = $this->destination_model->all();

		// var_dump($data); die();

		$this->wrapper([
			'view' => 'selected_package',
			'data' => $data
		]);
	}

	public function add_to_cart()
	{
			$data = json_decode(file_get_contents("php://input"));
			$data = (array)$data;
			if(!$this->session->has_userdata('cart')){
				$this->session->set_userdata('cart',[]);
			}
	
			$data['booking_num'] = uniqid();
			$data['item_type'] = 'booking_package';
	
			$_SESSION['cart'][] = $data;

			die(json_encode([
				'message' => 'Package added to cart',
				'code' => 200
			]));
			
	}
}
