<?php

class Packagedetail_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "package_details";
    }
    
}