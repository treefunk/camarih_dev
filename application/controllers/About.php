<?php

class About extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('about_model');
    }

    public function edit(){
        $data['about'] = json_decode(file_get_contents(APPPATH.'/about.json'));
        $this->wrapper([
            'data' => $data,
            'view' => 'admin/about/edit'
        ]);
    }

    public function update(){
        $post = $this->input->post();
        $post = json_encode($post);

        file_put_contents(APPPATH.'/about.json',$post);

        $alert = [
			'type' => 'success',
			'message' => 'About us Successfully Updated!'
		];

		$this->session->set_flashdata('alert',$alert);
        
        return redirect(base_url('about/edit'));

    }
}