<?php

class Migrate extends CI_Controller
{

  public function __construct()
  {
          parent::__construct();
  }


  public function mode($mode = null)
  {
          $this->load->library('migration');
          

    switch($mode){
      case 'reset':
      if ($this->migration->current() === FALSE){
        show_error($this->migration->error_string());
      }else{
        echo "Database reset";
      }
      break;

      case 'refresh':

      if ($this->migration->current() === FALSE){
        show_error($this->migration->error_string());
      }else{
        if ($this->migration->latest() === FALSE)
        {
          show_error($this->migration->error_string());
        }else{
                $this->seed();

                
            
                echo "Refreshed";
        }
      }

      break;

      case 'latest':
      default:
      if ($this->migration->latest() === FALSE)
      {
        show_error($this->migration->error_string());
      }else{
        echo "Latest";
      }
      break;
    }

    // $this->session->sess_destroy();



  }

  public function seed()
  {

    //admin
    $this->db->insert('admins',[
      'username' => 'admin',
      'password' => password_hash('password',PASSWORD_BCRYPT)
    ]);


    //packages
    $this->db->trans_start();

      $this->db->insert('packages',[
        'name' => '3D2N El Nido',
        'rate' => 2790,
        'status' => 'active'
      ]);

      $this->db->insert('package_details',[
        'package_id' => $this->db->insert_id(),
        'description' => 'Hotel + Tours + Transfers',
        'num_of_days' => 3,
				'num_of_nights' => 2
      ]);

      $this->db->insert('packages',[
        'name' => '6A5B Palawan',
        'rate' => 1500,
        'status' => 'active'
      ]);

      $this->db->insert('package_details',[
        'package_id' => $this->db->insert_id(),
        'description' => 'Hotel + Tours',
        'num_of_days' => 6,
				'num_of_nights' => 4
      ]);


    $this->db->trans_complete();

    // destinations

    $this->db->insert('destinations',[
      'name' => 'Puerto Princesa',
      'short_name' => "PPS"
    ]);
    $this->db->insert('destinations',[
      'name' => 'Roxas',
      'short_name' => "ROX"
    ]);
    $this->db->insert('destinations',[
      'name' => 'Taytay',
      'short_name' => "TTY"
    ]);
    $this->db->insert('destinations',[
      'name' => 'El Nido',
      'short_name' => "ELN"
    ]);


    $this->db->insert('vans',[
      'name' => 'Regular Van',
      'description' => "Just a regular van wid tv",
      'seat_map' => '2,3,3,4'
    ]);

    $this->db->insert('van_details',[
      'van_id' => $this->db->insert_id(),
      'oneway_rate' => 2000,
      'roundtrip_rate' => 4000
    ]);



  }

}
