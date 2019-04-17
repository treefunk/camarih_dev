<?php

class Packagereservation_model extends CMS_Model
{
    public $dt;

    public function __construct()
    {
        parent::__construct();
        $this->dt = new DateTimeZone('Asia/Hong_Kong');
    }

    public function getAllQuery($getResult = false)
    {
        $query = $this->db
        ->select("
        checkouts.fullname,
        checkouts.email,
        checkouts.phone,
        package_booking.*,
        packages.name as package_name
        ")
        ->from('package_booking')
        ->join('packages','package_booking.package_id = packages.id')
        ->join('checkouts','checkouts.id = package_booking.checkout_id');

        if($getResult){
            return $query->get()->result();
        }

        return $query;
                          
    }

    public function filterPackage(&$query,$package_id)
    {
        $query->where('packages.id',$package_id);
        return true;
    }

    public function filterStatus(&$query,$status){
        $query->where('package_booking.status',$status);
        return true;
    }

    public function filterSearch(&$query,$search){

        $query->like("CONCAT(
        checkouts.fullname,
        packages.name,
        package_booking.adult_count,
        package_booking.price,
        package_booking.status
        )",$search);
        
        return true;
    }






    
}