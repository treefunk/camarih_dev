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
        // is_roundtrip: (STRING) "true/false"

        if($this->input->post()){ //if post data is set, use post data
            $post_data = $this->input->post();
        }
        elseif($this->session->has_userdata('check_availability')){ // if session is set, use session data
            $post_data = $this->session->userdata('check_availability');
        }else{ //if no post/session is set, redirect index page
            return redirect(base_url());
        }

        $data['selected'] = [
            'from' => $post_data['departure_from'],
            'origin' => $this->destination_model->findById($post_data['destination_from']),
            'destination' => $this->destination_model->findById($post_data['destination_to'])
        ];

        if(isset($post_data['departure_to'])){
            $data['selected']['to'] = $post_data['departure_to'];
        }
        $data['available_trips'] = [];


        if($post_data['is_roundtrip'] == 'true')
        {
            $return_data = $this->rev_from_to($post_data);

            $data['available_trips'][] = $this->tripavailability_model->checkAvailability($post_data);
            $data['available_trips'][] = $this->tripavailability_model->checkAvailability($return_data);

        }else{
            $data['available_trips'][] = $this->tripavailability_model->checkAvailability($post_data);
        }

        $this->session->set_userdata('check_availability', $post_data);

        //van vacancy


        
        // var_dump($data['available_trips']); die();
        
        $index = 0;
        // $data['available_trips'][0],[1] is present
            foreach($data['available_trips'] as $available_trip){

                // will loop 2 times if it's roundtrip
                foreach($available_trip as $trip){
                    $van = $this->van_model->findById($trip->van_id);
                    $rate = $this->rate_model->findById($trip->rate_id);

                    $dates = [$post_data['departure_from']];
                    if(isset($post_data['departure_to'])){
                        $dates[] = $post_data['departure_to'];
                    }

                    // get occupied and pending seats
                    $occupied = count($this->seatplan_model->getOccupiedSeatsByRate($rate,$dates[$index]));
                    $pending = count($this->seatplan_model->getPendingSeatsByRateAndDate($rate,$dates[$index]));
                

                    $trip->total_seats = $this->van_model->getTotalSeats($van);
                    $trip->departure_time = $rate->departure_time;
                    $trip->occupied_seats = $occupied + $pending;
                }
                $index++;
            }
            

        
        $this->wrapper([
            'data' => $data,
            'view' => 'check'
        ]);

        
    }

    // Step 2 show van seat plan + per head input fields
    public function book($return = false)
    {

        $rates = $this->input->post('rate');
        $result['labels'] = ['Departure Seat Plan', 'Return Seat Plan'];
        

        if($return){
            $result['offset'] = 1;
            $result['data'] = $_SESSION['bup_data'];

            $this->wrapper([
                'data' => $result,
                'view' => 'book'
            ]);
            return;
        }

        

        $onewaytrip = !isset($rates[1]);

        
        if($onewaytrip){ // oneway trip

            $rate = $this->rate_model->findById($rates[0]);

        }else{ // roundtrip

            $depart_rate = $this->rate_model->findById($rates[0]);
            $return_rate = $this->rate_model->findById($rates[1]);

        }
        
        if($this->session->has_userdata('check_availability')){
            $post_data = $this->session->userdata('check_availability');
        }

        $_SESSION['selected_rate'] = [];
        $_SESSION['selected'] = [];

        if($onewaytrip){ //oneway trip
            $data = [];
            $data[] = $this->getSeatPlan($rate,$post_data);

           

            $_SESSION['selected_rate'][] = $data[0]['rate_selected'];
            $_SESSION['selected'][] = $data[0]['selected'];

        }else{ //roundtrip

            $data = [];

            $return_data = $this->rev_from_to($post_data);

            $data[] = $this->getSeatPlan($depart_rate,$post_data);

            $data[] = $this->getSeatPlan($return_rate,$return_data);
        

            foreach($data as $d){
                $_SESSION['selected_rate'][] = $d['rate_selected'];
                $_SESSION['selected'][] = $d['selected'];
            }

            
            
        }
        

        $this->session->set_userdata('check_availability', $post_data);

        
        $result['data'] = $data;

        unset($_SESSION['bup_data']);
        if(isset($data[1]))
        {
            $_SESSION['bup_data'] = $data;
        }
        $result['offset'] = 0;
        // SET SESSION END
        $this->wrapper([
            'data' => $result,
            'view' => 'book'
        ]);
    }

    // step 3 - show packages selection
    public function packages()
    {

        $post = $this->input->post();

        if(isset($post['is_roundtrip'])){
            $_SESSION['bup_seats'] = $post;
            $this->book(true);
            return;
        }else{
            $selecteds = [];
            if(isset($_SESSION['bup_seats'])){
                $selecteds[] = $_SESSION['bup_seats'];
            }
            $selecteds[] = $post;
            $post['selected'] = $selecteds;
        }

        $onewaytrip = count($post['selected']) == 1;

        // Package only applies to destination_id

        $rate_id = $_SESSION['selected_rate'][0]['rate_id'];
        
        $rate = $data['rate'] = $this->rate_model->findById($rate_id);
        //show packages only to this rate destination
        $data['packages'] = $this->package_model->getByDestinationId($rate->destination_id);
        
        $_SESSION['selected_seats'] = [];
        // die();

            foreach($post['selected'] as $selected){
                $_SESSION['selected_seats'][] = $selected['selected'];
            }

        
        $this->wrapper([
            'data' => $data,
            'view' => 'package_selection'
        ]);

    }

    //step 4 - show summary
    public function summary(){

        $package_id = $this->input->post('package_id');
        $onewaytrip = count($this->session->userdata('selected_seats')) == 1;

        $package = 0;
        if($package_id != ''){
            $package = $this->package_model->findById($package_id);
        }

        $this->session->set_userdata('selected_package',$package);

        
        $data = $this->checkDataSess(5);
        
        $regular_rate_per_header_price = 0;
        if($onewaytrip){
            $regular_rate_per_header_price =  ($data['selected'][0]['rate_price'] * count($data['selected_seats'][0]));
        }else{
            for($x = 0; $x < count($data['selected']); $x++){
                $regular_rate_per_header_price += ($data['selected'][$x]['rate_price'] * count($data['selected_seats'][$x]));
            }
        }

        $data['final_price'] = $regular_rate_per_header_price;

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
        
        $this->cart_model->clearCurrentCartSession();

        return redirect(base_url('cart'));
    }

    public function process_cart(){
        $post = $this->input->post();

        //todo ---------------------sanitize input
        
        // $reservation_data = [
        //     'full_name' => $post['full_name'],
        //     'email' => $post['email'],
        //     'phone' => $post['phone'],
        //     'pickup_location' => $post['pickup_location'],
        //     'drop_location' => $post['drop_location'],
        //     'active' => 1,
        //     'status' => 'pending'
        // ];

        $reservation_data = [
            'full_name' => 'jhondee',
            'email' => 'jhondz@gmail.com',
            'phone' => '623215',
            'pickup_location' => 'near mall',
            'drop_location' => 'fastfood',
            'active' => 1,
            'status' => 'pending'
        ];


        if($cart = $this->session->userdata('cart')){
            $id = $this->reservation_model->add($reservation_data);
            
            foreach($cart as $item)
            {
                $item['reservation_id'] = $id;
                for($x = 0; $x < count($item['selected']) ; $x++){
                    $this->process_booking($item,$x); // todo run transaction here, if one query fails remove that item
                }
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
    public function process_booking($data,$offset = 0) //todo run this inside loop function of cart
    {

        if(isset($data['selected'][$offset])){
            $rate_id = $data['selected'][$offset]['rate_id'];
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
                'package_id' => is_object($data['selected_package'][$offset]) ? $data['selected_package'][$offset]->id : 0,
                'reservation_id' => $data['reservation_id'],
                'departure_date' => format_date_and_time_for_sql("{$data['selected'][$offset]['from']} {$rate->departure_time}",$format = "Y-m-d H:i A"),
                'departure_time' => $rate->departure_time
            ];
            

            if($id = $this->cart_model->add($cart)){
                foreach($data['selected_seats'][$offset] as $seat){
                    $seat_plan = [
                        "trip_availability_id" => $rate->trip_availability_id,
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

    public function getSeatPlan($rate,$post_data){
        //GET VAN LAYOUT
        $data['seat_map'] = $this->rate_model->getVanlayoutByRateId($rate->id);                

        //GET OCCUPIED SEATS
        $data['occupied_seat_map'] = $this->seatplan_model->getOccupiedSeatsByRate($rate,$post_data['departure_from']);
        
        //GET SELECTED SEATS IN CART
        $data['pending_seat_map'] = $this->seatplan_model->getPendingSeatsByRateAndDate($rate,$post_data['departure_from']);

        //todo GET CURRENT SEATS IN SESSION
        // $data['current_seat_map'] = $this->seatplan_model->getCurrentSeatsByRateId($rate->id,$offset)[$offset];
        
        // SET SESSION
        $data['selected'] = [
            'from' => $post_data['departure_from'],
            'origin' => $this->destination_model->findById($post_data['destination_from']),
            'destination' => $this->destination_model->findById($post_data['destination_to']),
            'rate_id' => $rate->id,
            'rate_price' => $rate->price,
            'trip_availability_id' => $rate->trip_availability_id
        ];

        if(isset($post_data['departure_to'])){
            $data['selected']['to'] = $post_data['departure_to'];
        }

        $seat_layout = [];
        $index = 1;
        $row = 0;
   
        foreach($data['seat_map'] as $row_length)
        {
            for($x = 0 ; $x < (int)$row_length ; $x++)
            {
                $found = false;
                // foreach($data['current_seat_map'] as $current)
                // {
                //     if($current->seatnum == $index){
                //         $s['bday'] = $current->bday;
                //         $s['name'] = $current->name;
                //         $found = true;
                //     }
                //     continue;

                // }
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

        return $data;
    }
    public function rev_from_to($post_data){
        return [
            "destination_from" => $post_data['destination_to'],
            "departure_from" => $post_data['departure_to'],
            "destination_to" => $post_data['destination_from'],
            "departure_to" => $post_data['departure_from'],
            "is_roundtrip" => "true"
        ];

    }

    public function viewCartSess(){
        var_dump($this->session->userdata('cart'));
        die();
    }
}