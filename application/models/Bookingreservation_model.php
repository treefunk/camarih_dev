<?php

class Bookingreservation_model extends CMS_Model
{
    public $dt;

    public function __construct()
    {
        parent::__construct();
        // $this->load->model([
        //     'c_model'
        // ]);
        $this->table = "carts";
        $this->dt = new DateTimeZone('Asia/Hong_Kong');
    }

    public function getAllQuery($getResult = false){
        $booking_reservations = $this->db->select("
        carts.id,
        checkouts.fullname,
        checkouts.email,
        checkouts.phone,
        trip_availability.destination_from as origin_id,
        trip_availability.van_id as van_id,
        carts.departure_date,
        carts.departure_time,
        carts.status,
        carts.checkout_id,
        rates.destination_id,
        rates.price,
        tr.name as origin_name,
        r.name as destination_name,
        vans.name as van_name,
        carts.created_at,
        ")
        ->from('carts')
        ->join('rates','rates.id = carts.rate_id')
        ->join('trip_availability','trip_availability.id = rates.trip_availability_id')
        //get destination names
        ->join('destinations as tr','tr.id = trip_availability.destination_from')
        ->join('destinations as r', 'r.id = carts.destination_id')
        //get van name
        ->join('vans','vans.id = trip_availability.van_id')
        //get user info
        ->join('checkouts', 'checkouts.id = carts.checkout_id');


        if($getResult){
            return $booking_reservations->get()->result();
        }

        return $booking_reservations;
    }

    public function getAllFormatted(){
        $booking_reservations = $this->getAllQuery(true);
    }

    public function filterOrigin(&$query, $origin_id)
    {
        $query->where('destination_from',$origin_id);
        return true;
    }

    public function filterDestination(&$query,$destination_id)
    {
        $query->where('carts.destination_id',$destination_id);
        return true;
    }

    public function formatDate($date,$start = true){
        if($start){
            $timeformat = explode(":","00:00:00");
        }else{
            $timeformat = explode(":","23:59:59");
        }
        $date = DateTime::createFromFormat('m/d/Y',$date,$this->dt)->setTime($timeformat[0],$timeformat[1],$timeformat[2]);
        return $date->format('Y-m-d H:i:s');
    }

    public function filterDepartureDate(&$query,$args){
        $start = $this->formatDate($args['departure_start']);
        $end = $this->formatDate($args['departure_end'],false);

        $query->where('departure_date <=', $end)
              ->where('departure_date >=', $start );

        return true;
    }

    public function filterVan(&$query,$van_id){
        $query->where('van_id',$van_id);
        return true;
    }

    public function filterStatus(&$query , $status){
        $query->where('carts.status',$status);
        return true;
    }

    public function filterSearch(&$query, $search){
        
        $query->like('
        CONCAT(checkouts.fullname,
        tr.name,r.name,
        vans.name,
        carts.departure_date,
        carts.departure_time,
        carts.status
        )',$search);

        return true;
    }

    
}