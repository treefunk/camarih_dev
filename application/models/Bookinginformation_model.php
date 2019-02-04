<?php

class Bookinginformation_model extends CMS_Model{

    public function __construct(){
        parent::__construct();
        $this->table = "booking_information";
    }
}