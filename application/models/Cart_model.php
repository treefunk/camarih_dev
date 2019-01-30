<?php

class Cart_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "carts";
    }

    public function removeItem($index)
    {
        
    }

    public function clearCurrentCartSession()
    {
        unset($_SESSION['selected_seats']);
        unset($_SESSION['selected']);
        unset($_SESSION['selected_rate']);
        unset($_SESSION['selected_package']);
        unset($_SESSION['selected_rate']);
        unset($_SESSION['bup_seats']);
        unset($_SESSION['bup_data']);
        return true;
    }

    
}