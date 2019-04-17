<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials extends Admin_Controller {

    const PER_PAGE = 10;

	public function __construct(){
        parent::__construct();
        $this->load->model('testimonial_model');
    }

    public function index($offset = 0) // CMS > Testimonials (index)
    {
        // $data['testimonials'] = $this->testimonial_model->all();
        $query = $this->testimonial_model->getQueryAll();

        $per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

        $query->offset($offset);
        $query->limit($per_page);

        $config = [
            'base_url' => base_url('testimonials'),
            'total_rows' => $clone_query->get()->num_rows(),
            'per_page' => $per_page,
            // 'reuse_query_string' => TRUE
        ];
        
        setPaginationStyle($config);
        $this->pagination->initialize($config);

        $data['testimonials'] = $query->get()->result();
        
        $data['links'] = $this->pagination->create_links();


		$this->wrapper([
			'view' => 'admin/testimonials/index',
			'data' => $data
		]);
    }

    public function create()
    {
        $this->load->helper('form');

		$this->wrapper([
			'view' => 'admin/testimonials/create'
		]);        
    }

    public function store()
    {
        $post = $this->input->post();
        $this->db->trans_start();
        $this->load->library('form_validation');

        if(count($post))
        {
            if($_FILES['image_name']['name'] == '')
            {
                $this->form_validation->set_rules('image','Image','required');
            }
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('testimonial','Testimonial','required');
            $this->form_validation->set_rules('occupation','Occupation','required');
            $this->form_validation->set_rules('title','Title','required');
    
        }

        if($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            $this->wrapper([
                'view' => 'admin/testimonials/create',
                'data' => $data
            ]);
            return;
        }

        $id = $this->testimonial_model->add($post);
        
        $filename = $this->testimonial_model->handleUpload('image_name',$id,'./uploads/testimonials/');
        
        if(is_array($filename))
        {
            $this->testimonial_model->delete($id);

            $this->form_validation->set_rules('custom_error123' , '123', 'required',
            [
                'required' => $filename['error']
            ]
            );

            if($this->form_validation->run() == FALSE){
                $data['errors'] = validation_errors();
                $this->wrapper([
                    'view' => 'admin/testimonials/create',
                    'data' => $data
                ]);
                return;    
            }
        }else{
            $this->testimonial_model->update($id,['image_name' => $filename]);
            $this->db->trans_complete();
            $alert = [
                'type' => 'success',
                'message' => 'Testimonial Successfully added.'
            ];

        }


        $this->session->set_flashdata('alert',$alert);
        return redirect('testimonials');



    }

    public function edit($id)
    {
        $data['testimonial'] = $this->testimonial_model->findById($id);
        $this->wrapper([
            'view' => 'admin/testimonials/edit',
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $data['testimonial'] = $testimonial =  $this->testimonial_model->findById($id);

        $post = $this->input->post();

        //validation

        $this->load->library('form_validation');
        


        //rules
        if(count($post))
        {
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('testimonial','Testimonial','required');
            $this->form_validation->set_rules('occupation','Occupation','required');
            $this->form_validation->set_rules('title','Title','required');
    
        }

        if($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            $this->session->set_flashdata(['alert' => [
                'type' => 'danger',
                'message' => $data['errors']
            ]]);
            return redirect('testimonials/edit/'.$id);
            return;
        }


        //end of validation


        // validate image
        if($_FILES['image_name']['name'])
        {
            $filename = $this->testimonial_model->handleUpload('image_name',$testimonial->id,'./uploads/testimonials');

            if(is_array($filename))
            {
                $this->form_validation->set_rules('999', '', 'required',
                ['required' => $filename['error']]);

            
                if ($this->form_validation->run() == FALSE)
                {
                    $data['errors'] = validation_errors();
                    $this->load->helper('form');
                    $this->wrapper([
                        'view' => 'admin/testimonials/edit',
                        'data' => $data
                    ]);
                    return;
                }
            }
            $currentfile =  'uploads/testimonials/'.$testimonial->id. '_' . $testimonial->image_name;
            if(file_exists($currentfile))
            {
                unlink($currentfile);
            }
            $post['image_name'] = $filename;
        }

        // end of validate image

        $this->testimonial_model->update($testimonial->id,$post);

        $alert = [
            'type' => 'info',
            'message' => 'Testimonial Successfully Updated.'
        ];


        $this->session->set_flashdata('alert',$alert);
        return redirect('testimonials');
    }


    public function delete($id)
    {
        $this->db->trans_start();
        $testimonial = $this->testimonial_model->findById($id);

        $currentfile =  'uploads/testimonials/'.$testimonial->id. '_' . $testimonial->image_name;
        if(file_exists($currentfile))
        {
            unlink($currentfile);
        }


        if($this->testimonial_model->delete($id))
        {
            $this->db->trans_complete();
            $alert = [
                "type" => 'success',
                "message" => "Testimonial Successfully Deleted."
            ];
        }else{
            $this->db->trans_rollback();
            $alert = [
                "type" => 'danger',
                "message" => "Oops! Something went wrong."
            ];
        }

        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('testimonials/'));
    }


}
