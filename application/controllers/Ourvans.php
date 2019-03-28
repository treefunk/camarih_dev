<?php

class Ourvans extends MY_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model([
            'van_model',
            'destination_model',
            'vanrate_model',
            'vanrent_model'
        ]);
    }

    public function index()
    {
        $data['vans'] = $this->van_model->allWithRates();
        $data['origins'] = $this->destination_model->getAllOrigins();
        $data['destinations'] = $this->destination_model->getAllEndpoints();
        $data['destinations_vanrent'] = $this->destination_model->getAllVanRentDropoff();
        $data['origins_vanrent'] = $this->destination_model->getAllVanRentOrigins();
        $data['minDate'] = (new DateTime('now',new DateTimeZone('Asia/Hong_Kong')))->format('Y-m-d');
        $this->wrapper([
            'data' => $data,
            'view' => 'our_vans'
        ]);
    }

    public function rent($van_id){
        $post = json_decode(file_get_contents("php://input"));


        $van_rate = $this->db->get_where('van_rate',[
            'van_id' => $van_id,
            'origin_id' => $post->origin_id,
            'destination_id' => $post->destination_id
        ])->row();

        $van = $this->db->get_where('vans',['id' => $van_id])->row();
        $origin = $this->db->get_where('destinations',['id' => $post->origin_id])->row();
        $destination = $this->db->get_where('destinations',['id' => $post->destination_id])->row();

        $data = [
            'van' => $van,
            'departure_date' => $post->date,
            'trip_type' => $post->trip_type,
            'origin' => $origin,
            'destination' => $destination,
            'price' => $post->trip_type == 'oneway_trip' ? $van_rate->oneway_rate : $van_rate->roundtrip_rate
        ];


        if($this->add_to_cart($data)){
            $response = [
                'status' => 200,
                'message' => 'Van rent added to cart'
            ];
        }else{
            $response = [
                'status' => 402,
                'message' => 'Something went wrong'
            ];
        }

        die(json_encode($response));

    }
    
    public function check_van_availability($van_id){
        $post = json_decode(file_get_contents("php://input"));

        //check if cart has the van type and departure date
        $van_in_cart = 0;
        if($cart = $this->session->userdata('cart')){
            foreach($cart as $item){
                if(!($item['item_type'] == 'booking_van')){ continue; }
                
                if($item['van']->id == $van_id &&
                $item['origin']->id == $post->origin_id &&
                // $item['destination']->id == $post->destination_id &&
                $item['departure_date'] == $post->date){ $van_in_cart++; }
            }
        }

        $van = $this->van_model->find($van_id);
        if(!$van){
            die(json_encode(['status' => '404', 'message' => 'Van not found']));
        }

        $van_rents = $this->db->get_where('van_rent',[
            'departure_date' => $post->date,
            // 'destination_id' => $post->destination_id,
            'origin_id' => $post->origin_id,
            'van_id' => $van_id
        ])->num_rows();


        $available_count = ($van->num_of_vans - $van_rents) - $van_in_cart;

        if($available_count)
        {
            $response = ['status' => 200, 'message' => 'Available','available' => true];
        }else{
            $response  = ['status' => 200, 'message' => 'Not available','available' => false];
        }

        die(json_encode($response));
    }

    private function add_to_cart($data)
    {
        if(!$this->session->has_userdata('cart')){
            $this->session->set_userdata('cart',[]);
        }

        $data['booking_num'] = uniqid();
        $data['item_type'] = 'booking_van';

        $_SESSION['cart'][] = $data;
        
        return true;
    
    }
}