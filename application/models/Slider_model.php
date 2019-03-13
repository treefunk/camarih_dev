<?php

class Slider_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "sliders";
    }

    public function getAllQuery()
    {
        return $this->db->from('sliders');
    }

    
}