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
        }
        return $packages;
    }

    public function find($id){

        //sanitize input
        $id = htmlspecialchars_decode($id);

        $package = $this->db->get_where('packages',[
            'id' => $id
        ])->row();


        $package_details = $this->db->get_where('package_details', [
            'package_id' => $package->id
        ])->row();

        $package->package_details = $package_details;

        $package_gallery = $this->db->get_where('package_gallery', [
            'package_id' => $package->id
        ])->result();

        $package->package_gallery = $package_gallery;
        
        return $package;
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



    
}