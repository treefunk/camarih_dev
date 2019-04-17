<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MY_Controller {

	const PER_PAGE = 5;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'package_model',
			'destination_model',
			'packagedownload_model',
			'packageimage_model'
		]);
	}


	public function index($offset = 0)
	{

		$query = $this->package_model->getQuery();

        $per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

		$query->order_by("created_at",'DESC');
		$query->where('status','active');
        $query->offset($offset);
        $query->limit($per_page);

		
        $config = [
            'base_url' => base_url('packages'),
            'total_rows' => $clone_query->get()->num_rows(),
			'per_page' => $per_page,
		];

		setPaginationStyle($config);
        
        $this->pagination->initialize($config);

        
		$default_image = base_url('frontend/images/')."package.jpg";
		
		
		$data = [
			'packages' => $query->get()->result(),
			'destinations' => $this->destination_model->getAllEndpoints(),
			'origins' => $this->destination_model->getAllOrigins(),
			'default_image' => $default_image,
			'links' => $this->pagination->create_links()
		];

		$this->wrapper([
			'view' => 'packages',
			'data' => $data
		]);
	}

	public function selected($id)
	{
		$data['package'] = $this->package_model->find($id);
		$data['downloads_url'] = $this->packagedownload_model->upload_path;
		$data['dummy_doc'] = getenv("ENABLE_DUMMY_DOC_PREVIEW") == "true" ? true : false;
		$data['destinations'] = $this->destination_model->getAllEndpoints();
		$data['origins'] = $this->destination_model->getAllOrigins();
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
