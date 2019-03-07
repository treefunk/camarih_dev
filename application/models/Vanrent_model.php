<?php

class Vanrent_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "van_rent";
    }

//  van   stdClass (object) [Object ID #19][9 properties]
// departure_date: (string) "2019-02-28"
// trip_type: (string) "oneway_trip"
// origin: 
// stdClass (object) [Object ID #20][6 properties]
// destination: 
// stdClass (object) [Object ID #21][6 properties]
// price: (string) "150"
// booking_num: (string) "5c74ea1b9dcd2"
// item_type: (string) "booking_van"
// reservation_id: (integer) 2 

}