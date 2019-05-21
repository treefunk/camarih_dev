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
            'checkout_model',
            'bookinginformation_model',
            'vanrent_model',
            'packagebooking_model',
            'contact_model'
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
                    $occupied = count(array_unique($this->seatplan_model->getOccupiedSeatsByRate($rate,$dates[$index])));
                    $pending = count(array_unique($this->seatplan_model->getPendingSeatsByRateAndDate($rate,$dates[$index])));

                    // $trip->pending = $this->seatplan_model->getPendingSeatsByRateAndDate($rate,$dates[$index]);
                    // $trip->occupied = array_unique($this->seatplan_model->getOccupiedSeatsByRate($rate,$dates[$index]));

                    $trip->total_seats = $this->van_model->getTotalSeats($van);
                    $trip->departure_time = $rate->departure_time;
                    $trip->occupied_seats = $occupied + $pending;
                }
                $index++;
            }
            // d($data['available_trips']);

        if(isset($_SESSION['current_booking_data']['selected_seats'])){
            unset($_SESSION['current_booking_data']['selected_seats']);
        }
        if(isset($_SESSION['current_booking_data']['booking_information'])){
            unset($_SESSION['current_booking_data']['booking_information']);
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
    // public function packages()
    // {

    //     $post = $this->input->post();

    //     if(isset($post['is_roundtrip'])){
    //         $_SESSION['bup_seats'] = $post;
    //         $this->book(true);
    //         return;
    //     }else{
    //         $selecteds = [];
    //         if(isset($_SESSION['bup_seats'])){
    //             $selecteds[] = $_SESSION['bup_seats'];
    //         }
    //         $selecteds[] = $post;
    //         $post['selected'] = $selecteds;
    //     }

    //     $onewaytrip = count($post['selected']) == 1;

    //     // Package only applies to destination_id

    //     $rate_id = $_SESSION['selected_rate'][0]['rate_id'];
        
    //     $rate = $data['rate'] = $this->rate_model->findById($rate_id);
    //     //show packages only to this rate destination
    //     $data['packages'] = $this->package_model->getByDestinationId($rate->destination_id);
        
    //     $_SESSION['selected_seats'] = [];
    //     // die();

    //         foreach($post['selected'] as $selected){
    //             $_SESSION['selected_seats'][] = $selected['selected'];
    //         }

        
    //     $this->wrapper([
    //         'data' => $data,
    //         'view' => 'package_selection'
    //     ]);

    // }

    public function book_departure($booking_num = null){ //refactored version

        if($booking_num){
            if($current = $this->setCurrentDataByBookingNum($booking_num)){
                $_SESSION['current_booking_data'] = $current;
            }else{
                die("Invalid Booking number");
            }
        }
    
        $args = [   
            'type' => 'oneway',
            'rates' => $this->input->post('rate') ?: $_SESSION['current_booking_data']['rate'],
            'label' => "Departure",
            'booking_num' => $booking_num
        ];

        $data = $this->getSeatplanDetails($args);


    

        $this->wrapper([
            'data' => $data,
            'view' => 'book'
        ]);
        

    }

    public function book_return($booking_num = null){

        $post = $this->input->post() ?: $_SESSION['current_booking_data']['selected_seats'][0];
        $post['booking_information'] = $this->input->post('booking_information') ?: $_SESSION['current_booking_data']['booking_information'][0];

        $new_seats = [];
        if(isset($post['selected'])){
            foreach($post['selected'] as $s){ $new_seats[] = $s; }
        }
        
        if(!isset($_SESSION['current_booking_data']['selected_seats']) ){
            $_SESSION['current_booking_data']['selected_seats'] = [];
            $_SESSION['current_booking_data']['selected_seats'][] = $new_seats; // create a new data
        }else{
            $_SESSION['current_booking_data']['selected_seats'][0] = $new_seats; // overwrite existing
        }

        if(!isset($_SESSION['current_booking_data']['booking_information'])){
            $_SESSION['current_booking_data']['booking_information'] = [];
            $_SESSION['current_booking_data']['booking_information'][] =  $post['booking_information']; // create a new data
        }else{
            $_SESSION['current_booking_data']['booking_information'][0] =  $post['booking_information']; // overwrite existing
        }

        $args = [
            'type' => 'roundtrip',
            'rates' => $_SESSION['current_booking_data']['rate'], // TODO: OR USE RATE FROM SESSION,
            'label' => 'Return',
            'booking_num' => $booking_num
        ];


        $data = $this->getSeatplanDetails($args);


        $this->wrapper([
            'data' => $data,
            'view' => 'book'
        ]);

    }

    //step 4 - show summary
    public function summary(){

        //post containing the selected seats and booking information
        $post = $this->input->post();

        //check if oneway or roundtrip
        $oneway = count($_SESSION['current_booking_data']['selected']) == 1;
        $new_seats = [];
        foreach($post['selected'] as $s){ $new_seats[] = $s; }

        if($oneway){ //if oneway
            $_SESSION['current_booking_data']['selected_seats'] = [$new_seats];
            $_SESSION['current_booking_data']['booking_information'] = [$post['booking_information']];
        }else{ // if roundtrip
            $_SESSION['current_booking_data']['selected_seats'][] = $new_seats;
            $_SESSION['current_booking_data']['booking_information'][] = $post['booking_information'];
        }
        
        $data = $this->checkDataSess(5);
        
        $regular_rate_per_header_price = 0;


        if($oneway){
            $regular_rate_per_header_price =  ($data['selected'][0]['rate_price'] * count($data['selected_seats'][0]));
        }else{
            for($x = 0; $x < count($data['selected']); $x++){
                $regular_rate_per_header_price += ($data['selected'][$x]['rate_price'] * count($data['selected_seats'][$x]));
            }
        }

        $data['final_price'] = $regular_rate_per_header_price;

        $this->add_to_cart();
        

        // clear current selection if added to cart
    }

    public function add_to_cart()
    {

        
        $data = $this->checkDataSess(6);
        
 
        if(!$this->session->has_userdata('cart')){
            $this->session->set_userdata('cart',[]);
        }

        $data['booking_num'] = uniqid();
        $data['item_type'] = 'booking_trip';
        $_SESSION['cart'][] = $data;
        
        $this->cart_model->clearCurrentCartSession();

        return redirect(base_url('cart'));
    }
    

    public function process_cart(){ //TODO: get price rate from database not from frontend!!!
        
        if(!isset($_SESSION['payment_details'])){
            $d['errormsg'] = 'Payment has expired, Please try again.';
            $this->wrapper([
                'view' => 'errorpage',
                'data' => $d
            ]);
            return -1;
        }

        $checked_items = $_SESSION['payment_details']['booking_num'];

        $checkout_data = [
            'active' => 1,
            'status' => 'pending'
        ] + $_SESSION['payment_details']['booking_information'];

        $this->db->trans_begin();
        
        if($cart = $this->session->userdata('cart')){


            $id = $this->checkout_model->add($checkout_data);

            $cart_count = count($cart);
            $to_be_deleted = [];
            $has_conflict = false;

            if(isset($_SESSION['conflicts'])){
                $_SESSION['conflicts'] = [];
            }
            
            $d;
  
            foreach($cart as $index => $item)
            {
                if(!in_array($item['booking_num'],$checked_items)){
                    continue;
                }

                $item['checkout_id'] = $id;
                

                if($item['item_type'] == 'booking_trip'){ //booking trip

                    for($x = 0; $x < count($item['selected']) ; $x++){
                        if(is_string($errors = $this->process_booking($item,$x))){
                            $d['errormsg'] = $errors;
                            $has_conflict = TRUE;
                            if(!isset($_SESSION['conflicts'])){
                                $_SESSION['conflicts'] = [];
                            }
                            $_SESSION['conflicts'][] = $item['booking_num'];

                            
                        }
                    }

                }elseif($item['item_type'] == 'booking_van'){ //booking van

                    $van = $this->van_model->find($item['van']->id);
                    $data = [
                        'checkout_id' => $item['checkout_id'],
                        'van_id' => $van->id,
                        'departure_date' => $item['departure_date'],
                        'trip_type' => $item['trip_type'],
                        'origin_id' => $item['origin']->id,
                        'destination_id' => $item['destination']->id,
                        'adult_count' => $item['adult_count'],
                        'price' => $item['price']
                    ];

                    $this->vanrent_model->add($data);

                }elseif($item['item_type'] == 'booking_package'){

                    $package = $this->package_model->find($item['id']);
                    $price = $package->rate * $item['adult_count'];

                    $data = [
                        'checkout_id' => $item['checkout_id'],
                        'package_id' => $package->id,
                        'adult_count' => $item['adult_count'],
                        'price' => $price
                    ];

                    $this->packagebooking_model->add($data);
                }
                $to_be_deleted[] = [$index, $cart_count]; 
                // array_splice($_SESSION['cart'], ($index - ($cart_count - count($_SESSION['cart']))),1);
                if($has_conflict){
                    $this->wrapper([
                        'view' => 'errorpage',
                        'data' => $d
                    ]);
                    return -1;
                }
            }

            // paypal

            require_once __DIR__.'/../models/Paypal.php';

            $paypal = new Paypal();

            if(getenv('PAYMENT_EXECUTE') != "false"){
                $details = $paypal->getPaymentDetails($this->input->get('paymentId'));
                if(!is_object($details)){
                    $data['errormsg'] = $details;
                    $this->wrapper([
                        'view' => 'errorpage',
                        'data' => $data
                    ]);
                    return -1;
                }
                $executed = $paypal->executePayment($details->transactions[0]);

                if(!is_object($executed)){
                    $data['errormsg'] = $executed;
                    $this->wrapper([
                        'view' => 'errorpage',
                        'data' => $data
                    ]);
                    return -1;
                }
            }

            //end of paypal
            $email = $_SESSION['payment_details']['booking_information']['email'];
            $mail_string = $this->send_email($checked_items,$cart,$email); //TODO:
            $_SESSION['item_list'] = $mail_string;
            //unset garbage

            unset($_SESSION['payment_details']);

            $alert = [
                'type' => "success",
                'message' => 'Thank you. Payment is successfull.'
            ];

            //clear cart
            foreach($to_be_deleted as $d){
                array_splice($_SESSION['cart'],$d[0] - ($d[1] - count($_SESSION['cart'])),1);
            }

            //end of unset garbage






        }else{
            //TODO: cart is empty
        }

        


        $this->db->trans_complete();

        // $this->wrapper([
        //     'view' => 'thankyou',
        //     'data' => $d
        // ]);
        // return -1;
        $_SESSION['item_list'] = $mail_string;

        $this->session->mark_as_temp('item_list',9000000); 
        return redirect(base_url('checkout/thankyou'));
    }

    protected function send_email($checked_items,$cart,$email){

        $item_list = [];
        $total_price = 0;

        foreach($cart as $item)
        {
            // d($cart);
            
            if(!in_array($item['booking_num'],$checked_items)){ continue; }
            if($item['item_type'] == 'booking_package'){
                
                $price = $item['rate'] * $item['adult_count'];

                $p = [
                    'type' => 'package',
                    'package_name' => $item['name'],
                    'adult_count' => $item['adult_count'],
                    'rate' => $item['rate'],
                    'price' => number_format($price,2)
                ];

                $total_price += $price;
                $item_list[] = $p;

            }elseif($item['item_type'] == 'booking_van'){
                // d($item);
                $v = [
                    'type' => 'van',
                    'van_name' => $item['van']->name,
                    'departure_date' => $item['departure_date'],
                    'destination' => "{$item['origin']->name} -> {$item['destination']->name}",
                    'trip_type' => $item['trip_type'],
                    'price' => number_format($item['price'],2)
                ];

                $total_price += $item['price'];
                $item_list[] = $v;
            }elseif($item['item_type'] == 'booking_trip'){

                $trips = [];

                for($x = 0 ; $x < count($item['selected']) ; $x++){

                    $seats_array = [];
                    

                    foreach($item['selected_seats'][$x] as $s){
                        $seats_array[] = "[#{$s['seatnum']}-{$s['name']}]";
                    }

                    $seats = implode(',',$seats_array);

                    $formatted_date = DateTime::createFromFormat(
                        'Y-m-d',
                        $item['selected'][$x]['from'],
                        new DateTimeZone('Asia/Hong_Kong')
                    )->format('M j, Y');

                    $price = $item['selected'][$x]['rate_price'] * count($item['selected_seats'][$x]);

                    $t = [
                        'type' => 'trip',
                        'van_name' => $item['selected'][$x]['van']->name,
                        'seats' => $seats,
                        'num_of_seats' => count($item['selected_seats'][$x]),
                        'destination' => "{$item['selected'][$x]['origin']->name} -> {$item['selected'][$x]['destination']->name}",
                        'departure_date' => "{$formatted_date} {$item['selected'][$x]['departure_time']}",
                        'price' => number_format($price,2),
                        'pickup_location' => $item['booking_information'][$x]['pickup_location'],
                        'drop_location' => $item['booking_information'][$x]['drop_location']
                    ];

                    $total_price += $price;
                    $trips[] = $t;
                }

                $item_list[] = $trips;

                // $details['Booking #'.$item['booking_num']] = [
                //     'Origin' => $item['origin_name'],
                //     'Destination' => $item['destination_name'],
                //     'Departure date' => $item['departure_date'],
                //     'Departure time' => $item['departure_time'],
                //     // 'Total' => "PHP " . number_format($item['price'] * count($data['seat_plan']),2)
                // ];


            }
        }
        
        ob_start();
        require APPPATH . "mail_template.php";
        $mail_string = ob_get_clean();

        $mail = $this->contact_model->initSettings();

        $mail->setFrom(getenv('EMAIL_FROM'));
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'booking';
        $mail->Body = $mail_string;
        if($mail->send()){

        }

        return $mail_string;
        

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

        if($offset == 1){
            $data['check_availability'] = $this->rev_from_to($data['check_availability']);
        }

        $seat_num_ids = [];

        $seat_num_ids_db = [];
            $datetime_time = (DateTime::createFromFormat('h:iA',$data['selected'][$offset]['departure_time']));
            
            //BEFORE UPDATE CHECK IF IT'S STILL AVAILABLE
            $seats_taken = $this->db->select('seat_plan.seat_num')
                                    ->from('seat_plan')
                                    ->join('carts','seat_plan.cart_id = carts.id')
                                    ->join('checkouts','checkouts.id = carts.checkout_id')
                                    ->join('rates','carts.rate_id = rates.id')
                                    ->join('trip_availability','trip_availability.id = seat_plan.trip_availability_id')
                                    ->where('carts.departure_date',"{$data['selected'][$offset]['from']} {$datetime_time->format('H:i:s')}")
                                    ->where('carts.departure_time',$data['selected'][$offset]['departure_time'])
                                    //   ->where('trip_availability.destination_from', $seat_plans[0]->destination_from)
                                    //   ->where('trip_availability.id',$seat_plans[0]->trip_availability_id)
                                    ->where('carts.status','reserved')
                                    ->get()->result();
                                    // d($seats_taken);
                                

                                    
            foreach($seats_taken as $taken){
                $seat_num_ids_db[] = $taken->seat_num;
            }
                     

        if($paid){
            // Add Reservation
            $cart = [
                'rate_id' => $rate->id,
                'checkout_id' => $data['checkout_id'],
                'departure_date' => format_date_and_time_for_sql("{$data['selected'][$offset]['from']} {$rate->departure_time}",$format = "Y-m-d H:i A"),
                'departure_time' => $rate->departure_time,
                'destination_id' => $data['check_availability']['destination_to']
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
                    $seat_num_ids[] = $seat['seatnum'];

                    $this->seatplan_model->add($seat_plan);
                }
                $bookinginfo = $data['booking_information'][$offset];
                $bookinginfo['cart_id'] = $id;
                $this->bookinginformation_model->add($bookinginfo);
            }
        }

        //check availability AGAIN
                
        $seats_taken = array_intersect($seat_num_ids,$seat_num_ids_db);
            if(count($seats_taken)){
                $d['errormsg'] = "Date {$data['selected'][$offset]['from']}<br>";
                $d['errormsg'].= implode(',',$seats_taken) . " seat";
                $d['errormsg'].= (count($seats_taken) == 1 ? " is" : " are") . " taken by other customers";
                return $d['errormsg'];
            }else{
                return true;
            }
        //END
    
        
        
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
            if($_SESSION['current_booking_data']['rate'] != []){ // rate
                $data['selected'] = $_SESSION['current_booking_data']['selected'];
            }else{
                return redirect(base_url('availability/check'));
            }
        }

        if($step >= 4){
            if($_SESSION['current_booking_data']['selected_seats'] != []){ // seatplan
                $data['selected_seats'] = $_SESSION['current_booking_data']['selected_seats'];
                $data['booking_information'] = $_SESSION['current_booking_data']['booking_information'];
                $data['type'] = 'booking_trip';
            }else{
                return redirect(base_url("availability/book/{$data['selected']['rate_id']}"));
            }
        }

        // var_dump($data); die();


        return $data;
    }

    public function process_payment(){
        return TRUE;
    }

    public function clearSess()
    {
        $this->session->sess_destroy();
    }

    public function getSeatPlan($rate,$post_data,$booking_num = null){
        //GET VAN LAYOUT
        $data['seat_map'] = $this->rate_model->getVanlayoutByRateId($rate->id); 
        
        $data['seats_length_class'] = $this->seatsLengthClass($this->seatsLength($data['seat_map']));

        //GET OCCUPIED SEATS
        $data['occupied_seat_map'] = $this->seatplan_model->getOccupiedSeatsByRate($rate,$post_data['departure_from']);
        
        //GET SELECTED SEATS IN CART
        $data['pending_seat_map'] = $this->seatplan_model->getPendingSeatsByRateAndDate($rate,$post_data['departure_from'],$booking_num);
        //todo GET CURRENT SEATS IN SESSION
        $data['current_seat_map'] = $this->seatplan_model->getCurrentSeatsByRateId($rate->id,0);

        // SET SESSION
        $data['selected'] = [
            'from' => $post_data['departure_from'],
            'origin' => $this->destination_model->findById($post_data['destination_from']),
            'destination' => $this->destination_model->findById($post_data['destination_to']),
            'rate_id' => $rate->id,
            'rate_price' => $rate->price,
            'trip_availability_id' => $rate->trip_availability_id,
            'departure_time' => $rate->departure_time,
            'van' => $this->van_model->getVanByRateId($rate->id)
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

    public function seatsLength($seat_map){
        $total = 0 ;
        foreach($seat_map as $seatnum){
            if(is_string($seatnum)){
                $seatnum = (int)$seatnum;
            }
            $total += $seatnum;

        }
        return $total;
    }

    public function seatsLengthClass($length){

        if($length <= 18){
            return "18-seater";
        }elseif( $length <= 16){
            return "16-seater";
        }elseif( $length <= 14){
            return "14-seater";
        }elseif($length <= 12){
            return "12-seater";
        }
        
    }

    public function generateCart(){
        $this->cart_model->itemsWithPrices();
    }

    /**
     * $args['type'] = "oneway" or "roundtrip"
     * $args['rates'] = [[rate_for_departure],[rate_for_return]]
     */
    public function getSeatplanDetails($args){
        $offset = ($args['type'] == "oneway" ? 0 : 1);
        


        // focus on the first element of the array
        $rate = $args['rates'][$offset];

        

        // get rate
        $rate = !is_string($rate) ? $rate : $this->rate_model->findById($rate);

        // clear booking data in session
        if($args['type'] == "oneway" && !isset($_SESSION['current_booking_data']['rate'])){
            $_SESSION['current_booking_data']['post_data'] = [];
            $_SESSION['current_booking_data']['rate'] = [];
        }


        if(count($_SESSION['current_booking_data']['rate']) == 0){
            $_SESSION['current_booking_data']['rate'][] = $rate;
        }

        if(count($args['rates']) == 2 && $offset == 0 && count($_SESSION['current_booking_data']['rate']) != 2){
            $_SESSION['current_booking_data']['rate'][] = $this->rate_model->findById($args['rates'][1]);
        }


        // get data
        if($this->session->has_userdata('check_availability')){
            if($offset == 0){
                $post_data = $this->session->userdata('check_availability');
            }elseif($offset == 1){
                $post_data = $this->rev_from_to($this->session->userdata('check_availability'));
            }
        }

        //get seatplan
        $data = $this->getSeatPlan($rate,$post_data,$args['booking_num']);

        if($offset == 0){
            $_SESSION['current_booking_data']['selected'] = [];
        }
        $_SESSION['current_booking_data']['selected'][] = $data['selected'];
    

        $data['booking_information'] = isset($_SESSION['current_booking_data']['booking_information']) && $offset == 0 ? $_SESSION['current_booking_data']['booking_information'][$offset] : (object)['pickup_location' => "", 'drop_location' => ""];

        // d($offset == 0 && count($args['rates']) == 1);
        $last_seat_selection = ($offset == 0 && count($args['rates']) == 1) || ($offset == 1 && count($args['rates']) == 2);


        $data['label'] = $args['label'];
        $data['offset'] = $offset;
        $data['post_url'] = $last_seat_selection ? base_url('availability/summary') : base_url('availability/book_return');
        $data['back_url'] = $last_seat_selection && !(count($args['rates']) == 1) ? base_url('availability/book_departure') : base_url('availability/check');

        return $data;
    }

    public function setCurrentDataByBookingNum($booking_num){
        $cart = $_SESSION['cart'];

        $data = [];
        for($x = 0; $x < count($cart); $x++){
            if($cart[$x]['booking_num'] == $booking_num){
                $data = $cart[$x];
                break;
            }
            $data = false;
        }

        if($data){

            $res['rate'] = [];
            foreach($data['selected'] as $selected){
                $res['rate'][] = $this->rate_model->findById($selected['rate_id']);
            }
            $res['selected'] = $data['selected'];
            $res['selected_seats'] = $data['selected_seats'];
            $res['booking_information'] = $data['booking_information'];

            return $res;
        }else{
            return false;
        }
    }
    
}