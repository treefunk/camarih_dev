<?php 

use GuzzleHttp\Client;

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
                  'van_gallery',
                  'package_download',
                  'package_image'
                ];

                foreach($delete_content_directories as $d)
                {
                  $folder_path = "uploads/{$d}";

                  if(!file_exists($folder_path) && !is_dir($folder_path)){
                    mkdir($folder_path,0775,true);
                  }

                  $dir = new DirectoryIterator($folder_path);
                  

                  foreach($dir as $fileinfo)
                  {
                    if(!$fileinfo->isDot()){
                      unlink($fileinfo->getPathname());
                    }
                  }
                }
                
                $result = require_once 'text_refreshed.php'; // ^_^V -jhondz
                if(getenv("ENABLE_JISOO") == "true"){
                  $result = str_replace("x","&nbsp;",$result);
                  $image = $this->giffy();
                  $result.= $image;
                }

                echo $result;
                $this->session->sess_destroy();
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
        'description' => '<h1>Hotel + Tours + Transfers</h1>',
        'minimum_count' => 3
      ]);

      $this->db->insert('packages',[
        'name' => '6A5B Palawan',
        'rate' => 1500,
        'status' => 'active'
      ]);

      $this->db->insert('package_details',[
        'package_id' => $this->db->insert_id(),
        'description' => '<h1>Hotel + Tours</h1>',
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

    $schedule_time = [
      ['6:00 am','6:00 am'],
      ['8:00 am','8:00 am'],
      ['10:00 am','10:00 am'],
      ['12:00 pm','1:00 pm'],
      ['1:30 pm','4:00 pm'],
      ['3:30 pm','5:30 pm'],
      ['6:00 pm','7:00 pm']
    ];

    for($x = 0  ; $x < count($schedule_time) ; $x++){
      $this->db->insert('trip_schedule',[
        'trip_num' => $x + 1,
        'departure_time_pps' => $schedule_time[$x][0],
        'departure_time_eln' => $schedule_time[$x][1]
      ]);
    }





  }

  public function giffy() {
    try{
      $client = new Client;
  
      $res = $client->request('GET', 'https://api.tenor.com/v1/random?client=%22C09V03CYQKH1%22&q=%22jisoo%22');
  
      $gifs = (json_decode($res->getBody()));
      $random_gif = $gifs->results[rand(0,5)]->media[0]->gif->url;
      $image = "<img src='{$random_gif}' width='250' height='250'>";

    }catch(Exception $e){
      $image = "No internet, No Jisoo"; 
    }

    return $image;
  }

}
