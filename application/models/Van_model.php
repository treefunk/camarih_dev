<?php

class Van_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "vans";
    }

    public function getTotalSeats($van)
    {
        $totalSeats = 0;
        $seatplan =  explode(',',$van->seat_map);
        foreach($seatplan as $seatrow)
        {
            $totalSeats += $seatrow;
        }

        return $totalSeats;
    }
    
}