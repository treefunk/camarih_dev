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

    const PAYPAL_DESCRIPTION = "Camarih Transport Line Services Inc.";

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
        //BOOKING TRIP
        if(!$cart){
            return "You did not select any items in the cart. Please try again.";
        }

        if(array_key_exists('booking_trip',$cart)){
            foreach($cart['booking_trip'] as $item){

                    foreach($item['items'] as $i){
                        $new_item = new Item();
                        $new_item->setName("{$item['short']} - {$item['departure_time']} - {$i['passenger']}")
                                 ->setCurrency("PHP")
                                 ->setQuantity(1)
                                 ->setSku("SEAT_#{$i['seatnum']}") // Similar to `item_number` in Classic API
                                 ->setPrice((float)$i['price']);
        
                        $subtotal += $i['price'];
                        $items[] = $new_item;
                    }
                }
        }


        // BOOKING VAN
        if(array_key_exists('booking_van',$cart)){
            foreach($cart['booking_van'] as $van_id){
                foreach($van_id as $item){

                    $new_item = new Item();
                    $new_item->setName("{$item['date']} {$item['van_name']} - {$item['trip_type']}")
                    ->setCurrency("PHP")
                    ->setQuantity(1)
                    ->setSku($item['description']) // Similar to `item_number` in Classic API
                    ->setPrice((float)$item['price']);
                    
                    $subtotal += $item['price'];
                    $items[] = $new_item;
                }
            }
        }

        //BOOKING PACKAGE

        if(array_key_exists('booking_package',$cart)){
            $total = 0;
            foreach($cart['booking_package'] as $item){

                    $new_item = new Item();
                    $new_item->setName("Package - {$item['package_name']}")
                    ->setCurrency("PHP")
                    ->setQuantity($item['adult_count'])
                    // ->setSku($item['']) // Similar to `item_number` in Classic API
                    ->setPrice((float)$item['rate']);
                    $total += ((float)($item['rate'])) * $item['adult_count'];
                    $items[] = $new_item;
            }

            $subtotal += $total;
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
                    ->setDescription(Paypal::PAYPAL_DESCRIPTION)
                    ->setInvoiceNumber(uniqid());
 
            
                   

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(base_url()."availability/process_cart?success=true")
            ->setCancelUrl(base_url()."checkout/cancel?success=false");
           
    

        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);
                
                $request = clone $payment;

        try {
            $paymentObject = $payment->create($this->api_context);
            return $paymentObject;
        } catch (Exception $ex) {
            if($ex->getCode()){
                return $ex->getMessage();
            }
            // var_dump($ex->getCode()." ".$ex->getMessage()); die();
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
            // $result  = $ex->getCode();
            $result = $ex->getMessage();
            if($ex->getCode() == 400){
                $result = "Insufficient Funds";
            }           
        }

        return $result;

    }

    public function getPaymentDetails($id){
        try {
            $payment = Payment::get($id, $this->api_context);
        } catch (Exception $e) {
            $payment = $e->getMessage();
        }

        return $payment;
    }
}