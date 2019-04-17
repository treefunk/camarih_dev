<?php

class Cart_model extends CMS_Model
{
    public $dt;

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'rate_model'
        ]);
        $this->table = "carts";
        $this->dt = new DateTimeZone('Asia/Hong_Kong');
    }

    public function removeItem($index)
    {
        
    }

    public function clearCurrentCartSession()
    {
        unset($_SESSION['selected_seats']);
        unset($_SESSION['selected']);
        unset($_SESSION['selected_rate']);
        unset($_SESSION['selected_package']);
        unset($_SESSION['selected_rate']);
        unset($_SESSION['current_booking_data']);        
        return true;
    }

    public function itemsWithPrices($cart)
    {

        
        if(!$cart){ // cart is empty
            return false;
        }


        $items = [];

        foreach($cart as $item)
        {
            $index = 0;

            if($item['item_type'] == 'booking_trip'){
                $this->formatBookingTrip($item,$index,$items);
            }elseif($item['item_type'] == 'booking_van'){
                $this->formatBookingVan($item,$index,$items);
            }elseif($item['item_type'] == 'booking_package'){
                $this->formatBookingPackage($item,$index,$items);
            }
            


            $index++;
            
        }

        return $items;

    }


    private function formatBookingTrip($item,$index,&$items)
    {

            $booking_key = "booking_trip";

            if(!array_key_exists($booking_key,$items)){
                $items[$booking_key] = [];
            }

            foreach($item['selected'] as $i => $selected){

                $datetime_from = DateTime::createFromFormat('Y-m-d',$selected['from'],$this->dt);
                $date = $datetime_from->format('m/d/y');
                
                $trip_name = "{$selected['origin']->name} TO {$selected['destination']->name}";
                $rate = $this->rate_model->findById($selected['rate_id']);

                $trip = [
                    'name' => $trip_name,
                    'short' => "{$date} {$selected['origin']->short_name} TO {$selected['destination']->short_name}",
                    'date' => $selected['from'],
                    'departure_time' => $rate->departure_time
                ];

                $trip['items'] = [];

                $test = [];
                foreach($item['selected_seats'][$i] as $seat){
                    // $test[] = $seat;
                    $trip['items'][] = [
                        'name' => $seat['seatnum'],
                        'passenger' => $seat['name'],
                        'description' => $trip_name,
                        'quantity' => 1,
                        'currency' => "PHP",
                        'seatnum' => $seat['seatnum'],
                        'price' => $selected['rate_price']
                    ];
                }
                // for($x = 0; $x < count($item['selected_seats']); $x++){
                //         for($y = 0; $y < count($item['selected_seats'][$x]); $y++){
                //             $trip['items'][] = [
                //                 'name' => $item['selected_seats'][$x][$y]['seatnum'],
                //                 'passenger' => $item['selected_seats'][$x][$y]['name'],
                //                 'description' => $trip_name,
                //                 'quantity' => 1,
                //                 'currency' => "PHP",
                //                 'seatnum' => $item['selected_seats'][$x][$y]['seatnum'],
                //                 'price' => $selected['rate_price']
                //             ];
                //         }
                // }

                $items[$booking_key][] = $trip;
            }
    }

    private function formatBookingVan($item,$index,&$items){
        $van_id = $item['van']->id;
        $van_key = "booking_van";

        if(!array_key_exists($van_key,$items)){
            $items[$van_key] = [];
        }

        if(!array_key_exists($van_id,$items[$van_key])){
            $items[$van_key][$van_id] = [];
        }

        $datetime_from = DateTime::createFromFormat('Y-m-d',$item['departure_date'],$this->dt);
        $date = $datetime_from->format('m/d/y');
        //format item

        $van_trip = [
            'van_name' => $item['van']->name,
            'date' => $date,
            'trip_type' => $item['trip_type'] == "oneway_trip" ? "One-way Trip" : "Round-trip",
            'description' => "{$item['origin']->short_name} TO {$item['destination']->short_name}",
            'price' => $item['price']
        ];
    
        $items[$van_key][$van_id][] = $van_trip;
    
    }

    private function formatBookingPackage($item,$index,&$items){

        $package_key = "booking_package";

        if(!array_key_exists($package_key,$items)){
            $items[$package_key] = [];
        }

        $package_trip = [
            'package_name' => $item['name'],
            'rate' => $item['rate'],
            'price' => ((float)$item['rate']) * $item['adult_count'] ,
            'adult_count' => $item['adult_count']
        ];

        $items[$package_key][] = $package_trip;

    }

    function filterChecked($cart,$booking_array){
        
        $result = [];

        foreach($cart as $item){
            if(in_array($item['booking_num'],$booking_array)){
                $result[] = $item;
            }
        }

        return $result;
    }
    
}