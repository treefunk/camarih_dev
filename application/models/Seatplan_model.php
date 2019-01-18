<?php

class Seatplan_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "seat_plan";
    }
    
}