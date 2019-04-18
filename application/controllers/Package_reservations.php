<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_reservations extends Admin_Controller {

    const PER_PAGE = 10;

	public function __construct(){
        parent::__construct();
        $this->load->model([
            'packagereservation_model',
            'package_model'
        ]);
        $this->table = "package_booking";
    }

    public function index($offset = 0)
    {
        $get = $this->input->get(null,true);

        $query = $this->packagereservation_model->getAllQuery();

        //SET FILTERS HERE
        if(!empty($get['search'])){
            $this->packagereservation_model->filterSearch($query,$get['search']);
        }

        if(!empty($get['package_id'])){
            $this->packagereservation_model->filterPackage($query,$get['package_id']);
        }

        if(!empty($get['status'])){
            $this->packagereservation_model->filterStatus($query,$get['status']);
        }

        $status_types = [
            'reserved',
            'cancelled',
        ];

        $this->load->library('pagination');

        $query->order_by('package_name');
        $clone_query = clone $query;
        $num_rows = $clone_query->get()->num_rows();

        $query->offset($offset);
        $query->limit(self::PER_PAGE);

        $config = [
            'base_url' => base_url('package-reservations'),
            'total_rows' => $num_rows,
            'per_page' => self::PER_PAGE,
            'reuse_query_string' => TRUE
        ];
        
        setPaginationStyle($config);
        $this->pagination->initialize($config);

        $data = [
            'links' => $this->pagination->create_links(),
            'package_reservations' => $query->get()->result(),
            'packages' => $this->package_model->all(), //TODO: Only packages that are present in package_booking
            'status_types' => $status_types,
            'get' => $get
        ];


        $this->wrapper([
            'view' => 'admin/package_reservations/index',
            'data' => $data
        ]);
    }


    public function updateStatus($id)
    {
        $package_reservation = $this->packagereservation_model->findById($id);
        $post = $this->input->post(null,true);
        $changes = 0;

        if($package_reservation){

            if($package_reservation->status != $post['status']){
                $changes += $this->packagereservation_model->update($package_reservation->id,[
                    'status' => $post['status']
                ]);
            }

        }

        if($changes){
            $alert = [
                'type' => 'success',
                'message' => 'Status Successfully Updated.'
            ];

            
            $this->session->set_flashdata('alert',$alert);
        }

        return redirect(base_url("package-reservations"));
    }

    public function getPackageDetails(){
        $post = $this->input->post(null,true);

        $package_reservation = $post['package_reservation'];

        $data['details'] = [
            'User Information' => [
                'Full Name' => $package_reservation['fullname'],
                'Email' => $package_reservation['email'],
                'Phone' => $package_reservation['phone'],
            ],
            'Package Details' => [
                'Name' => $package_reservation['package_name'],
                'Adult Count' => $package_reservation['adult_count'],
                'Total' => $package_reservation['adult_count'] * $package_reservation['price'],
                'Status' => $package_reservation['status'],
                'Created' => $package_reservation['created_at']
            ]
        ];

        die(json_encode($data));
    }




}
