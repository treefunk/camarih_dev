<?php


class MY_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
}

class CMS_Model extends CI_Model
{
    public function all()
    {
        return $this->db->from($this->table)->get()->result();
    }

    public function allWithFeaturedOffset()
    {
        $offset = 0;
        $found = false;

        $data = $this->db->from($this->table)->get()->result();

        foreach($data as $row){
            if(!$row->is_featured){ $offset++; }
            if($row->is_featured){
                $found = true;
                break; 
            }
        }
        if(!$found){ $offset = 0; }

        return [
            'result' => $data,
            'offset' => $offset
        ];
    }

    public function findById($id)
    {
        return $this->db->get_where($this->table,['id' => $id])->row();
    }

    public function update($id,$data)
    {
        $single = $this->findById($id);
        $changes = 0;
        foreach(array_keys($data) as $key){
            if($single->{$key} != $data[$key])
            {
                $this->db->set($key,$data[$key]);
                $this->db->where('id', $id);
                $this->db->update($this->table);
                $changes++;
            }
        }

        return $changes;
    }

    public function add($data)
    {
        if($this->db->insert($this->table, $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        return $this->db->delete($this->table,['id' => $id]);
    }

    public function handleUpload($file,$id = 0,$upload_path = './uploads/',$name = null,$allowed_types = 'jpg|png|gif|jpeg')
    {
        if(!file_exists($upload_path)){
            mkdir($upload_path,755);
        }

        unset($config);

        $config['upload_path']          = $upload_path;
        $config['allowed_types']        = $allowed_types;
        // $config['max_size']             = 1000;
        // $config['max_width']            = 2000;
        // $config['max_height']           = 1000;
        $filename = $name !== null ? $name : $_FILES[$file]['name'];

        $config['file_name'] = $id."_".$filename;

        // $config['file_name']

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload($file))
        {
                $error = array('error' => $this->upload->display_errors());
                
                return $error;
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());

                return $filename;

        }
    }
}