<?php

class Tourinquiries_model extends CMS_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->table = "tour_inquiries";
    }
    public function getAllQuery()
    {
    	return $this->db->select("
            tour_inquiries.*,
            packages.name as package_name")
            ->from('tour_inquiries')
            ->join('packages', 'tour_inquiries.package_id = packages.id');
    }

    public function sendEmail($post, $type)
    {
    	if ($type == 'customer') {
	    	$html = 'Hi '.$post['name'].',<br>
			Thank you! Your inquiry has been successfully sent.<br>
			';
			$email_to = $post['email_address'];
			$subject = 'Camarih Transport: Inquiry';
    	}else{
    		$html = 'Hi Admin,<br><br>
			Name: '.$post['name'].'<br>
			Email: '.$post['email_address'].'<br>
			Contact #: '.$post['mobile'].'<br>
			Package Name: '.$post['package_name'].'<br>
			';
			$email_to = 'dianeocampo97@gmail.com';
			$subject = 'Camarih Transport: New Inquiry';

    	}

	    $mail = $this->contact_model->initSettings();

	    $mail->setFrom(getenv('EMAIL_FROM'));
	    $mail->addAddress($email_to);
	    $mail->addAddress('edocampo@myoptimind.com');

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $subject;
	    $mail->Body = $html;
	    return $mail->send();
    }
}