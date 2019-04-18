<?php

class Footer_model extends CMS_Model
{
    const TYPE_HEADER = 'header';
    const TYPE_BODY = 'body';
    const TYPE_ADDRESS = 'address';
    const TYPE_PHONE_1 = 'phone_1';
    const TYPE_PHONE_2 = 'phone_2';
    const TYPE_EMAIL = 'email';
    const TYPE_FACEBOOK = 'facebook_link';
    const TYPE_MESSENGER = 'messenger_link';

    function __construct(){
        parent::__construct();
        $this->table="footer_details";
    }

    public function addOrUpdate($val,$type){
    
        $changes = 0;

        $footer_data = $this->db->get_where('footer_details',[
            'type' => $type
        ])->row();

        if($footer_data){
            $update = $this->db->update('footer_details', ['value' => $val], ['id' => $footer_data->id]);
            if($update){ $changes++; }
        }else{
            $this->add([
                'type' => $type,
                'value' => $val
            ]);
            $changes++;
        }
        
        return $changes;

    }

    protected function getAllTypes(){

        return [
            self::TYPE_ADDRESS,
            self::TYPE_HEADER,
            self::TYPE_BODY,
            self::TYPE_PHONE_1,
            self::TYPE_PHONE_2,
            self::TYPE_EMAIL,
            self::TYPE_FACEBOOK,
            self::TYPE_MESSENGER
        ];

    }

    public function getAll(){

        $valid_types = $this->getAllTypes(); 
        $data = [];
        $data_in_db = $this->db->from('footer_details')->get()->result();

        foreach($data_in_db as $row){
            if(!in_array($row->type,$valid_types)){ continue; }
            $data[$row->type] = $row->value;
        }

        foreach($valid_types as $type){
            if(!in_array($type,array_keys($data))){
                $data[$type] = "";
            }
        }

        return $data;
    }

    public function process_post($post)
    {
        $changes = 0;
        foreach($post as $type => $val){
            $changes += $this->addOrUpdate($val,$type);
        }
        return $changes;
    }


}