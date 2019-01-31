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
        $rate_time = $rate_datetime->format('h:i:s');
                
        $occupied_seat_map = [];

        $occupied_seats = $this->db->select('seat_plan.*')
                                    ->from('seat_plan')
                                    ->join('carts', 'seat_plan.cart_id = carts.id')
                                    ->join('rates', 'carts.rate_id = rates.id')
                                    ->join('trip_availability', 'trip_availability.id = rates.trip_availability_id')
                                    ->where('carts.departure_date',"{$date} {$rate_time}")
                                    ->where('rates.trip_availability_id',$rate->trip_availability_id)
                                    ->get()->result();
        foreach($occupied_seats as $occupied_seat){
            $occupied_seat_map[] = (int)$occupied_seat->seat_num;
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

        if($this->session->has_userdata('cart')){
            $cart_in_session = $this->session->userdata('cart');
            
            foreach($cart_in_session as $cart){

                

                if( $cart['selected'][$offset]['trip_availability_id'] == $rate->trip_availability_id &&
                    $cart['selected'][$offset]['from'] == $date
                ){
                    $pending_seat_map[] = array_merge($pending_seat_map,$cart['selected_seats'][$offset]);
                        

                }
            }
            if($offset ==1 ){
                var_dump($pending_seat_map); die();

            }
            foreach($pending_seat_map as $seat){
                $seats_num[] = (int)$seat['seatnum'];
            }

            return $seats_num[$offset];
        }

        return $seats_num;



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
    
}