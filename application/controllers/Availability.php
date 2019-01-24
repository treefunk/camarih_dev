<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Availability extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->model([
            'destination_model',
            'tripavailability_model',
            'rate_model',
            'cart_model',
            'seatplan_model',
            'package_model',
            'van_model',
            'reservation_model'
        ]);

    }
    
    // public function index()
    // {
    //     $data[''] = $this->destination_model->all();
    //     return $this->wrapper([
    //         'view' => 'admin//index',
    //         'data' => $data
    //     ]);
    // }

    // STEP 1 - show available rates

    public function check()
    {
        // destination_from: (string) "4"
        // departure_from: (string) "2019-01-09"
        // destination_to: (string) "3"
        // departure_to: (string) "2019-01-17"

        if($this->input->post()){ //if post data is set, use post data
            $post_data = $this->input->post();
        }
        elseif($this->session->has_userdata('check_availability')){ // if session is set, use session data
            $post_data = $this->session->userdata('check_availability');
        }else{ //if no post/session is set, redirect index page
            return redirect(base_url());
        }

        $data['available_trips'] = $this->tripavailability_model->checkAvailability($post_data);

        $data['selected'] = [
            'from' => $post_data['departure_from'],
            'to' => $post_data['departure_to'],
            'origin' => $this->destination_model->findById($post_data['destination_from']),
            'destination' => $this->destination_model->findById($post_data['destination_to'])
        ];


        $this->session->set_userdata('check_availability', $post_data);

        //van vacancy

        //iterate in available trips
        foreach($data['available_trips'] as $trip){
            $van = $this->van_model->findById($trip->van_id);
            $rate = $this->rate_model->findById($trip->rate_id);
            $occupied = count($this->seatplan_model->getOccupiedSeatsByRateId($rate->id));
            $pending = count($this->seatplan_model->getPendingSeatsByRateId($rate->id));
            $trip->total_seats = $this->van_model->getTotalSeats($van);
    
            $trip->occupied_seats = $occupied + $pending;
        }
        //van vacany end


        // var_dump($data['available_trips']); die();
        $this->wrapper([
            'data' => $data,
            'view' => 'check'
        ]);

        
    }

    // Step 2 show van seat plan + per head input fields
    public function book($rate_id)
    {

        $rate = $this->rate_model->findById($rate_id);
        
        if($this->session->has_userdata('check_availability')){
            $post_data = $this->session->userdata('check_availability');
        }

        //GET VAN LAYOUT
        $data['seat_map'] = $this->rate_model->getVanlayoutByRateId($rate_id);                

        //GET OCCUPIED SEATS
        $data['occupied_seat_map'] = $this->seatplan_model->getOccupiedSeatsByRateId($rate->id);
        
        //GET SELECTED SEATS IN CART
        $data['pending_seat_map'] = $this->seatplan_model->getPendingSeatsByRateId($rate->id);

        //GET CURRENT SEATS IN SESSION
        $data['current_seat_map'] = $this->seatplan_model->getCurrentSeatsByRateId($rate->id);
        // var_dump($data['current_seat_map']); die();

        // SET SESSION
        $data['selected'] = [
            'from' => $post_data['departure_from'],
            'to' => $post_data['departure_to'],
            'origin' => $this->destination_model->findById($post_data['destination_from']),
            'destination' => $this->destination_model->findById($post_data['destination_to']),
            'rate_id' => $rate->id,
            'rate_price' => $rate->price
        ];

        $seat_layout = [];
        $index = 1;
        $row = 0;

        // var_dump($data['current_seat_map']); die();
        foreach($data['seat_map'] as $row_length)
        {
            for($x = 0 ; $x < (int)$row_length ; $x++)
            {
                $found = false;
                foreach($data['current_seat_map'] as $current)
                {
                    if($current->seatnum == $index){
                        $s['bday'] = $current->bday;
                        $s['name'] = $current->name;
                        $found = true;
                    }
                    continue;

                }
                $seat = (object)[
                    'seatnum' => $index,
                    'bday' => $found ? $s['bday'] : '',
                    'name' => $found ? $s['name'] : '',
                    'isOccupied' => in_array($index,$data['occupied_seat_map']),
                    'isPending' => in_array($index,$data['pending_seat_map']),
                    'selected' => $found ? true : false,
                    
                ];

    
                $index++;
                $seat_layout[$row][] = $seat;
                    
            }
            $row++;
        }


        $data['seat_layout'] = $seat_layout;


        $data['rate_selected'] = [
            'rate_id' => $rate->id,
            'rate_price' => $rate->price
        ];

        $this->session->set_userdata('selected_rate',$data['rate_selected']);
        $this->session->set_userdata('check_availability', $post_data);
        $this->session->set_userdata('selected', $data['selected']);
        // SET SESSION END

        // var_dump($data['seat_layout']); die();
        $this->wrapper([
            'data' => $data,
            'view' => 'book'
        ]);
    }

    // step 3 - show packages selection
    public function packages()
    {
        $seats = $this->input->post('selected');
        $rate_id = $this->session->userdata('selected_rate')['rate_id'];

        $rate = $data['rate'] = $this->rate_model->findById($rate_id);
        //show packages only to this rate destination
        $data['packages'] = $this->package_model->getByDestinationId($rate->destination_id);

        $new_seats = [];
        foreach($seats as $seat){
            $new_seats[] = $seat;
        }
        $this->session->set_userdata('selected_seats',$new_seats);


        
        $this->wrapper([
            'data' => $data,
            'view' => 'package_selection'
        ]);

    }

    //step 4 - show summary
    public function summary(){

        $package_id = $this->input->post('package_id');

        $package = 0;
        if($package_id != ''){
            $package = $this->package_model->findById($package_id);
        }

        $this->session->set_userdata('selected_package',$package);

        
        $data = $this->checkDataSess(5);
        

        $regular_rate_per_header_price =  ($data['selected']['rate_price'] * count($data['selected_seats']));
        $data['final_price'] = $regular_rate_per_header_price;

        if($package){
            $data['final_price'] += ($data['selected_package']->rate * count($data['selected_seats']));

        }
        
        // all required data is present

        $this->wrapper([
            'data' => $data,
            'view' => 'summary'
        ]);


        

        // clear current selection if added to cart
    }

    public function add_to_cart()
    {
        $data = $this->checkDataSess(6);
        if(!$this->session->has_userdata('cart')){
            $this->session->set_userdata('cart',[]);
        }

        $_SESSION['cart'][] = $data;
        
        $this->cart_model->clearCartSession();

        return redirect(base_url('cart'));
    }

    public function process_cart(){
        $post = $this->input->post();
        if($cart = $this->session->userdata('cart')){
            $id = $this->reservation_model->add($post);
            foreach($cart as $item)
            {
                $item->reservation_id = $id;
                $this->process_booking($item); // todo run transaction here, if one query fails remove that item
            }
        }else{
            //todo cart is empty
        }

        //clear current cart
        unset($_SESSION['cart']);
    }



    /**
     * $data - must have these properties -> (selected_seats/selected/selected_package)
     * 
     */
    public function process_booking($data) //todo run this inside loop function of cart
    {
        if(isset($data['selected'])){
            $rate_id = $data['selected']['rate_id'];
        }else{
            //todo user hasn't selected a rate!
        }
        //todo validate if seat is still available
        
        //get rate
        $rate = $this->rate_model->findById($rate_id);
        $paid = $this->process_payment();
        if($paid){
            $this->db->trans_begin();
            // Add Reservation
            $cart = [
                'rate_id' => $rate->id,
                'package_id' => is_object($data['selected_package']) ? $data['selected_package']->id : 0
            ];

            if($id = $this->cart_model->add($cart)){
                foreach($data['selected_seats'] as $seat){
                    $seat_plan = [
                        "cart_id" => $id,
                        "seat_num" => $seat['seatnum'],
                        "name" => $seat['name'],
                        "birth_date" => $seat['bday']
                    ];

                    $this->seatplan_model->add($seat_plan);
                }
            }


        }

        //todo add single package only to this trip.. ?
        // $data['package']
        
        $this->db->trans_complete();
        
        
    }

    public function checkDataSess($step = 1){
        $data = [];

        if($step >= 2){
            if($this->session->has_userdata('check_availability')){ // from/to dates/location
                $data['check_availability'] = $this->session->userdata('check_availability');
            }else{
                return redirect(base_url(''));
            }
        }

        if($step >= 3){
            if($this->session->has_userdata('selected')){ // rate
                $data['selected'] = $this->session->userdata('selected');
            }else{
                return redirect(base_url('availability/check'));
            }
        }

        if($step >= 4){
            if($this->session->has_userdata('selected_seats')){ // seatplan
                $data['selected_seats'] = $this->session->userdata('selected_seats');
            }else{
                return redirect(base_url("availability/book/{$data['selected']['rate_id']}"));
            }
        }   

        if($step >= 5){
            if($this->session->has_userdata('selected_package')){
                $data['selected_package'] = $this->session->userdata('selected_package');
            }else{
                return redirect(base_url('availability/packages'));
            }
        }
        return $data;
    }

    public function process_payment(){
        return TRUE;
    }

    public function clearSess()
    {
        $this->session->sess_destroy();
    }

}