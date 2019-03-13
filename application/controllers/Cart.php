<?php

class Cart extends MY_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        var_dump($_SESSION['cart']);
        $data['cart'] = $this->session->has_userdata('cart') ? $this->session->userdata('cart') : [];
        $this->wrapper([
            'data' => $data,
            
            'view' => 'cart'
        ]);
    }

    public function removeItem(){
        $item = json_decode(file_get_contents('php://input'));

        if(array_splice($_SESSION['cart'],$item->index,1)){
            die(json_encode(true));
        }
            die(json_encode(false));
        
        
    }
}