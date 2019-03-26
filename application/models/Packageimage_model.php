<?php

class Packageimage_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "package_main_image";
        $this->upload_path = 'uploads/package_image';
    }

    public function createUploadFolder(){

        if(!file_exists($this->upload_path) && !is_dir($this->upload_path)){
            mkdir("uploads/package_image",0755);
        }
        return true;

    }
    
}