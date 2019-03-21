<?php

class Packagegallery_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "package_gallery";
    }

    public function add($data,$images = null) // override add function in cms_model
    {
        $errors = [];

        for($i = 0 ; $i < count($images); $i++){
            
            $_FILES["image_gallery"]['name']     = $images[$i]['name'];
            $_FILES["image_gallery"]['type']     = $images[$i]['type'];
            $_FILES["image_gallery"]['tmp_name'] = $images[$i]['tmp_name'];
            $_FILES["image_gallery"]['error']     = $images[$i]['error'];
            $_FILES["image_gallery"]['size']     = $images[$i]['size'];

            $name = $images[$i]['name'];
            $filename = $this->handleUpload('image_gallery',$data['package_id'],'./uploads/package_gallery',$name);
        
            if(!is_array($filename)){
                parent::add([
                    'package_id' => $data['package_id'],
                    'image_name' => str_replace(' ','_',$filename),
                    'image_title' => $data['images'][$i]['image_title']
                ]);
            }else{
                $errors[] = $images[$i]['name'] . ": "  . $filename['error'];
            }
        
        }

        return $errors;
    }

    //todo delete gallery in edit page


    
}