<?php

use GuzzleHttp\Client;

class Paypal{

    private $auth;
    private $access_token;
    protected $main_url;

    protected $scope;

    public function __construct(){

        if(strtoupper(getenv('PAYPAL_MODE') == 'LIVE')){
            $this->main_url = 'https://api.paypal.com';
        }else{
            $this->main_url = 'https://api.sandbox.paypal.com';
        }

        if(!$this->accessTokenExists()){
            $this->setCredentials();
            $data = $this->requestAccessToken();
            foreach($data as $key => $value)
            {
                $this->{$key} = $value;
            }
            var_dump("1" . $this->auth); die();
        }else{
            $this->auth = "Bearer {$_SESSION['token']}";
        }


    }

    public function accessTokenExists(){
        return isset($_SESSION['token']);
    }

    public function setCredentials(){

        $mode = strtoupper(getenv('PAYPAL_MODE'));

        if(!$mode){
            print('PAYPAL CREDENTIALS NOT CONFIGURED!');
            return false;
        }else{
            $this->client_id = getenv("PAYPAL_{$mode}_CLIENT_ID");
            $this->secret = getenv("PAYPAL_{$mode}_SECRET");
            return true;
        }

    }


    public function requestAccessToken()
    {
        $client = new Client();

        $response = $client->request('POST', $this->main_url.'/v1/oauth2/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US',
            ],
            'auth' =>  [$this->client_id,$this->secret],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);


        $data = json_decode($response->getBody());

        $_SESSION['token'] = $data->access_token;

        return $data;
    }

    private function isTokenExpired(){  return $this->expires_in == 0;  }

    public function pay($cart){

        $client = new Client();

        $return_url = base_url('checkout/confirm');
        // $return_url = "https://google.com";

        $url = "{$this->main_url}/v1/payments/payment";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => $this->auth,
            ],
            'json' => [
                "intent" => "sale",
                "redirect_urls" => [
                    "return_url" => $return_url,
                    "cancel_url" => "https://youtube.com"
                ],
                "payer" => [
                    "payment_method" => "paypal"
                ],
                "transactions" => [
                    [
                        "amount" => [
                            "total" => 0.1,
                            "currency" => "PHP"
                        ]
                    ]
                ]
            ]
        ]);

        

        $data = json_decode($response->getBody());
        
        var_dump($data); die();



        return $data->links[0]->href;


    }

    //
    public function showPayment($payment_id)
    {
        $client = new Client;
        $url = "{$this->main_url}/v1/payments/payment/{$payment_id}";
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->auth,
            ]
        ]);

        return json_decode($response->getBody());
    }
    
    public function executePayment($data){

        $client = new Client;
        $url = "{$this->main_url}/v1/payments/payment/{$data->paymentId}/execute";

        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => $this->auth,
            ],
            'json' => [
                'payer_id' => $data->PayerID,
            ]
        ]);

        var_dump(json_decode($response->getBody())); 
        die();

        return json_decode($response->getBody());
    }


}