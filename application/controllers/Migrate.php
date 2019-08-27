<?php 

use GuzzleHttp\Client;

class Migrate extends CI_Controller
{

  public function __construct()
  {
          parent::__construct();
          if(strtolower(getenv("ENABLE_MIGRATION") == 'false')){
            die("Migration has been disabled!");
          }
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
        'name' => 'El Nido',
        'destination_id' => 4,
        'is_day_tour' => 1,
        'rate' => 2790,
        'status' => 'active',
        'is_featured' => 1
      ]);

      $this->db->insert('package_details',[
        'package_id' => $this->db->insert_id(),
        'description' => '<h1>Hotel + Tours + Transfers</h1>',
        'minimum_count' => 3
      ]);

      $this->db->insert('packages',[
        'name' => 'Puerto Princesa',
        'destination_id' => 1,
        'is_day_tour' => 1,
        'rate' => 1500,
        'status' => 'active'
      ]);

      $this->db->insert('package_details',[
        'package_id' => $this->db->insert_id(),
        'description' => '<h1>Hotel + Tours</h1>',
        'minimum_count' => 2
      ]);


      $this->db->insert('packages_durations',[
        'name' => '3D2N'
      ]);

      $this->db->insert('packages_durations',[
        'name' => '4D3N'
      ]);

      $this->db->insert('packages_durations',[
        'name' => '5D4N'
      ]);

      $this->db->insert('packages_tour_labels',[
        'name' => '3D2N PPS Package Tour',
        'duration_id' => 1
      ]);

      $this->db->insert('packages_tour_labels',[
        'name' => '3D2N PPS City',
        'duration_id' => 1,
        'is_sub_directory' => 1
      ]);

      $this->db->insert('packages_tour_labels',[
        'name' => '3D2N PPS City Tour+Honda Bay',
        'duration_id' => 1,
        'is_sub_directory' => 1
      ]);

      $this->db->insert('package_locations',[
        'package_id' => 1,
        'location_id' => 4
      ]);

      $this->db->insert('package_locations',[
        'package_id' => 2,
        'location_id' => 1
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
    //cms
    $this->db->insert('cms',[
      'name' => 'day_tours_description',
      'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dictum tellus leo. Maecenas semper non dolor imperdiet feugiat. Morbi a enim urna. Nullam tincidunt porta justo non eleifend.'
    ]);

    $this->db->insert('cms',[
      'name' => 'package_tours_description',
      'value' => 'Package Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dictum tellus leo. Maecenas semper non dolor imperdiet feugiat. Morbi a enim urna. Nullam tincidunt porta justo non eleifend.'
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


    $footer_details = [
      ['header','About Camarih Palawan Shuttle Transport Services'],
      ['body','CAMARIH Transport is the best in providing convenient and safe yet affordable transportation for locals and tourists who are drawn to explore the beauty of Northern Palawan.'],
      ['address','Mitra Rd Puerto Princesa City, Puerto Princesa, Philippines'],
      ['phone_1','+63 917 849 7646'],
      ['phone_2','+63 939 933 7002'],
      ['email','camarihtransport@gmail.com'],
      ['facebook_link','https://web.facebook.com/camarihtours/'],
      ['messenger_link','https://m.me/camarihtours']
    ];

    for($x = 0  ; $x < count($footer_details) ; $x++){
      $this->db->insert('footer_details',[
        'type' => $footer_details[$x][0],
        'value' => $footer_details[$x][1]
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
