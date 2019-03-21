<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourpackages extends Admin_Controller {
	const PER_PAGE = 10;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('package_model');
		$this->load->model('packagedetail_model');
		$this->load->model('packagegallery_model');
		$this->load->model('destination_model');
	}


	public function index($offset = 0)
	{

		$query = $this->package_model->getAllQuery();

		$per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

        $query->offset($offset);
        $query->limit($per_page);

        $config = [
            'base_url' => base_url('tourpackages'),
            'total_rows' => $clone_query->get()->num_rows(),
            'per_page' => $per_page,
            // 'reuse_query_string' => TRUE
        ];
        
        
        $this->pagination->initialize($config);

        $data['packages'] = $query->get()->result();
        
        $data['links'] = $this->pagination->create_links();

		
		$this->wrapper([
			'view' => 'admin/packages/index',
			'data' => $data
		]);
	}

	public function create()
	{
		$data['destinations'] = $this->destination_model->all();

		$this->wrapper([
			'data' => $data,
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
			'rate' => $post['rate'],
		])){
			//package details
			$this->packagedetail_model->add([
				'package_id' => $package_id,
				'description' => $post['description'],
				'minimum_count' => $post['minimum_count']
			]);

			//package gallery
			$image_errors = $this->packagegallery_model->add([
				'package_id' => $package_id,
				'images' => $post['images']
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
		$data['destinations'] = $this->destination_model->all();
		$this->wrapper([
			'view' => 'admin/packages/edit',
			'data' => $data
		]);
	}

	public function update($id){
		$post = $this->input->post();


		
		$images = isset($_FILES['images']) ? format_multiple_files($_FILES['images']) : [];

		$package = $this->package_model->find($id);

		$changes = 0;

		$this->db->trans_start();
		$changes += (int)$this->package_model->update($package->id, [
			'name' => $post['name'],
			'rate' => $post['rate'],
		]);

		$changes += (int)$this->packagedetail_model->update($package->package_details->id,[
			'description' => $post['description'],
			'minimum_count' => $post['minimum_count']
		]);

		//images
		
		//get all uploaded images in db
		$uploaded_images_string_ids = $this->db->select('GROUP_CONCAT(id) as ids')->from('package_gallery')
		->where(['package_id' => $package->id])
		->get()->row();

		$uploaded_images_ids = explode(",",$uploaded_images_string_ids->ids);
		$uploaded_images_post_ids = [];
		if(isset($post['uploaded_images'])){
			foreach($post['uploaded_images'] as $image){
				$uploaded_images_post_ids[] = $image['id'];
				$changes += (int)$this->packagegallery_model->update($image['id'],[
					'image_title' => $image['image_title']
				]);
			}
		}

		$to_be_deleted = array_values(array_diff($uploaded_images_ids,$uploaded_images_post_ids));		

		
		if($to_be_deleted){
			$gallery_to_be_deleted = $this->db->from('package_gallery')->where_in('id',$to_be_deleted)->get()->result();
			$this->db->from('package_gallery')->where_in('id',$to_be_deleted)->delete();
			foreach($gallery_to_be_deleted as $gallery){
				$file = "uploads/package_gallery/{$package->id}_{$gallery->image_name}";
				if(file_exists($file)){
					unlink($file);
				}
			}
			$changes += 1;
		}




		$alert = [
			'type' => 'success',
			'message' => 'Package Successfully Updated!'
		];

		// if there are uploaded images

		$image_errors = $this->packagegallery_model->add([
			'package_id' => $package->id,
			'images' => $post['images']
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
