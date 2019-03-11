<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vans extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
            'van_model',
            'vandetail_model',
            'vangallery_model',
            'destination_model',
            'vanrate_model'
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

        // unset($post['oneway_rate'],$post['roundtrip_rate']);
        $van_gallery_titles = $post['van_gallery'];
        unset($post['van_gallery']);





        if($id = $this->van_model->add($post)){
            
            $van_rate['van_id'] = $id;

            if($this->vandetail_model->add($van_rate)){
                $alert = [
                    'type' => 'success',
                    'message' => 'Van Successfully added.'
                ];
                $this->db->trans_complete();
            }

            $images = format_multiple_files($_FILES['van_gallery']);

            // van gallery here
			$image_errors = $this->vangallery_model->add([
                'van_id' => $id,
                'image_title' => $van_gallery_titles
            ],$images);
            
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
        $van_gallery = isset($_FILES['van_gallery']) ? $_FILES['van_gallery'] : [];
        $to_be_removed = isset($post['remove_images']) ? $post['remove_images'] : [];

        unset($post['remove_images']);
        // unset($post['van_gallery']);
        unset($post['seats']);

        $this->load->library('form_validation');

        if(count($post))
        {
            $this->form_validation->set_rules('name','Name','required');      
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

        unset($post['oneway_rate'],$post['roundtrip_rate']);
        
        $image_title = $post['image_title'];

        foreach($post['image_title'] as $i => $val){
            if($existing = $this->vangallery_model->findById($i)){
                if($existing->image_title != $val){
                    $updated = $this->db->set(
                        'image_title'
                    ,$val)->where([
                        'id' => $i
                    ])->update('van_gallery');
                    if($updated)
                        $changes++;
                }
            }
        }

        unset($post['image_title']);

        $van_gallery_titles = ($post['van_gallery']) ? $post['van_gallery'] : [];
        unset($post['van_gallery']);

        // var_dump($post); die();
        $changes += $this->van_model->update($id,$post);

        // $changes += $this->vandetail_model->update($van_details_in_db->id,$van_details);

        // add image
        if(count($van_gallery)){
            $images = format_multiple_files($van_gallery);
            // van gallery here
			$image_errors = $this->vangallery_model->add([
                'van_id' => $id,
                'image_title' => $van_gallery_titles
            ],$images);
        }

        //delete image if there's any
        if(count($to_be_removed)){
            $deleted = $this->db->from('van_gallery')
                                ->where_in('id',$to_be_removed)
                                ->where(['van_id' => $id])
                                ->get()->result();

            foreach($deleted as $image){
                $file_path = "uploads/van_gallery/{$image->van_id}_{$image->image_name}";
                unlink($file_path);
                $this->db->delete(['van_gallery'],['id' => $image->id]);
            }
        }

        $alert = [
			'type' => 'success',
			'message' => 'Van Successfully Updated!'
		];

        if($changes){
			$this->session->set_flashdata('alert',$alert);
		}
		return redirect(base_url('vans'));


    }

    public function edit($id)
    {

        $data['van'] = $this->van_model->find($id);
        unset($data['van']->image_name);
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
        $van_id = $van->id;
        if($this->van_model->delete($id))
        {  
            $van_details = $this->db->get_where('van_details',[
                'van_id' => $van_id
            ])->result();

            $van_gallery = $this->db->get_where('van_gallery',[
                'van_id' => $van_id
            ])->result();

            if(count($van_details)){
                foreach($van_details as $detail){
                    $this->db->delete('van_details',['id' => $detail->id]);
                }
            }
            if(count($van_gallery)){
                foreach($van_gallery as $image){
                    $file_path = "uploads/van_gallery/{$image->van_id}_{$image->image_name}";
                    unlink($file_path);
                    $this->db->delete('van_gallery',['id' => $image->id]);
                }
            }


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

    public function rates($id)
    {
        $data['van'] = $this->van_model->find($id);
        $data['destinations'] = $this->destination_model->getAllEndpoints();
        $data['origins'] = $this->destination_model->getAllOrigins();

        $this->wrapper([
            'view' => 'admin/vans/rates',
            'data' => $data
        ]);
    }

    public function updateRates($van_id)
    {

        $van_rates = $this->input->post('van_rates');

        //get all van ids in db
        $van = $this->van_model->find($van_id);
        $van_rates_in_db = $this->db->from('van_rate')
                                    ->where([
                                        'van_id' => $van_id
                                    ])->get()->result();


        $van_ids_in_db = [];
        $van_ids_in_post = [];
        foreach($van_rates_in_db as $rate){ $van_ids_in_db[] = $rate->destination_id; } 
        foreach($van_rates as $r){ $van_ids_in_post[] = $r['destination_id']; }
        
        foreach($van_rates_in_db as $rate){
            if(!in_array($rate->destination_id,$van_ids_in_post)){
                $this->db->delete('van_rate',[
                    'destination_id' => $rate->destination_id,
                    'van_id' => $van->id
                ]);
            }
        }

        //not existing in db add
        foreach($van_rates as $van_rate){

            if(in_array($van_rate['destination_id'],$van_ids_in_db)){
                $query = $this->db->set([
                    'origin_id' => $van_rate['origin_id'],
                    'oneway_rate' => $van_rate['oneway_rate'],
                    'roundtrip_rate' => $van_rate['roundtrip_rate']
                ])->where([
                    'van_id' => $van->id,
                    'destination_id' => $van_rate['destination_id']
                ])->update('van_rate');
            }else{
                $this->vanrate_model->add(array_merge($van_rate,['van_id' => $van->id]));
            }
        }


        //if id is in db run update
        return redirect(base_url("vans/rates/{$van->id}"));

        //if all van ids not in post ids delete


    }
}