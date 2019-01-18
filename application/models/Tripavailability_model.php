<?php

class Tripavailability_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "trip_availability";
    }

    public function all()
    {
        $trips = $this->initRelations_array(parent::all());
        
        return $trips;

    }

    public function initRelations($trip_availability,$only = ['rates','van','origin'])
    {
        $id = $trip_availability->id;

        // rates
        if(in_array('rates',$only)){
            $rates = $this->getRates($trip_availability);
                
            $trip_availability->rates = $rates;
        }

        // vans
        if(in_array('van',$only)){        
            
            $van = $this->getVan($trip_availability);

            $trip_availability->van = $van;
        }

        // origin
        if(in_array('origin',$only)){
            $origin = $this->getOrigin($trip_availability);
            
            $trip_availability->origin = $origin;
        }
        
        return $trip_availability;
    }

    public function initRelations_array($trips_array)
    {
        foreach($trips_array as $trip){
            $trip = $this->initRelations($trip);
        }
        return $trips_array;
    }

    public function getRates($trip_availability)
    {
        $rates = $this->db->select('destinations.name,rates.*')
                              ->from('destinations')
                              ->join('rates','destinations.id = rates.destination_id')
                              ->where('trip_availability_id',$trip_availability->id)->get()->result();
        return $rates;    
    }

    public function getVan($trip_availability)
    {
        $van = $this->db->select('vans.*,trip_availability.van_id')
                        ->from('vans')
                        ->join('trip_availability','vans.id = trip_availability.van_id')
                        ->where('trip_availability.id',$trip_availability->id)
                        ->get()
                        ->row();
        return $van;
    }

    public function getOrigin($trip_availability)
    {
        $origin = $this->db->select('destinations.*,trip_availability.destination_from')
                           ->from('destinations')
                           ->join('trip_availability','destinations.id = trip_availability.destination_from')
                           ->where('trip_availability.id',$trip_availability->id)
                           ->get()
                           ->row();
        return $origin;

    }
    

    /**
     * Admin Edit Page's Data
     */
    public function formatForEdit($trip_availability){

        $rawDate = $trip_availability->departure_date;

        //replace departure_date and format
        $trip_availability->departure_date = format_datetime_string($rawDate,'m/d/Y'); 
        $trip_availability->departure_time = format_datetime_string($rawDate,'h:i A');

        //remove the time labels in selling_start and selling_end
        $trip_availability->selling_start = format_datetime_string($trip_availability->selling_start,'m/d/Y'); 
        $trip_availability->selling_end = format_datetime_string($trip_availability->selling_end,'m/d/Y'); 

        $trip_availability = $this->initRelations($trip_availability);
        return $trip_availability;
    }




    /**
     * Client Check Availability
     * 
     * According to client:
     * Checking of day availability (from/to date/destination)
     * - seat planning (seat position)
     * - choosing a package
     * 
     * sample $_POST layout
     * destination_from: (string) "4"
     * departure_from: (string) "2019-01-09"
     * destination_to: (string) "3"
     * departure_to: (string) "2019-01-17"
     * 
     */
    public function checkAvailability($post)
    {
        $dt = new DateTimeZone('Asia/Hong_Kong');
        $post['departure_from'] = DateTime::createFromFormat('Y-m-d',$post['departure_from'],$dt)->format('Y-m-d') . " 00:00:00";
        $post['departure_to'] = DateTime::createFromFormat('Y-m-d',$post['departure_to'],$dt)->format('Y-m-d') . " 23:59:59";

        $today = (new DateTime('now',$dt))->format('Y-m-d H:i:s');

                                // TODO join seat plan here!
        $trips = $this->db->select('trip_availability.*, 
                                    vans.name as van_name,
                                    rates.id as rate_id, rates.price as rate_price,rates.destination_id as destination_id')
                          // join van
                          ->join('vans', 'trip_availability.van_id = vans.id')
                          // join rate
                          ->join('rates','trip_availability.id = rates.trip_availability_id')
                          ->from('trip_availability')
                          // check all departure dates within the date range selected
                          ->where("trip_availability.departure_date >=",$post['departure_from'])
                          ->where("trip_availability.departure_date <=",$post['departure_to'])
                          // check if today's date is in selling date range
                          ->where("trip_availability.selling_start <=", $today)
                          ->where("trip_availability.selling_end >=", $today)
                          // only to this origin
                          ->where("trip_availability.destination_from",$post['destination_from'])
                          // only to this destination
                          ->where("rates.destination_id",$post['destination_to'])
                          ->get()->result();
        return $trips;
    }

    
}