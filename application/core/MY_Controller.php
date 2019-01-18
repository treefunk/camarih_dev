<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_Controller.php'; 

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }

    public function wrapper($data = null)
    {
        $this->load->view('partials/header.php',@$data['title']);
        $this->load->view('partials/nav.php');
        $this->load->view($data['view'],@$data['data']);
        $this->load->view('partials/footer.php');
    }
}





