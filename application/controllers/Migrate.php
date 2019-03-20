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

                // this will iterate the uploads folder delete all subfolders contents 
                $delete_content_directories = [
                  'package_gallery',
                  'sliders',
                  'testimonials',
                  'van_gallery'
                ];

                foreach($delete_content_directories as $d)
                {
                  $dir = new DirectoryIterator("uploads/{$d}");

                  foreach($dir as $fileinfo)
                  {
                    if(!$fileinfo->isDot()){
                      unlink($fileinfo->getPathname());
                    }
                  }
                }
            
                $result = require_once 'text_refreshed.php'; // ^_^V -jhondz
                $result = str_replace("x","&nbsp;",$result);
                echo $result;
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
        'minimum_count' => 3
      ]);

      $this->db->insert('packages',[
        'name' => '6A5B Palawan',
        'rate' => 1500,
        'status' => 'active'
      ]);

      $this->db->insert('package_details',[
        'package_id' => $this->db->insert_id(),
        'description' => 'Hotel + Tours',
        'minimum_count' => 2
      ]);


    $this->db->trans_complete();

    // destinations

    $this->db->insert('destinations',[
      'name' => 'Puerto Princesa',
      'short_name' => "PPS",
      'is_origin' => 1,
      'is_dropoff' => 1,
      'is_vanrental_origin' => 1
    ]);
    $this->db->insert('destinations',[
      'name' => 'Roxas',
      'short_name' => "ROX",
      'is_dropoff' => 1,
    ]);
    $this->db->insert('destinations',[
      'name' => 'Taytay',
      'short_name' => "TTY",
      'is_dropoff' => 1,
    ]);
    $this->db->insert('destinations',[
      'name' => 'El Nido',
      'short_name' => "ELN",
      'is_origin' => 1,
      'is_dropoff' => 1,
      'is_vanrental_dropoff' => 1
    ]);

    $this->db->insert('destinations',[
      'name' => 'Sabang',
      'short_name' => "Sabang",
      'is_vanrental_dropoff' => 1
    ]);

    $this->db->insert('destinations',[
      'name' => 'Narra',
      'short_name' => "Narra",
      'is_vanrental_dropoff' => 1
    ]);

    $this->db->insert('destinations',[
      'name' => 'Port Barton',
      'short_name' => "Narra",
      'is_vanrental_dropoff' => 1
    ]);


    $this->db->insert('vans',[
      'name' => 'Regular Van',
      'description' => "Just a regular van wid tv",
      'seat_map' => '2,3,3,4',
      'num_of_vans' => 2
    ]);

    $this->db->insert('van_details',[
      'van_id' => $this->db->insert_id(),
      'oneway_rate' => 2000,
      'roundtrip_rate' => 4000
    ]);



  }

}
