<?php

class Vangallery_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "van_gallery";
    }

    public function add($data,$images = null) // override add function in cms_model
    {
    
        $errors = [];

        for($i = 0 ; $i < count($images); $i++){
            
            $_FILES["van_gallery"]['name']     = $images[$i]['name'];
            $_FILES["van_gallery"]['type']     = $images[$i]['type'];
            $_FILES["van_gallery"]['tmp_name'] = $images[$i]['tmp_name'];
            $_FILES["van_gallery"]['error']     = $images[$i]['error'];
            $_FILES["van_gallery"]['size']     = $images[$i]['size'];

            $name = $images[$i]['name'];
            $filename = $this->handleUpload('van_gallery',$data['van_id'],'./uploads/van_gallery',$name);
        
            if(!is_array($filename)){
                parent::add([
                    'van_id' => $data['van_id'],
                    'image_name' => str_replace(' ','_',$filename),
                    'image_title' => $data['image_title'][$i]
                ]);
            }else{
                $errors[] = $images[$i]['name'] . ": "  . $filename['error'];
            }
        
        }

        return $errors;
    }

}