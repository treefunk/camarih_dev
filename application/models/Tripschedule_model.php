<?php

class Tripschedule_model extends CMS_Model{

    public function __construct(){
        
        parent::__construct();
        $this->table = "trip_schedule";
    }

    public function count(){
        return $this->db->from('trip_schedule')->get()->num_rows();
    }

    public function allByTripNum($direction = 'ASC'){
        return $this->db->from('trip_schedule')->order_by('trip_num',$direction)->get()->result();
    }
}