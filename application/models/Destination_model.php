<?php

class Destination_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "destinations";
    }

    public function getAllOrigins()
    {
        $query = $this->db->from('destinations');
        $query->where('is_origin',1);
        $query->order_by('name');
        return $query->get()->result();

    }

    public function all()
    {
        $query = $this->db->from('destinations');
        $query->order_by('name');
        return $query->get()->result();
    }

    public function getAllEndpoints()
    {
        $query = $this->db->from('destinations');
        $query->where('is_dropoff',1);
        $query->order_by('name');
        return $query->get()->result();
    }

    public function getAllVanRentOrigins()
    {
        $query = $this->db->from('destinations');
        $query->where('is_vanrental_origin',1);
        $query->order_by("name");
        return $query->get()->result();
    }

    public function getAllVanRentDropoff()
    {
        $query = $this->db->from('destinations');
        $query->where('is_vanrental_dropoff',1);
        $query->order_by("name");
        return $query->get()->result();
    }



    
}