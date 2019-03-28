<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_reservations extends Admin_Controller {

    const PER_PAGE = 10;

	public function __construct(){
        parent::__construct();
        $this->load->model([
            'cart_model',
            'bookingreservation_model',
            'destination_model',
            'van_model'
        ]);
    }

    public function index($offset = 0)
    {

        $get = $this->input->get(null,true);
        $query = $this->bookingreservation_model->getAllQuery();

        //FILTER ORIGIN
        if(!empty($get['origin_id'])){
            $this->bookingreservation_model->filterOrigin($query,$get['origin_id']);
        }

        //FILTER DESTINATION
        if(!empty($get['destination_id'])){
            $this->bookingreservation_model->filterDestination($query,$get['destination_id']);
        }

        //FILTER VAN
        if(!empty($get['van_id'])){
            $this->bookingreservation_model->filterVan($query,$get['van_id']);
        }

        //FILTER SELLING DATE RANGE
        if(!empty($get['departure_start']) && !empty($get['departure_end'])){
            $this->bookingreservation_model->filterDepartureDate($query,[
                'departure_start' => $get['departure_start'],
                'departure_end' => $get['departure_end']
            ]);
        }

        //FILTER STATUS
        if(!empty($get['status'])){
            $this->bookingreservation_model->filterStatus($query,$get['status']);
        }


        $status_types = [
            'completed',
            'cancelled',
            'pending'
        ];


        $this->load->library('pagination');

        $query->order_by('origin_name');
        $clone_query = clone $query;
        $num_rows = $clone_query->get()->num_rows();

        $query->offset($offset);
        $query->limit(SELF::PER_PAGE);

        $config = [
            'base_url' => base_url('booking-reservations'),
            'total_rows' => $num_rows,
            'per_page' => SELF::PER_PAGE,
            'reuse_query_string' => TRUE
        ];
        
        
        $this->pagination->initialize($config);

        $data = [
            'links' => $this->pagination->create_links(),
            'booking_reservations' => $query->get()->result(),
            'origins' => $this->destination_model->getAllOrigins(),
            'destinations' => $this->destination_model->getAllEndpoints(),
            'vans' => $this->van_model->all(),
            'status_types' => $status_types,
            'get' => $get
        ];

        $this->wrapper([
            'view' => 'admin/booking_reservations/index',
            'data' => $data
        ]);
    }

    public function updateStatus($id)
    {
        $booking_reservation = $this->bookingreservation_model->findById($id);
        $post = $this->input->post(null,true);
        $changes = 0;

        if($booking_reservation){

            if($booking_reservation->status != $post['status']){
                $changes += $this->bookingreservation_model->update($booking_reservation->id,[
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

        return redirect(base_url("booking_reservations"));
    }



}
