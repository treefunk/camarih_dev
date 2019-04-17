<?php


class Contactus extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'contact_model'
        ]);

    }

    public function index(){
        $data = [
            'recipient' => $this->contact_model->getRecipient(),
            'subject' => $this->contact_model->getSubject()
        ];
        


        $this->wrapper([
            'data' => $data,
            'view' => 'admin/contact/edit'
        ]);
    }
    public function update(){
        $post = $this->input->post(null,TRUE);

        $changes = 0;

        $recipient = $this->contact_model->getRecipient(true);

        if($recipient){
            if($post['recipient'] != $recipient->value){
                
                $update_recipient = $this->db->update('contact_settings', ['value' => $post['recipient']], ['id' => $recipient->id]);
                if($update_recipient){ $changes++; }
            }
        }else{
            $this->contact_model->add([
                'type' => "recipient",
                'value' => $post['recipient']
            ]);
        }

        $subject = $this->contact_model->getSubject(true);
        if($subject){
            if($post['subject'] != $subject->value){
                $update_subject = $this->db->update('contact_settings', ['value' => $post['subject']], ['id' => $subject->id]);
                if($update_subject){ $changes++; }
            }
        }else{
            $this->contact_model->add([
                'type' => "subject",
                'value' => $post['subject']
            ]);
        }

        if($changes){
            $alert = [
                'type' => 'success',
                'message' => 'Contact Settings Updated.'
            ];

            $this->session->set_flashdata('alert',$alert);
        }


        return redirect(base_url('contactus'));



    }



}