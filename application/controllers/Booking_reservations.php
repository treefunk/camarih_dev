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

        //FILTER SEARCH
        if(!empty($get['search'])){
            $this->bookingreservation_model->filterSearch($query,$get['search']);
        }

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
            'reserved',
            'cancelled',
        ];


        $this->load->library('pagination');

        $query->order_by('created_at','DESC');
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
        
        setPaginationStyle($config);
        
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

        if($post['status'] == 'reserved'){
            $seat_num_ids = [];
            $seat_num_ids_db = [];
            //BEFORE UPDATE CHECK IF IT'S STILL AVAILABLE
            $seat_plans = $this->db->select('seat_plan.seat_num')
                                        ->from('seat_plan')
                                            ->join('carts','carts.id = seat_plan.cart_id')
                                            ->join('trip_availability', 'trip_availability.id = seat_plan.trip_availability_id')
                                            ->where('carts.id', $booking_reservation->id)->get()->result();
            foreach($seat_plans as $seat_plan){
                $seat_num_ids[] = $seat_plan->seat_num;
            }

            $seats_taken = $this->db->select('seat_plan.seat_num')
                                    ->from('seat_plan')
                                    ->join('carts','seat_plan.cart_id = carts.id')
                                    ->join('checkouts','checkouts.id = carts.checkout_id')
                                    ->join('rates','carts.rate_id = rates.id')
                                    ->join('trip_availability','trip_availability.id = seat_plan.trip_availability_id')
                                    ->where('carts.departure_date',$booking_reservation->departure_date)
                                    ->where('carts.departure_time',$booking_reservation->departure_time)
                                    //   ->where('trip_availability.destination_from', $seat_plans[0]->destination_from)
                                    //   ->where('trip_availability.id',$seat_plans[0]->trip_availability_id)
                                    ->where('carts.id <>',$booking_reservation->id)
                                    ->where('carts.status','reserved')
                                    ->get()->result();
            foreach($seats_taken as $taken){
                $seat_num_ids_db[] = $taken->seat_num;
            }
                            
            $seats_taken = count(array_intersect($seat_num_ids,$seat_num_ids_db));
            
            if($seats_taken){
                $alert = [
                    'type' => 'danger',
                    'message' => "Cannot update status. Maximum number of seats already taken."
                ];

                
                $this->session->set_flashdata('alert',$alert);
            }

        }
        
        

        if($booking_reservation && !$seats_taken){

            if($booking_reservation->status != $post['status']){
                $changes += $this->bookingreservation_model->update($booking_reservation->id,[
                    'status' => $post['status']
                ]);
            }

            if($changes){
                $alert = [
                    'type' => 'success',
                    'message' => 'Status Successfully Updated.'
                ];
    
                
                $this->session->set_flashdata('alert',$alert);
            }

        }

       

        return redirect(base_url("booking_reservations"));
    }

    public function getBookingDetails(){
        $post = $this->input->post(null,true);

        $booking = $post['booking'];

        $booking_info = $this->db->get_where('booking_information',[
            'cart_id' => $booking['id']
        ])->row();

        $data['seat_plan'] = $this->db->get_where('seat_plan',[
            'cart_id' => $booking['id']
        ])->result();






        $data['details'] = [
            'User Information' => [
                'Full Name' => $booking['fullname'],
                'Email' => $booking['email'],
                'Phone' => $booking['phone'],
            ],
            'Booking Details' => [
                'Origin' => $booking['origin_name'],
                'Destination' => $booking['destination_name'],
                'Departure date' => $booking['departure_date'],
                'Departure time' => $booking['departure_time'],
                'Van' => $booking['van_name'],
                'Total' => "PHP " . number_format($booking['price'] * count($data['seat_plan']),2)
            ],
            'Booking Information' => [
                'Pickup Location' => $booking_info->pickup_location,
                'Drop Location' => $booking_info->drop_location
            ]
        ];

        die(json_encode($data));
    }



}
