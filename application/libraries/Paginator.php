<?php

class Paginator{

    public $data;
    public $settings;

    public function initialize($data,$config)
    {
        $this->data = $data;
        $this->settings = $config;
    }

    public function get()
    {
        return $this;
    }


}