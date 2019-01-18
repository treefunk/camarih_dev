<?php

class Package_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "packages";
    }

    public function all_query()
    {
        $this->db->select('*');
        $this->db->from('packages');
        $this->db->join('package_details','packages.id = package_details.package_id');
        return $this->db->get();
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
            $package->rate = number_format($package->rate,2,'.',',');
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


    
}