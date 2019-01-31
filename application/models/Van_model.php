<?php

class Van_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "vans";
        $this->load->model('vandetail_model');
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

    public function allWithRates(){
        $q = $this->db->select('vans.*,van_details.oneway_rate,van_details.roundtrip_rate')
                      ->from('vans')
                      ->join('van_details','vans.id = van_details.van_id');

        return $q->get()->result();
    }

    public function find($id){
        $van = $this->findById($id);

        $van_details = $this->db->get_where('van_details',[
            'van_id' => $van->id
        ])->row();

        $van->van_details = $van_details;

        return $van;
    }
    
}