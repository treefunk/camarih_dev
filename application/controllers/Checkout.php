<?php


require_once __DIR__.'/../models/Paypal.php';

class Checkout extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $paypal = new Paypal;

        $data['paypal_link'] = $paypal->pay();

        $this->wrapper([
            'view' => 'checkout',
            'data' => $data
        ]);

    }

    public function show($payment_id){
        $paypal = new Paypal;

        $paypal->showPayment($payment_id);
    }

    public function confirm()
    {
        $get = $this->input->get();
        $data = (object)[]; 

        foreach($get as $key => $val){
            $key = htmlspecialchars($key);
            $val = htmlspecialchars($val);
            
            $data->$key = $val;
        }

        $data->transactions = [
            (object)['amount' => 0.5]
        ];

        $paypal = new Paypal();

        $paypal->executePayment($data);

    }

    
}