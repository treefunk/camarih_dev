<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Van_reservations extends Admin_Controller {

    const PER_PAGE = 2;

	public function __construct(){
        parent::__construct();
        $this->load->model([
            'vanreservation_model',
            'van_model',
            'destination_model'
        ]);
    }


    public function index($offset = 0)
    {
        $get = $this->input->get(null,true);

        $query = $this->vanreservation_model->getAllQuery();


        //FILTERS

        //FILTER VAN
        if(!empty($get['van_id'])){
            $this->vanreservation_model->filterVan($query,$get['van_id']);
        }

        //FILTER DESTINATION
        if(!empty($get['destination_id'])){
            $this->vanreservation_model->filterDestination($query,$get['destination_id']);
        }

        //FILTER DEPARTURE DATE
        if(!empty($get['departure_start']) && !empty($get['departure_end'])){
            $this->vanreservation_model->filterDepartureDate($query,[
                'departure_start' => $get['departure_start'],
                'departure_end' => $get['departure_end']
            ]);
        }
        
        //FILTER TRIP TYPE
        if(!empty($get['trip_type'])){
            $this->vanreservation_model->filterTripType($query,$get['trip_type']);
        }

        //FILTER STATUS
        if(!empty($get['status'])){
            $this->vanreservation_model->filterStatus($query,$get['status']);
        }



        $status_types = [
            'pending',
            'completed',
            'cancelled'
        ];

        $trip_types = [
            'oneway_trip',
            'round_trip'
        ];

        $this->load->library('pagination');

        $query->order_by('van_name');
        $clone_query = clone $query;
        $num_rows = $clone_query->get()->num_rows();

        $query->offset($offset);
        $query->limit(SELF::PER_PAGE);

        $config = [
            'base_url' => base_url('van-reservations'),
            'total_rows' => $num_rows,
            'per_page' => SELF::PER_PAGE,
            'reuse_query_string' => TRUE
        ];
        
        
        $this->pagination->initialize($config);


        $data = [
            'links' => $this->pagination->create_links(),
            'van_reservations' => $query->get()->result(),
            'destinations' => $this->destination_model->getAllVanRentDropoff(),
            'vans' => $this->van_model->all(),
            'status_types' => $status_types,
            'trip_types' => $trip_types,
            'get' => $get
        ];

        $this->wrapper([
            'view' => 'admin/van_reservations/index',
            'data' => $data
        ]);
    
    }


}
