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

        $post = $this->input->post(null,true);

        $_SESSION['payment_details'] = $post;

        $paypal = new Paypal;

        $cart = $this->session->userdata('cart');
        
        $filtered_items = $this->cart_model->filterChecked($cart,$post['booking_num']);

        $formatted_cart = $this->cart_model->itemsWithPrices($filtered_items);
        $payment = $paypal->pay($formatted_cart);
        if(is_object($payment)){
            header("Location: {$payment->links[1]->href}");
            return;
        }else{
            $data['errormsg'] = $payment;
            $this->wrapper([
                'view' => 'errorpage',
                'data' => $data
            ]);

            return -1;
        }

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
        $paypal->executePayment($details->transactions[0]);
    }

    public function thankyou()
    {
        $this->wrapper([
            'view' => 'thankyou'
        ]);
        return ;

    }

    public function cancel()
    {
        unset($_SESSION['payment_details']);
        $this->wrapper([
            'view' => 'cancel'
        ]);
        return ;
    }
    
}