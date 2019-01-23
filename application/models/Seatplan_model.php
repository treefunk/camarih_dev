<?php

class Seatplan_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "seat_plan";
    }

    public function getOccupiedSeatsByRateId($rate_id,$as_array_of_objects = false)
    {

        $occupied_seat_map = [];

        $occupied_seats = $this->db->select('seat_plan.*')
                                ->from('seat_plan')
                                ->join('reservations', 'seat_plan.reservation_id = reservations.id')
                                ->join('rates', 'reservations.rate_id = rates.id')
                                ->where('rates.id',$rate_id)
                                ->get()->result();
        if($as_array_of_objects){
            return $occupied_seats;
        }
        foreach($occupied_seats as $occupied_seat){
            $occupied_seat_map[] = (int)$occupied_seat->seat_num;
        }
        
        return $occupied_seat_map;
    }

    public function getPendingSeatsByRateId($rate_id)
    {
        $pending_seat_map = [];

        if($this->session->has_userdata('cart')){
            $cart_in_session = $this->session->userdata('cart');
            foreach($cart_in_session as $cart){
                if($cart['selected']['rate_id'] == $rate_id){
                    $pending_seat_map = array_merge($pending_seat_map,$cart['selected_seats']);
                }
            }
        }


        $seats_num = [];
        foreach($pending_seat_map as $seat){
            $seats_num[] = (int)$seat['seatnum'];
        }

        return $seats_num;
    }

    public function getCurrentSeatsByRateId($rate_id)
    {
        $current_seats = [];

        if($rate_id == $this->session->userdata('selected')['rate_id']
            && $this->session->has_userdata('selected') 
            && $this->session->has_userdata('selected_seats')){

            $seats= $this->session->userdata('selected_seats');
            foreach($seats as $seat){
                $current_seats[] = (object)[
                    'seatnum' => (int)$seat['seatnum'],
                    'bday' => $seat['bday'],
                    'name' => $seat['name'],
                    'isOccupied' => false,
                    'isPending' => false,
                    'selected' => true,
                ];

            }
        }

        return $current_seats;
    }
    
}