<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vans extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
            'van_model',
            'vandetail_model'
        ]);
    }
    
    public function index()
    {
        $data['vans'] = $this->van_model->all();
        return $this->wrapper([
            'view' => 'admin/vans/index',
            'data' => $data
        ]);
    }

    public function create()
    {
        return $this->wrapper([
            'view' => 'admin/vans/create'
        ]);
    }

    public function store()
    {

        $post = $this->input->post();
 
        $this->db->trans_start();
        $this->load->library('form_validation');

        if(count($post))
        {
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('oneway_rate','One-way trip Rate','required');
            $this->form_validation->set_rules('roundtrip_rate','Roundtrip Rate','required');
        }

        if($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            $this->wrapper([
                'view' => 'admin/vans/create',
                'data' => $data
            ]);
            return;
        }
        
        //Convert seats array to comma separated
        $post['seat_map'] = implode(',',$post['seats']);

        unset($post['seats']);

        $van_rate = [
            'oneway_rate' => $post['oneway_rate'],
            'roundtrip_rate' => $post['roundtrip_rate']
        ];

        unset($post['oneway_rate'],$post['roundtrip_rate']);

        if($id = $this->van_model->add($post)){
            
            $van_rate['van_id'] = $id;

            if($this->vandetail_model->add($van_rate)){
                $alert = [
                    'type' => 'success',
                    'message' => 'Van Successfully added.'
                ];
                $this->db->trans_complete();
            }
        }else{
            $alert = [
                'type' => 'danger',
                'message' => 'Something Went Wrong.'
            ];
            $this->db->trans_rollback();
        }


        $this->session->set_flashdata($alert);
        return redirect('vans');
    }

    public function update($id)
    {
        $post = $this->input->post();
        $changes = 0;
        
        $post['seat_map'] = implode(',',$this->input->post('seats'));
        unset($post['seats']);

        $this->load->library('form_validation');

        if(count($post))
        {
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('oneway_rate','One-way trip Rate','required');
            $this->form_validation->set_rules('roundtrip_rate','Roundtrip Rate','required');        
        }

        if($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata(['alert' => [
                'type' => 'danger',
                'message' => $errors
            ]]);
            return redirect('vans/edit/' . $id);
        }

        $van_details_in_db = $this->van_model->find($id)->van_details;

        $van_details = [
            'oneway_rate' => $post['oneway_rate'],
            'roundtrip_rate' => $post['roundtrip_rate']
        ];
        
        unset($post['oneway_rate'],$post['roundtrip_rate']);

        $changes += $this->van_model->update($id,$post);

        $changes += $this->vandetail_model->update($van_details_in_db->id,$van_details);

        $alert = [
			'type' => 'success',
			'message' => 'Package Successfully Updated!'
		];

        if($changes){
			$this->session->set_flashdata('alert',$alert);
		}
		return redirect(base_url('vans'));


    }

    public function edit($id)
    {

        $data['van'] = $this->van_model->find($id);
        $data['van']->seatmap = NULL;
        $data['van']->seatmap = explode(',',$data['van']->seat_map);

        return $this->wrapper([
            'view' => 'admin/vans/edit',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $van = $this->van_model->findById($id);
       
        if($this->van_model->delete($id))
        {
            $this->db->trans_complete();
            $alert = [
                "type" => 'success',
                "message" => "Van Successfully Deleted."
            ];
        }else{
            $this->db->trans_rollback();
            $alert = [
                "type" => 'danger',
                "message" => "Oops! Something went wrong."
            ];
        }

        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('vans/'));
    }
}