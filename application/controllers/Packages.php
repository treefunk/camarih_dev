<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MY_Controller {

	const PER_PAGE = 6;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'package_model',
			'destination_model',
			'packagedownload_model',
			'packageimage_model',
			'descriptions_model'
		]);
	}


	public function index($offset = 0)
	{

		$query = $this->package_model->getQuery();

        $per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

		$query->order_by("created_at",'DESC');
		$query->where('packages.status','active');
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
			'page_title' => 'Tour Packages',
			'packages' => $this->package_model->format($query->get()->result()),
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

	public function package_tours($offset = 0)
	{

		$query = $this->package_model->getQuery(0);

        $per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

		$query->order_by("created_at",'DESC');
		$query->where('packages.status','active');
        $query->offset($offset);
        $query->limit($per_page);

        $config = [
            'base_url' => base_url('packages/package_tours'),
            'total_rows' => $total_rows = $clone_query->get()->num_rows(),
			'per_page' => $per_page,
			'reuse_query_string' => true,
		];

		setPaginationStyle($config);
        
        $this->pagination->initialize($config);

        
		$default_image = base_url('frontend/images/')."package.jpg";
		
		$data = [
			'page_title' => 'Package Tours',
			'is_day_tour' => 0,
			'packages' => $packages = $this->package_model->format($query->get()->result()),
			'description' => $this->descriptions_model->findByName('package_tours_description'),
			'destinations' => $this->destination_model->getAllEndpoints(),
			'durations' => $this->package_model->getDurations(),
			'total_pages' => round($total_rows / $per_page),
			'current_page' => ($offset) ? ($offset/$per_page) + 1  : 1,
			'form_url' => base_url('packages/package_tours'),
			'origins' => $this->destination_model->getAllOrigins(),
			'default_image' => $default_image,
			'links' => $this->pagination->create_links()
		];
		$this->wrapper([
			'view' => 'packages',
			'data' => $data
		]);
	}
	public function day_tours($offset = 0)
	{

		$query = $this->package_model->getQuery(1);

        $per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

		$query->order_by("created_at",'DESC');
		$query->where('packages.status','active');
        $query->offset($offset);
        $query->limit($per_page);
        $config = [
            'base_url' => base_url('packages/day_tours'),
            'total_rows' => $total_rows = $clone_query->get()->num_rows(),
			'per_page' => $per_page,
			'reuse_query_string' => true,
		];

		setPaginationStyle($config);
        
        $this->pagination->initialize($config);

        
		$default_image = base_url('frontend/images/')."package.jpg";
		
		$data = [
			'page_title' => 'Day Tours',
			'is_day_tour' => 1,
			'packages' => $packages = $this->package_model->format($query->get()->result()),
			'description' => $this->descriptions_model->findByName('day_tours_description'),
			'destinations' => $this->destination_model->getAllEndpoints(),
			'total_pages' => $total_pages = round($total_rows / $per_page),
			'current_page' => ($offset) ? ($offset/$per_page) + 1  : 1,
			'form_url' => base_url('packages/day_tours'),
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
		$data['is_day_tour_format'] = ($data['package']->is_day_tour) ? 'Day Tour' : 'Package Tour';
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
