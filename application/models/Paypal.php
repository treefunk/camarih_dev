<?php

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

class Paypal{

    public function __construct()
    {

        $mode = getenv('PAYPAL_MODE');
        $client_id = getenv("PAYPAL_{$mode}_CLIENT_ID");
        $secret = getenv("PAYPAL_{$mode}_SECRET");


        $this->api_context = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $client_id,     // ClientID
                $secret      // ClientSecret
            )
        );
    
        if(strtolower($mode) == "live"){
            $this->api_context->setConfig(
                ['mode' => 'live']
            );
        }
    }


    public function pay($cart)
    {

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");


        

        $transactions = [];
        $item_list = [];
        $subtotal = 0;
        $items = [];

        foreach($cart as $item){
            $total_items = 0;
            foreach($item['items'] as $i){
                $new_item = new Item();
                $new_item->setName("{$item['short']} - {$item['departure_time']} - {$i['passenger']}")
                         ->setCurrency("PHP")
                         ->setQuantity(1)
                         ->setSku("SEAT_#{$i['seatnum']}") // Similar to `item_number` in Classic API
                         ->setPrice((float)$i['price']);

                $subtotal += $i['price'];
                $total_items++;
                $items[] = $new_item;
            }
            

            
            
        }
        $itemList = new ItemList();
        $itemList->setItems($items);
        $details = new Details();
        $details->setShipping(0)
                ->setTax(0)
                ->setSubtotal($subtotal);

        $amount = new Amount();
        $amount->setCurrency("PHP")
               ->setTotal($subtotal)
               ->setDetails($details);

        
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription($item['name'])
                    ->setInvoiceNumber(uniqid());
 
            
                   

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(base_url()."checkout/execute?success=true")
            ->setCancelUrl(base_url()."checkout/execute?success=false");
           
    

        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);
                
                $request = clone $payment;
                var_dump($payment->create($this->api_context)); die();

        try {
            $payment->create($this->api_context);
        } catch (Exception $ex) {
            // die('ye');
            var_dump($ex->getData()); die();
        }
        
    }

    public function executePayment($transaction){

        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $this->api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        // $transaction = new Transaction();
        // $amount = new Amount();
        // $details = new Details();

        $execution->addTransaction($transaction);

        try {
            $result = $payment->execute($execution, $this->api_context);
        } catch (Exception $ex) {
            echo $ex->getData();
            die();
        }

    }

    public function getPaymentDetails($id){
        $payment = Payment::get($id, $this->api_context);

        return $payment;
    }
}