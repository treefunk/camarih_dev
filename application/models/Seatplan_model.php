<?php

class Seatplan_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "seat_plan";
    }

    public function getOccupiedSeatsByRate($rate,$date)
    {
        $rate_id = $rate->id;
        $rate_datetime = DateTime::createFromFormat("H:i A",$rate->departure_time, new DateTimeZone('Asia/Hong_Kong'));
        $rate_string = $rate_datetime->format(DateTime::ISO8601);
        $rate_time = $rate_datetime->format('h:i A');
    
        $occupied_seat_map = [];

        

        $occupied_seats = $this->db->select('seat_plan.*')
                                    ->from('seat_plan')
                                    ->join('carts', 'seat_plan.cart_id = carts.id')
                                    ->join('rates', 'carts.rate_id = rates.id')
                                    ->join('trip_availability', 'trip_availability.id = rates.trip_availability_id')
                                    ->where('carts.departure_time',$rate_time)
                                    ->where('rates.trip_availability_id',$rate->trip_availability_id)
                                    ->get()->result();
    
        
        foreach($occupied_seats as $occupied_seat){
            $add = false;
            $carts = $this->db->select('carts.*')
                              ->from('rates')
                              ->join('trip_availability','trip_availability.id = rates.trip_availability_id')
                              ->join('carts', 'carts.rate_id = rates.id')
                              ->get()
                              ->result();
            foreach($carts as $cart){
                // var_dump(format_datetime_string($cart->departure_date,'Y-m-d')); die();
                if((format_datetime_string($cart->departure_date,'Y-m-d') == $date)){
                    $add = true;
                }
            }

            if($add){
                $occupied_seat_map[] = (int)$occupied_seat->seat_num;
            }
            
        }
    

        
        return $occupied_seat_map;
    }

    public function getPendingSeatsByRate($rate,$date,$offset = 0)
    {
        
        $rate_id = $rate->id;
        $rate_datetime = DateTime::createFromFormat("H:i A",$rate->departure_time, new DateTimeZone('Asia/Hong_Kong'));
        $rate_time = $rate_datetime->format('h:i:s');



        $pending_seat_map = [];
        $seats_num = [];
        $test = [];
        $new = [0 => [],1 => []];

        $cart_in_session = $this->session->userdata('cart');

        //loop inside cart

            // check if this seat rate matches in db
        if($cart_in_session){
            foreach($cart_in_session as $cart){
                if( isset($cart['selected'][$offset]) && $cart['selected'][$offset]['trip_availability_id'] == $rate->trip_availability_id &&
                    $cart['selected'][$offset]['from'] == $date
                ){
                    $pending_seat_map = array_merge($pending_seat_map,$cart['selected_seats']);
                    $test[] = $cart['selected_seats'];
                }
            }

            for($y = 0 ; $y < count($pending_seat_map); $y++){
            foreach($pending_seat_map[$y] as $s){
                $seats_num[$y][] = (int)$s['seatnum'];
            }
            
        }
        
        
        
        // for($z = 0 ; $z < count($seats_num); $z++){
        //     if($z == 0 || $z == 2){
        //         $new[0][] = $seats_num[$z]
        //     }
        // }

        $i = 0;
        foreach($seats_num as $s){
            $b = 0;
            foreach($s as $p){
                if(count($p) == 1){
                    $new[0][] = $p;
                }else{
                    $new[1][] = $p;
                }
                
            }
            $i++;
        }
    

        }

        return $new;



    }

    public function getCurrentSeatsByRateId($rate_id,$offset)
    {
        $current_seats = [];

        if(isset($_SESSION['selected'][$offset])
            && isset($_SESSION['selected_seats'][$offset])
            && $rate_id == $_SESSION['selected'][$offset]['rate_id']){

            $seats = $_SESSION['selected_seats'][$offset];

            foreach($seats as $seat){
                $current_seats[] = (object)[
                    'seatnum' => (int)$seat['seatnum'],
                    'bday' => $seat['bday'],
                    'name' => $seat['name'],
                    'selected' => TRUE
                ];

            }
        }

        return $current_seats;
    }

    public function getPendingSeatsByRateAndDate($rate,$date){
     
        $pending_seats = [];

        $return_index = -1;
        
        //get the cart in session
        if($this->session->has_userdata('cart') && count($cart = $this->session->userdata('cart'))){
            // var_dump($cart); die();
            foreach($cart as $item)
            {
                if($item['item_type'] == 'booking_van'){ continue; }
                $to_add = false;
                
                $index = 0;
                
                foreach($item['selected_seats'] as $seat_group)
                {
                    if($item['selected'][$index]['from'] == $date && $rate->trip_availability_id == $item['selected'][$index]['trip_availability_id']){
                        $return_index = $index;
                        $to_add = true;
                    }

                    foreach($seat_group as $seat){
                        if($to_add){
                            $pending_seats[$index][] = (int)$seat['seatnum'];
                        }
                    }
                    $index++;
                }
                
                
            }
        }else{
            return [];
        }

        if($return_index != -1){
            if(array_key_exists($return_index,$pending_seats)){
                return $pending_seats[$return_index];
            }else{
                return [];
            }
        }else{
            return [];
        }


    }
    
}