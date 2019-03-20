<?php

class Cart_model extends CMS_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'rate_model'
        ]);
        $this->table = "carts";
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

    public function itemsWithPrices()
    {
        if(!$this->session->has_userdata('cart')){ // cart is empty
            return false;
        }

        $cart = $this->session->userdata('cart');

        $items = [];
        foreach($cart as $item)
        {
            $index = 0;
            foreach($item['selected'] as $selected){
                $trip_name = "{$selected['origin']->name} TO {$selected['destination']->name}";
                $rate = $this->rate_model->findById($selected['rate_id']);
                $trip = [
                    'name' => $trip_name,
                    'short' => "{$selected['origin']->short_name} TO {$selected['destination']->short_name}",
                    'date' => $selected['from'],
                    'departure_time' => $rate->departure_time
                ];

                $trip['items'] = [];
                foreach($item['selected_seats'][$index] as $seat){
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
                $items[] = $trip;
                $index++;
            }
            
        }

        return $items;

    }

    
}