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
		$this->load->model('packagedownload_model');
		$this->load->model('packageimage_model');
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
        
		setPaginationStyle($config);
		
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
		$images = cleanMultipleFilesArray('images');
		
		
		$post = $this->input->post();

		
		$this->packageIsFeatured($post['is_featured']);


		$this->db->trans_start();


		if($package_id = $this->package_model->add([
			'name' => $post['name'],
			'rate' => $post['rate'],
			'is_featured' => $post['is_featured']
		])){
			// set initial message
			$alert = [
				'type' => 'success',
				'message' => "Package Successfully Added"
			];

			//package details
			$this->packagedetail_model->add([
				'package_id' => $package_id,
				'description' => $post['description'],
				'minimum_count' => $post['minimum_count']
			]);

			//package gallery
			if(count($images)){
				$post['images'] = array_values($post['images']); //reset array keys
				$image_errors = $this->packagegallery_model->add([
					'package_id' => $package_id,
					'images' => $post['images']
				],$images);

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
			}
			if($hasDownloads = isset($_FILES['package_download']) && $_FILES['package_download']['name'] != ""){
				$file = $_FILES['package_download'];
				$name = str_replace(' ','_',$file['name']);
				if($download_id = $this->packagedownload_model->add([
					'package_id' => $package_id,
					'file_name' => $name,
					'file_title' => $file['name'],
					'type' => "",
				])){
					
					if($this->packagedownload_model->createUploadFolder()){ 
						$errors = $this->packagedownload_model->handleUpload('package_download',$download_id,$this->packagedownload_model->upload_path,$name,$allowed_types = 'docx|doc|jpg|png|jpeg');

						if($errors != $name){
							$alert = [
								'type' => 'warning',
								'message' => 'Package added but file upload failed: <br>' . implode("<br>",$errors)
							];
						}
					}
				}
			}

			if($hasMainImage = isset($_FILES['main_image']) && $_FILES['main_image']['name'] != ""){
				$file = $_FILES['main_image'];
				$name = str_replace(' ','_',$file['name']);
				if($main_image_id = $this->packageimage_model->add([
					'package_id' => $package_id,
					'image_name' => $name,
					'image_title' => $file['name'],
					'type' => "",
				])){
					
					if($this->packageimage_model->createUploadFolder()){
						$errors = $this->packagedownload_model->handleUpload('main_image',$main_image_id,$this->packageimage_model->upload_path,$name);

						if($errors != $name){
							$alert = [
								'type' => 'warning',
								'message' => 'Package added but file upload failed: <br>' . implode("<br>",$errors)
							];
						}
					}
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

		
		$images = cleanMultipleFilesArray('images');
		
		$package = $this->package_model->find($id);

		if($package->status != 'inactive'){
			$this->packageIsFeatured($post['is_featured']);
		}

		$changes = 0;

		$this->db->trans_start();

		$changes += (int)$this->package_model->update($package->id, [
			'name' => $post['name'],
			'rate' => $post['rate'],
			'is_featured' => $post['is_featured']
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
		if(count($images)){

			$post['images'] = array_values($post['images']);

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
		}

		if($hasDownloads = isset($_FILES['package_download']) && $_FILES['package_download']['name'] != ""){
			$existing = $this->db->get_where('package_downloads',[
				'package_id' => $package->id
			])->row();


			$file = $_FILES['package_download'];
			if($download_id = $this->packagedownload_model->add([
				'package_id' => $package->id,
				'file_name' => $file['name'],
				'file_title' => $file['name'],
				'type' => "",
			])){
				
				if($this->packagedownload_model->createUploadFolder()){
					$errors = $this->packagedownload_model->handleUpload('package_download',$download_id,$this->packagedownload_model->upload_path,$file['name'],$allowed_types = 'docx|doc|jpg|png|jpeg');

					if($existing){
						$this->packagedownload_model->delete($existing->id);
						unlink($this->packagedownload_model->upload_path . "/{$existing->id}_{$existing->file_name}");
					}

					$alert = [
						'type' => 'warning',
						'message' => 'Package added but file upload failed: <br>' . implode("<br>",$errors)
					];
				}
			}
		}

		if($hasMainImage = isset($_FILES['main_image']) && $_FILES['main_image']['name'] != ""){
			$existing = $this->db->get_where('package_main_image',[
				'package_id' => $package->id
			])->row();


			$file = $_FILES['main_image'];
			if($download_id = $this->packageimage_model->add([
				'package_id' => $package->id,
				'image_name' => $file['name'],
				'image_title' => $file['name'],
				'type' => "",
			])){
				
				if($this->packageimage_model->createUploadFolder()){
					$errors = $this->packageimage_model->handleUpload('main_image',$download_id,$this->packageimage_model->upload_path,$file['name']);

					if($existing){
						$this->packageimage_model->delete($existing->id);
						unlink($this->packageimage_model->upload_path . "/{$existing->id}_{$existing->file_name}");
					}

					$alert = [
						'type' => 'warning',
						'message' => 'Package added but file upload failed: <br>' . implode("<br>",$errors)
					];
				}
			}
		}

		$alert = [
			'type' => 'success',
			'message' => "Package Successfully Updated"
		];

		if($image_errors){
			$alert['type'] = 'warning';
			$alert['message'] .= "<br> Error in uploading images";

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


	public function packageIsFeatured(&$isFeatured){
		if(!isset($isFeatured)){
			$isFeatured = 0;
		}else{
			$isFeatured = 1;
			$this->db->set(['is_featured' => 0 ])
								->where(['is_featured' => 1])
								->update('packages');
		}
	}


	public function delete($id)
    {
        $this->db->trans_start();
        $package = $this->package_model->findById($id);
		

        // $currentfile =  'uploads/sliders/'.$slider->id. '_' . $slider->image_name;
        // if(file_exists($currentfile))
        // {
        //     unlink($currentfile);
		// }
		


        if($this->package_model->delete($id))
        {
			$this->db->delete('package_details',['package_id' => $package->id]);
			
			$package_download = $this->db->get_where('package_downloads',['package_id' => $package->id])->row();
			
			if($package_download && $this->db->delete('package_downloads',['package_id' => $package->id])){
				$file = "{$this->packagedownload_model->upload_path}/{$package_download->id}_{$package_download->file_name}";
				if(file_exists($file)){
					@unlink($file);
				}
			
			}

			$package_image = $this->db->get_where('package_main_image',['package_id' => $package->id])->row();
			
			if($package_image && $this->db->delete('package_main_image',['package_id' => $package->id])){
				
				$file = "{$this->packageimage_model->upload_path}/{$package_image->id}_{$package_image->image_name}";
				if(file_exists($file)){
					@unlink($file);
				}
				
			}

			$package_gallery = $this->db->get_where('package_gallery', ['package_id' => $package->id])->result();

			foreach($package_gallery as $gallery){
				if($this->packagegallery_model->delete($gallery->id)){
					$file = "{$this->packagegallery_model->upload_path}/{$package->id}_{$gallery->image_name}";
					if(file_exists($file)){
						@unlink($file);
					}
				}
			}

			$this->db->trans_complete();
            $alert = [
                "type" => 'success',
                "message" => "Slider Successfully Deleted."
            ];
        }else{
            $this->db->trans_rollback();
            $alert = [
                "type" => 'danger',
                "message" => "Oops! Something went wrong."
            ];
        }

        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('tourpackages'));
	}
	
	public function status($id)
	{

		$package = $this->package_model->findById($id);
		$status = $this->input->post('status',TRUE);
	
		$changes = 0;

		$update_data = [
			'status' => $status,
			'id' => $id
		];

		if($package->is_featured){
			$update_data['is_featured'] = 0;
		}

		if($package->status != $status){
			$changes += (int)$this->package_model->update($package->id, $update_data);
		}	

		if($changes){
			$alert = [
				'type' => 'success',
				'message' => "Package Successfully Updated"
			];
		}

		$this->session->set_flashdata('alert',$alert);
        return redirect(base_url('tourpackages'));
	}
}
