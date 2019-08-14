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
    
    public function getQuery() { // refactor attempt

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
        ->join('package_main_image','packages.id = package_main_image.package_id','left');

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

        $package->package_details = $package_details;

        $package_gallery = $this->db->get_where('package_gallery', [
            'package_id' => $package->id
        ])->result();

        $package->package_gallery = $package_gallery;
        
        $package_download = $this->db->get_where('package_downloads',[
            'package_id' => $package->id
        ])->row();
        $package->package_download = $package_download;

        $package_image = $this->db->get_where('package_main_image',[
            'package_id' => $package->id
        ])->row();
        $package->package_image = $package_image;

        if (!$package->is_day_tour && $package->package_tour_id) { #if package tour
            

            if ($this->getPackageLabels($package->package_tour_id)[0]->is_sub_directory == 0) { #root direc

                $package->package_root_id = $package->package_tour_id;
                $package->package_root_name = $this->getPackageLabels($package->package_root_id)[0];

            }else{ #sub direc

                $package->package_root_id = $this->getPackageLabels($package->package_tour_id)[0]->is_sub_directory; 
                $package->package_root_name = $this->getPackageLabels($package->package_tour_id)[0]; 
            }
            
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
            if ($value->is_root_directory_bool) {
                $value->sub_directories = $this->getSubDirectories($value->id);
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


    
}