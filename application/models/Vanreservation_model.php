<?php

class Vanreservation_model extends CMS_Model
{
    public $dt;

    public function __construct()
    {
        parent::__construct();
        // $this->load->model([
        //     'c_model'
        // ]);
        $this->dt = new DateTimeZone('Asia/Hong_Kong');
    }

    public function getAllQuery($getResult = false)
    {
        $query = $this->db
        ->select("
        checkouts.fullname,
        checkouts.email,
        checkouts.phone,
        van_rent.*,
        origin_destination.name as origin_name,
        destinations.name as destination_name,
        vans.name as van_name
        ")
        ->from('van_rent')
        ->join('destinations as origin_destination','van_rent.origin_id = origin_destination.id')
        ->join('destinations','van_rent.destination_id = destinations.id')
        ->join('vans', 'vans.id = van_rent.van_id')
        ->join('checkouts', 'checkouts.id = van_rent.checkout_id');

        if($getResult){
            return $query->get()->result();
        }

        return $query;
                          
    }

//     van_id: (string) "1"
// destination_id: (string) "4"
// departure_start: (string) "03/01/2019"
// departure_end: (string) "03/31/2019"
// trip_type: (string) "oneway_trip"
// status: (string) "completed"

    public function filterVan(&$query,$van_id)
    {
        $query->where('van_id',$van_id);
        return true;
    }

    public function filterDestination(&$query,$destination_id)
    {
        $query->where('destination_id',$destination_id);
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
        $end = $this->formatDate($args['departure_end']);

        $query->where('departure_date <=', $end)
              ->where('departure_date >=', $start);

        return true;
    }

    public function filterTripType(&$query, $trip_type){
        $query->where('trip_type',$trip_type);
        return true;
    }

    public function filterStatus(&$query,$status){
        $query->where('van_rent.status',$status);
        return true;
    }

    public function filterSearch(&$query,$search){
        $query->like('CONCAT(
        checkouts.fullname,
        vans.name,
        origin_destination.name,
        destinations.name,
        van_rent.price,
        van_rent.departure_date,
        van_rent.status,
        van_rent.trip_type
        )',$search);
        return true;
    }






    
}