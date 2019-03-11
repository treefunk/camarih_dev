<?php

class Vanrent_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "van_rent";
    }
}