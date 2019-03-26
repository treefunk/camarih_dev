<?php

class Packagedownload_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "package_downloads";
        $this->upload_path = 'uploads/package_download';
    }

    public function createUploadFolder(){

        if(!file_exists($this->upload_path) && !is_dir($this->upload_path)){
            mkdir("uploads/package_download",0755);
        }
        return true;

    }
    
}