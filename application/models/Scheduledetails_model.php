<?php

class Scheduledetails_model extends CMS_Model
{
    const TYPE_HEADER = 'body';

    function __construct(){
        parent::__construct();
        $this->table="schedule_details";
    }

    public function getBody()
    {
        return $this->db->get_where('schedule_details',[
            'type' => self::TYPE_HEADER
        ])->row();
    }

    public function addOrUpdate($val,$type = 'body'){
        $changes = 0;

        $footer_data = $this->db->get_where('schedule_details',[
            'type' => $type
        ])->row();

        if($footer_data){
            $update = $this->db->update('schedule_details', ['value' => $val], ['id' => $footer_data->id]);
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
}