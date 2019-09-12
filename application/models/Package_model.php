<?php

class Package_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "packages";
    }

    public function getAllQuery(){
        return $this->db->from('packages')
                        ->join('package_details', 'packages.id = package_details.package_id');
    }

    public function getPriceRangeVal($id)
    {
        $price_ranges = array(
            0 => '',
            1 => array(0, 1000), 
            2 => array(1001, 1500),
            3 => array(1501, 999999)
        );

        return $price_ranges[$id];
    }
    public function getQueryTourPackages($where = '') { // refactor attempt

       

        if (isset($_GET['package_name'])) {
            $query = $this->db->select("
                packages.*,
                package_details.id as package_detail_id,
                package_details.minimum_count as package_detail_minimum_count,
                package_details.description as package_detail_description,
                package_main_image.id as package_image_id,
                package_main_image.image_title as package_image_title,
                package_main_image.image_name as package_image_name
            ")->from('packages')
            ->join('package_details','packages.id = package_details.package_id','left')
            ->join('package_itineraries','packages.id = package_itineraries.package_id','left')
            ->join('package_main_image','packages.id = package_main_image.package_id','left')
            ->group_by('packages.id')->where('packages.name LIKE "%'.$_GET['package_name'].'%"');
        }else{
             $query = $this->db->select("
            packages.*,
            package_details.id as package_detail_id,
            package_details.minimum_count as package_detail_minimum_count,
            package_details.description as package_detail_description,
            package_main_image.id as package_image_id,
            package_main_image.image_title as package_image_title,
            package_main_image.image_name as package_image_name
        ")->from('packages')
        ->join('package_details','packages.id = package_details.package_id','left')
        ->join('package_itineraries','packages.id = package_itineraries.package_id','left')
        ->join('package_main_image','packages.id = package_main_image.package_id','left')
        ->group_by('packages.id');
        }

        return $query;
    }
    public function getQueryPackageNaming($where = '') { // refactor attempt

        $query = $this->db->select("packages_tour_labels.*,
            packages_durations.name as duration_format
        ")->from('packages_tour_labels')
        ->join('packages_durations','packages_tour_labels.duration_id = packages_durations.id','left');

        return $query;
    }
    public function getQuery($where = '') { // refactor attempt

        $query = $this->db->select("
            packages.*,
            package_details.id as package_detail_id,
            package_details.minimum_count as package_detail_minimum_count,
            package_details.description as package_detail_description,
            package_details.price_description as package_detail_price_description,
            package_main_image.id as package_image_id,
            package_main_image.image_title as package_image_title,
            package_main_image.image_name as package_image_name,
            packages_tour_labels.duration_id as packages_tour_labels_duration_id,
            package_locations.package_id, package_locations.location_id
        ")->from('packages')
        ->join('package_details','packages.id = package_details.package_id','left')
        ->join('packages_tour_labels','packages.package_tour_id = packages_tour_labels.id','left')
        ->join('package_main_image','packages.id = package_main_image.package_id','left')
        ->join('package_locations','packages.id = package_locations.package_id','left')
        ->where('packages.status', 'active')
        ->group_by('packages.id');

        if (is_int($where)) {
            $query->where('packages.is_day_tour', $where);
        }

        if (isset($_GET['location']) && $_GET['location'] != '') {
            $query->where('package_locations.location_id', $_GET['location']);
        }

        if (isset($_GET['price_range']) && $_GET['price_range'] != '' && $_GET['price_range'] != 0) {
            $price_range = $this->getPriceRangeVal($_GET['price_range']);
            $query->where('packages.rate >= ' .$price_range[0]);
            $query->where('packages.rate <= ' .$price_range[1]);
        }

        if (isset($_GET['duration']) && $_GET['duration'] != '' && $_GET['duration'] != 0) {
            $query->where('packages_tour_labels.duration_id', $_GET['duration']);
        }

        if (isset($_GET['pax']) && $_GET['pax'] != '' && $_GET['pax'] != 0) {
            $query->where('packages.minimum_count', $_GET['pax']);
        }

        return $query;
    }

    public function all()
    {
        $this->db->select('*');
        $this->db->from('packages');

        $packages = $this->db->get()->result();

        $this->db->reset_query();

        foreach($packages as &$package)
        {
            
            $package_details = $this->db->get_where('package_details', [
                'package_id' => $package->id
            ])->row();
            
            $package->package_details = $package_details;
            $package->rate = $package->rate;
            $package->image_path = base_url('frontend/images/')."package.jpg";

            $package_image = $this->db->get_where('package_main_image',[
                'package_id' => $package->id
            ])->row();
            $package->package_image = $package_image;
        }

        return $packages;
    }

    public function find($id,$featured = false){
        if (!is_numeric($id)) {
            $package_slug = $this->db->get_where('packages',[
                    'slug' => $id
                ])->row();
            $id = $package_slug->id;
        }
        //sanitize input
        $id = htmlspecialchars_decode($id);

        if(!$featured){
            $package = $this->db->get_where('packages',[
                'id' => $id
            ])->row();
        }else{
            $package = $this->db->get_where('packages',[
                'is_featured' => 1
            ])->row();
        }
        if(!$package){
            return false;
        }


        $package_details = $this->db->get_where('package_details', [
            'package_id' => $package->id
        ])->row();

        $package->package_details = ($package_details)?:array('description' => '','exclusions' => '','inclusions'=> '', 'booking_conditions' =>'');

        $package_gallery = $this->db->get_where('package_gallery', [
            'package_id' => $package->id
        ])->result();

        $package->package_gallery = $package_gallery;

        #itineraries
        $package_itineraries = $this->db->get_where('package_itineraries', [
            'package_id' => $package->id
        ])->result();
        $package->package_itineraries = $package_itineraries;

        #accomodations
        $package_accomodations = $this->db->get_where('package_accomodations', [
            'package_id' => $package->id
        ])->result();
        $package->package_accomodations = $package_accomodations;

        #locations
        $package_locations = $this->db->get_where('package_locations', [
            'package_id' => $package->id
        ])->result();
        $package_locations_ids = [];
        $location_names = '';
        foreach ($package_locations as $key => $value) {
            $package_locations_ids[] = $value->location_id;
            $loc = '';
            $loc = $this->db->get_where('destinations', ['id' => $value->location_id])->row()->name;
            $location_names .= $loc.' | ';
        }

        $package->location_name = rtrim($location_names, " | ");
        $package->package_locations = $package_locations_ids;
        
        $package_download = $this->db->get_where('package_downloads',[
            'package_id' => $package->id
        ])->row();
        $package->package_download = $package_download;

        $package_image = $this->db->get_where('package_main_image',[
            'package_id' => $package->id
        ])->row();
        $package->package_image = $package_image;

        if (!$package->is_day_tour && $package->package_tour_id) { #if package tour
            
            $package->package_root_id = '';
            $package->package_root_name = '';
            if ($this->getPackageLabels($package->package_tour_id)[0]->is_sub_directory == 0) { #root direc

                $package->package_root_id = $package->package_tour_id;
                $package->package_root_name = $this->getPackageLabels($package->package_root_id)[0];

            }else{ #sub direc

                $package->package_root_id = $this->getPackageLabels($package->package_tour_id)[0]->is_sub_directory; 
                $package->package_root_name = $this->getPackageLabels($package->package_root_id)[0]; 
            }
            
        }else{
            $package->package_root_id = $package->package_tour_id;
            $package->package_root_name = $this->getPackageLabels($package->package_root_id)[0];
        }

        $package->image_path = base_url('frontend/images/')."package.jpg";
        // d($package);
        return $package;
    }

    public function getFeaturedPackage(){
        return $this->find(0,true);
    }

    public function getByDestinationId($id)
    {
        $packages = $this->db->get_where('packages',[
            'destination_id' => $id
        ])->result();
        
        $result = [];

        foreach($packages as $package){
            $result[] = $this->find($package->id);
        }
        return $result;
    }

    /* ================================ Diane */
    public function getPackageLabels($id=0, $type = '')
    {   
        if ($id) {
            return $this->formatPackageLabels($this->db->get_where('packages_tour_labels',[
            'status' => 'active', 'id' => $id
        ])->result());
        }
        if ($type) {
            return $this->formatPackageLabels($this->db->get_where('packages_tour_labels',[
                'status' => 'active', 'is_sub_directory' => $id
            ])->result());
        } else {
            return $this->formatPackageLabels($this->db->get_where('packages_tour_labels',[
                'status' => 'active'
            ])->result());
        }
        
    }

    public function getSubDirectories($id)
    {
        return $this->db->get_where('packages_tour_labels',[
                'status' => 'active', 'is_sub_directory' => $id
            ])->result();
    }

    public function formatPackageLabels($arr)
    {
        if (!$arr) {
            return [];
        }

        foreach ($arr as $key => $value) {
            $value->is_sub_directory_format = ($value->is_sub_directory != 0) ? $this->getPackageLabels($value->is_sub_directory)[0]->name:'NONE'; 
            $value->is_root_directory_bool = ($value->is_sub_directory != 0) ? 0:1; 
            // $value->sub_directories = 0;
            if ($value->is_root_directory_bool) {
                $value->sub_directories = ($this->getSubDirectories($value->id))?:0;
            }
            $value->duration_format = $this->getDurations($value->duration_id)[0]->name;

            $arr[$key] = $value;
        }

        return $arr;
        
    }

    public function getDurations($id='')
    {
        if ($id) {
            return $this->db->get_where('packages_durations',['id' => $id])->result();
        }

        return $this->db->get_where('packages_durations',[])->result();
    }

    public function addPackageLabel($post)
    {
        return $this->db->insert('packages_tour_labels', $post);
    }

    public function updatePackageLabel($value)
    {
        $id = $value['id'];
        unset($value['id']);
        return $this->db->update('packages_tour_labels', $value, ['id' => $id]);
    }

    public function format($arr)
    {
        if (!$arr) {
            return [];
        }
        foreach ($arr as $key => $value) {  
            $value->location_info = $this->db->get_where('package_locations', ['package_id' => $value->id])->result();
            $location_names = '';
            foreach ($value->location_info as $key_ => $location) {
                $location->location_name = $this->db->get_where('destinations', ['id' => $location->location_id])->row();
                $location_names .= $location->location_name->name.' | ';
                $value->location_info[$key_] = $location;
            }
            $value->location_name = rtrim($location_names, " | ");
            $value->slug  = base_url('packages/selected/'.$value->slug);
            $value->price_description_f  = str_replace('&nbsp;', ' ',str_replace('</p><p>', ' ', $value->package_detail_price_description));
            $value->price_description_f = strip_tags($value->price_description_f);

            if (strpos($value->price_description_f, "ALL IN") !== false) {
                $price_explode = explode("ALL IN", $value->price_description_f);
                $value->price_description_f = $price_explode[0];
                $value->price_description_span = 'ALL IN '.$price_explode[1];
            }
            $arr[$key] = $value;
        }

        return $arr;
    }

    public function checkSlugifExists($slug)
    {
        return $this->db->get_where('packages',[
                'slug' => $slug
            ])->row();
    }

    public function seo_friendly_url($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }

    public function encryptID($token)
    {
        $cipher_method = 'AES-128-CTR';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
        $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
        unset($token, $cipher_method, $enc_key, $enc_iv);
        return substr(rawurlencode($crypted_token), 0,5);
    }

    
}