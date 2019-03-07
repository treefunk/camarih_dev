<?php

class Rate_model extends CMS_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = "rates";
    }

    public function getVanlayoutByRateId($id)
    {
        $seat_map = $this->db->select('rates.*, vans.seat_map')
                             ->from('rates')
                             ->join('trip_availability','rates.trip_availability_id = trip_availability.id')
                             ->join('vans','trip_availability.van_id = vans.id')
                             ->where('rates.id',$id)
                             ->get()->row()->seat_map;

        return explode(',',$seat_map);
    }


    
}