<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourpackages extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('package_model');
		$this->load->model('packagedetail_model');
		$this->load->model('packagegallery_model');
	}


	public function index()
	{

		$data['packages'] = $this->package_model->all();

		
		$this->wrapper([
			'view' => 'admin/packages/index',
			'data' => $data
		]);
	}

	public function create()
	{
		$this->wrapper([
			'view' => 'admin/packages/create'
		]);
	}

	public function store()
	{
		$images = format_multiple_files($_FILES['images']);


		$post = $this->input->post();
		$this->db->trans_start();


		if($package_id = $this->package_model->add([
			'name' => $post['name'],
			'rate' => $post['rate']
		])){
			//package details
			$this->packagedetail_model->add([
				'package_id' => $package_id,
				'description' => $post['description']
			]);

			//package gallery
			$image_errors = $this->packagegallery_model->add([
				'package_id' => $package_id
			],$images);

			$alert = [
				'type' => 'success',
				'message' => "Package Successfully Added"
			];

			// remove no uploaded file error in array
			for($x = 0 ; $x < count($image_errors); $x++)
			{
				if($image_errors[$x] == ': <p>You did not select a file to upload.</p>'){
					array_splice($image_errors,$x,1);
				}
			}

			// modify alert message if there are errors in uploading
			if($image_errors){
				$alert['message'] .= "<br> Error in uploading images:<br>";
				$alert['type'] = 'warning';
				
				foreach($image_errors as $error){
					$alert['message'] .= " {$error}";
				}
			}
			//TODO group error messages



			

			$this->db->trans_complete();
		
		}else{

			$alert = [
				'type' => 'danger',
				'message' => 'Something went wrong.'
			];

			$this->db->trans_rollback();
		}

		$this->session->set_flashdata('alert',$alert);
		return redirect(base_url('tourpackages'));
	}

	public function edit($id){
				
		$data['package'] = $this->package_model->find($id);

		$this->wrapper([
			'view' => 'admin/packages/edit',
			'data' => $data
		]);
	}

	public function update($id){
		$post = $this->input->post();

		$images = format_multiple_files($_FILES['images']);

		$package = $this->package_model->find($id);

		$changes = 0;

		$this->db->trans_start();
		$changes += (int)$this->package_model->update($package->id, [
			'name' => $post['name'],
			'rate' => $post['rate']
		]);

		$changes += (int)$this->packagedetail_model->update($package->package_details->id,[
			'description' => $post['description']
		]);

		//images

		foreach($post['images'] as $image){
			$changes += (int)$this->packagegallery_model->update($image['id'],[
				'image_title' => $image['image_title']
			]);
		}


		$alert = [
			'type' => 'success',
			'message' => 'Package Successfully Updated!'
		];

		// if there are uploaded images

		$image_errors = $this->packagegallery_model->add([
			'package_id' => $package->id
		],$images);

		// remove no uploaded file error in array
		for($x = 0 ; $x < count($image_errors); $x++)
		{
			if($image_errors[$x] == ': <p>You did not select a file to upload.</p>'){
				array_splice($image_errors,$x,1);
			}
		}

		$alert = [
			'type' => 'success',
			'message' => "Package Successfully Added"
		];

		if($image_errors){
			$alert['type'] = 'warning';
			$alert['message'] .= "<br> Error in uploading images:<br>";

			foreach($image_errors as $error){
				$alert['message'] .= " {$error}";
			}
		}

		$this->db->trans_complete();
		
		// only show the alert if there were changes made
		if($changes){
			$this->session->set_flashdata('alert',$alert);
		}
		return redirect(base_url('tourpackages'));

	}
}
