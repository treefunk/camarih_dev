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
                      ->join('van_details','vans.id = van_details.van_id')
                      ->order_by('vans.created_at');

        $vans = $q->get()->result();

        foreach($vans as $van){
            $van->van_gallery = $this->db->get_where('van_gallery',['van_id' => $van->id])->result();
            $van->van_rates = $this->db->from('van_rate')
                                       ->join('destinations','van_rate.destination_id = destinations.id')
                                       ->where(['van_id' => $van->id])
                                       ->order_by('name','ASC')
                                       ->get()
                                       ->result();
            if(count($van->van_rates)){
                foreach($van->van_rates as &$r){
                    $r->destination = $this->db->get_where('destinations',['id' => $r->destination_id])->row();
                    $r->origin = $this->db->get_where('destinations',['id' => $r->origin_id])->row();
                }
            }
        }
        return $vans;
    }

    public function allWithRatesP()
    {
        $q = $this->db->select('vans.*,van_details.oneway_rate,van_details.roundtrip_rate')
                      ->from('vans')
                      ->join('van_details','vans.id = van_details.van_id')
                      ->order_by('vans.created_at');

        $vans = $q->get()->result();

        foreach($vans as $van){
            $van->van_gallery = $this->db->get_where('van_gallery',['van_id' => $van->id])->result();
            $van->van_rates = $this->db->from('van_rate')
                                       ->join('destinations','van_rate.destination_id = destinations.id')
                                       ->where(['van_id' => $van->id])
                                       ->order_by('name','ASC')
                                       ->get()
                                       ->result();
            if(count($van->van_rates)){
                foreach($van->van_rates as &$r){
                    $r->destination = $this->db->get_where('destinations',['id' => $r->destination_id])->row();
                    $r->origin = $this->db->get_where('destinations',['id' => $r->origin_id])->row();
                }
            }
        }
        return $vans;
    }

    public function find($id){
        $van = $this->findById($id);

        $van_details = $this->db->get_where('van_details',[
            'van_id' => $van->id
        ])->row();

        $van_gallery = $this->db->get_where('van_gallery',[
            'van_id' => $van->id
        ])->result();

        $van_rates = $this->db->get_where('van_rate',[
            'van_id' => $van->id
        ])->result();

        $van->van_rates= $van_rates;
        $van->van_details = $van_details;
        $van->van_gallery = $van_gallery;
        return $van;
    }

    public function checkVanAvailability($data)
    {
        /**
         * date: mm/dd/yyyy
         * origin_id
         * destination_id
         * trip_type
         */
    }

    public function getVanAvailability($van_id,$date,$origin_id,$destination_id)
    {
        //get van count
        $van_count = $this->db->get_where('vans',[
            'id' => $van_id
        ])->count();


        //date format Y-m-d H:i:s
        //query count of all van hire with the date/origin/destination
        $van_hire_count = $this->db->get_where('van_hire',[
            'van_id' => $van_id,
            'origin_id' => $origin_id,
            'destination_id' => $destination_id,
            'rent_date' => $date
        ])->count();


        //decrement van count
        $van_count-=$van_hire_count;
        //return available count

        var_dump($van_count); die();
        return $van_count;
    }




    public function getVanRatesById($id){ 

        $rates = $this->db->get_where('van_rates',[
            'van_id' => $id
        ])->result();

        return $rates;
    }

    public function all(){
        $query = $this->db->from('vans');
        $query->order_by('name');
        return $query->get()->result();
    }

    public function getAllQuery(){
        return $this->db->from('vans');
    }

    public function getVanByRateId($rate_id){
        return $this->db->select('vans.*')
                        ->from('rates')
                        ->join('trip_availability','rates.trip_availability_id = trip_availability.id')
                        ->join('vans','vans.id = trip_availability.van_id')
                        ->where('rates.id',$rate_id)
                        ->get()->row();
    }

    


    
}