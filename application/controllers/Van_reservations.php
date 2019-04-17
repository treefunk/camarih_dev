<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Van_reservations extends Admin_Controller {

    const PER_PAGE = 10;

	public function __construct(){
        parent::__construct();
        $this->load->model([
            'vanreservation_model',
            'van_model',
            'destination_model'
        ]);

        $this->table = "van_rent";
    }


    public function index($offset = 0)
    {
        $get = $this->input->get(null,true);

        $query = $this->vanreservation_model->getAllQuery();


        //FILTERS

        //FILTER SEARCH
        if(!empty($get['search'])){
            $this->vanreservation_model->filterSearch($query,$get['search']);
        }

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
            'reserved',
            'cancelled',
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
        
        setPaginationStyle($config);
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

    public function updateStatus($id)
    {
        $van_reservation = $this->vanreservation_model->findById($id);
        $post = $this->input->post(null,true);
        $changes = 0;

        if($van_reservation){

            $van = $this->db->get_where('vans',[
                'id' => $van_reservation->van_id
            ])->row();

            $van_rents = $this->db->get_where('van_rent',[
                'departure_date' => $van_reservation->departure_date,
                // 'destination_id' => $post->destination_id,
                'origin_id' => $van_reservation->origin_id,
                'status' => 'reserved',
                'van_id' => $van->id
            ])->num_rows();
    
    
            $available_count = ($van->num_of_vans - $van_rents) - 1;
            

            if($available_count < 0 && $post['status'] == 'reserved')
            {
                $alert = [
                    'type' => 'danger',
                    'message' => "Unable to update status, maximum number of vans has been reached."
                ];
    
            }else{
                if($van_reservation->status != $post['status']){
                    $changes += $this->vanreservation_model->update($van_reservation->id,[
                        'status' => $post['status']
                    ]);
                }
            }

            

        }

        if($changes){
            $alert = [
                'type' => 'success',
                'message' => 'Status Successfully Updated.'
            ];
            
        }
        $this->session->set_flashdata('alert',$alert);

        return redirect(base_url("van-reservations"));
    }

    public function getVanDetails(){
        $post = $this->input->post(null,true);

        $van_reservation = $post['van_reservation'];

        $data['details'] = [
            'User Information' => [
                'Full Name' => $van_reservation['fullname'],
                'Email' => $van_reservation['email'],
                'Phone' => $van_reservation['phone'],
            ],
            'Van Hire Details' => [
                'Van' => $van_reservation['van_name'],
                'Origin' => $van_reservation['origin_name'],
                'Destination' => $van_reservation['destination_name'],
                'Departure date' => $van_reservation['departure_date'],
                'Adult Count' => $van_reservation['adult_count'],
                'Price' => $van_reservation['price'],
                'Status' => $van_reservation['status']
            ]
        ];

        die(json_encode($data));
    }


}
