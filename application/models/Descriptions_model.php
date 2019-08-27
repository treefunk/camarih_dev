<?php

class Descriptions_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "cms";
    }

    public function findByName($name)
    {
        return $this->db->get_where($this->table,['name' => $name])->row();
    }
    
    public function update($field, $value)
    {
		return $this->db->update($this->table, array('value' => $value), ['name' => $field]);
    }
}