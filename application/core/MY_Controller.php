<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_Controller.php'; 

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('footer_model');
    }

    public function wrapper($data = null)
    {
        $fd['footer_data'] = $this->footer_model->getAll();



        $this->load->view('partials/header.php',@$data['title']);
        $this->load->view('partials/nav.php');
        $this->load->view($data['view'],@$data['data']);
        $this->load->view('partials/footer.php',$fd);
        
        if(getenv('DEBUG') == 'true')
        {
            $this->load->view('debug.php',@$data['data']);
            $d = $this->output->enable_profiler(true);
        }
    }
}





