<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiries extends Admin_Controller {

    const PER_PAGE = 10;

	public function __construct(){
        parent::__construct();
        $this->load->model('tourinquiries_model');
    }

    public function index($offset = 0) // ADMIN MANAGEMENT
    {
        $query = $this->tourinquiries_model->getAllQuery();
        
        $per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

        $query->offset($offset);
        $query->limit($per_page);

        $config = [
            'base_url' => base_url('inquiries/index/'),
            'total_rows' => $clone_query->get()->num_rows(),
            'per_page' => $per_page,
            // 'reuse_query_string' => TRUE
        ];
        
        
        setPaginationStyle($config);
        
        $this->pagination->initialize($config);

        $data['inquiries'] = $query->get()->result();
        
        $data['links'] = $this->pagination->create_links();

		$this->wrapper([
			'view' => 'admin/inquiries'
            ,'data' => $data
		]);
    }

    
    



}
