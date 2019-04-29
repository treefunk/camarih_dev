<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sliders extends Admin_Controller {

    const PER_PAGE = 10;

	public function __construct(){
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('slider_model');
    }

    public function index($offset = 0) // CMS > SLIDERS (index)
    {
        $query = $this->slider_model->getAllQuery();

        $per_page = self::PER_PAGE;

        $this->load->library('pagination');

        $clone_query = clone $query;

        $query->offset($offset);
        $query->limit($per_page);

        $config = [
            'base_url' => base_url('sliders'),
            'total_rows' => $clone_query->get()->num_rows(),
            'per_page' => $per_page,
            // 'reuse_query_string' => TRUE
        ];
        
        setPaginationStyle($config);
        $this->pagination->initialize($config);

        $data['sliders'] = $query->get()->result();
        
        $data['links'] = $this->pagination->create_links();


		$this->wrapper([
			'view' => 'admin/sliders/index',
			'data' => $data
		]);
    }

    public function create() 
    {
        
        $this->wrapper([
			'view' => 'admin/sliders/create',
		]);
    }

    public function store()
    {
        $this->db->trans_start();
        $post = $this->input->post(NULL,true);


        $this->sliderIsFeatured($post['is_featured']);

        //validation

        $this->load->library('form_validation'); //TODO: jhondz wag ka na ggamit ng form validation ng CI pls -jhondz
        


        
        //rules
        if(count($post))
        {
            $this->form_validation->set_rules('header','Header','required');

            if(trim($post['button_text_first']) != '')
            {
                $this->form_validation->set_rules('button_link_first', 'First button link', 'valid_url|required');
            }
    
            if(trim($post['button_text_second']) != '')
            {
                $this->form_validation->set_rules('button_link_second', 'Second button link', 'valid_url|required');
            }

            if (empty($_FILES['image_name']['name']))
            {
                $this->form_validation->set_rules('image_name', 'Image', 'required');
            }
        }

        if (count($post) && $this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            $this->form_validation->reset_validation();
            
            $this->wrapper([
                'view' => 'admin/sliders/create',
                'data' => $data
            ]);
            return;
        }


        //end of validation



        $id = $this->slider_model->add($post);
        $filename = $this->slider_model->handleUpload('image_name',$id,'./uploads/sliders');
        if(is_array($filename))
        {
            $this->slider_model->delete($id);

            $this->form_validation->set_rules('999', 'Image tetst', 'required',
            ['required' => $filename['error']]);

           
            if ($this->form_validation->run() == FALSE)
            {
                $data['errors'] = validation_errors();
                
                $this->wrapper([
                    'view' => 'admin/sliders/create',
                    'data' => $data
                ]);
                return;
            }
        }else{
            $this->slider_model->update($id,['image_name' => preg_replace('/\s+/', '_', $filename)]);

            $alert = [
                'type' => 'success',
                'message' => 'Slider Successfully added.'
            ];
        }

        $this->db->trans_complete();
        $this->session->set_flashdata('alert',$alert);
        return redirect('sliders');
    }




    
    public function edit($id)
    {
        $data['slider'] = $slider =  $this->slider_model->findById($id);
        
        $this->wrapper([
            'view' => 'admin/sliders/edit',
            'data' => $data
        ]);
        return -1;   
    }

    public function update($id)
    {
        $data['slider'] = $slider =  $this->slider_model->findById($id);

        $post = $this->input->post(null,TRUE);


        $this->sliderIsFeatured($post['is_featured']);

        //validation

        $this->load->library('form_validation');
        


        //rules
        if(count($post))
        {
            $this->form_validation->set_rules('header','Header','required');
            
            if(trim($post['button_text_first']) != '')
            {
                $this->form_validation->set_rules('button_link_first', 'First button link', 'valid_url|required');
            }
    
            if(trim($post['button_text_second']) != '')
            {
                $this->form_validation->set_rules('button_link_second', 'Second button link', 'valid_url|required');
            }
        }

        if ($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            $this->form_validation->reset_validation();
            
            $this->wrapper([
                'view' => 'admin/sliders/edit',
                'data' => $data
            ]);
            return;
        }

        //end of validation


        // validate image
        if($_FILES['image_name']['name'])
        {

            $currentfile =  'uploads/sliders/'.$slider->id. '_' . $slider->image_name;
            if(file_exists($currentfile))
            {
                unlink($currentfile);
            }

            $filename = $this->slider_model->handleUpload('image_name',$slider->id,'./uploads/sliders');

            if(is_array($filename))
            {
                $this->form_validation->set_rules('999', '', 'required',
                ['required' => $filename['error']]);

            
                if ($this->form_validation->run() == FALSE)
                {
                    $data['errors'] = validation_errors();
                    
                    $this->wrapper([
                        'view' => 'admin/sliders/edit',
                        'data' => $data
                    ]);
                    return;
                }
            }
            
            $post['image_name'] = preg_replace('/\s+/', '_', $filename);
        }

        // end of validate image

        $this->slider_model->update($slider->id,$post);

        $alert = [
            'type' => 'info',
            'message' => 'Slider Successfully Updated.'
        ];


        $this->session->set_flashdata('alert',$alert);
        return redirect('sliders');
    }
    
    public function delete($id)
    {
        $this->db->trans_start();
        $slider = $this->slider_model->findById($id);
        
        $currentfile =  'uploads/sliders/'.$slider->id. '_' . $slider->image_name;
        if(file_exists($currentfile))
        {
            unlink($currentfile);
        }

        if($this->slider_model->delete($id))
        {
            $this->db->trans_complete();
            $alert = [
                "type" => 'success',
                "message" => "Slider Successfully Deleted."
            ];
        }else{
            $this->db->trans_rollback();
            $alert = [
                "type" => 'danger',
                "message" => "Oops! Something went wrong."
            ];
        }

        $this->session->set_flashdata('alert',$alert);
        return redirect(base_url('sliders/'));
    }

    
    public function sliderIsFeatured(&$isFeatured){
		if(!isset($isFeatured)){
			$isFeatured = 0;
		}else{
			$isFeatured = 1;
			$this->db->set(['is_featured' => 0 ])
								->where(['is_featured' => 1])
								->update('sliders');
		}
	}



}
