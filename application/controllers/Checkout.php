<?php


require_once __DIR__.'/../models/Paypal.php';

class Checkout extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'cart_model'
        ]);
    }

    public function index(){
        $paypal = new Paypal;
        
        $formatted_cart = $this->cart_model->itemsWithPrices();


        $data['paypal_link'] = $paypal->pay($formatted_cart);        

        $this->wrapper([
            'view' => 'checkout',
            'data' => $data
        ]);

    }

    public function show($payment_id){
        $paypal = new Paypal;

        $details = $paypal->getPaymentDetails($payment_id);
        var_dump($details->transactions[0]->amount->total);
        var_dump($details); die();
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

    public function execute()
    {
        $paypal = new Paypal();

        $details = $paypal->getPaymentDetails($this->input->get('paymentId'));
        var_dump($paypal->executePayment($details->transactions[0]));
    }

    
}