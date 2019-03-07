<?php

class Admin_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function all($offset = null, $limit = null)
    {
        $query = $this->db->select('id,username,created_at')
                          ->from('admins');

        if($offset){
            $query->offset($offset);
        }

        if($limit){
            $query->limit($limit);
        }

        return $query->get();
    }

    public function createAdmin($data)
    {
        $exists = $this->db->get_where('admins',
        [
            'username' => $data['username']
        ])->num_rows();
        if(!$exists){
            $data['password'] = password_hash($data['password'],PASSWORD_BCRYPT);
            return $this->db->insert('admins', $data);
        }
        return false;
    }

    public function findById($id)
    {
        return $this->db->get_where('admins',['id' => $id])->row();
    }

    public function updateAdmin($id,$data)
    {
        $admin = $this->findById($id);


        $changes = 0;

        foreach(array_keys($data) as $key){
            if($key == 'password' && trim($data['password']) != '') 
            {
                if(trim($data['password']) !== trim($data['confirm_password']))
                {
                    return -1;
                }
                $data['password'] = password_hash($data['password'],PASSWORD_BCRYPT);
            }

            if($key == 'confirm_password')
            {
                continue;
            }

            if($admin->{$key} != $data[$key])
            {
                $this->db->set($key,$data[$key]);
                $this->db->where('id', $id);
                $this->db->update('admins');
                $changes++;
            }
        }

        return $changes;
    }

    public function deleteAdmin($id)
    {
        return $this->db->delete('admins',['id' => $id]);
    }
}