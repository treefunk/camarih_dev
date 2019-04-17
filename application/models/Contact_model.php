<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH.'PHPMailer/src/Exception.php';
require APPPATH.'PHPMailer/src/PHPMailer.php';
require APPPATH.'PHPMailer/src/SMTP.php';

class Contact_model extends CMS_Model
{
    const TYPE_RECIPIENT = 'recipient';
    const TYPE_SUBJECT = 'subject';

    public function __construct()
    {
        $this->load->database();
        $this->table = "contact_settings";
    }

    public function getRecipient($get_object = false){
        $recipient = $this->db->get_where('contact_settings',['type' => SELF::TYPE_RECIPIENT])->row();
        
        if($get_object){ return $recipient; }
        return $recipient ? $recipient->value : "";
    }

    public function getSubject($get_object = false){
       $subject =  $this->db->get_where('contact_settings',['type' => SELF::TYPE_SUBJECT])->row();
      
       if($get_object){ return $subject; }
       return $subject ? $subject->value : "";
    }

    public function sendMail($post_data){

        try {
            $mail = $this->initSettings();
            //Recipients
            // $mail->setFrom('Camarih@noreply.com', 'Camarih'); //TODO:
            $recipient = $this->getRecipient();
            $mail->setFrom(getenv('EMAIL_FROM'));
            $mail->addAddress($recipient);     //TODO: Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->getSubject();

            $valid_keys = ['name','email','phone','message'];


            foreach($post_data as $key => $val){
                if(in_array($key,$valid_keys)){
                    $mail->Body .= "<b>{$key}</b>: {$val}";
                    $mail->Body .= "<br>";
                }
            }

            $mail->send();
            // echo 'Message has been sent';
            die(json_encode([
                'code' => '200',
                'status' => 'success',
                'message' => "Thank you for your inquiry! We will get in touch with you as soon as possible."
            ]));
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            die(json_encode([
                'code' => '404',
                'status' => 'fail',
                'message' => 'Something went wrong. Please try again.' .$mail->ErrorInfo
            ]));
        }
    }

    public function initSettings()
    {
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = getenv('SMTP2GO_HOST');  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = getenv('SMTP2GO_USERNAME');                     // SMTP username
        $mail->Password   = getenv('SMTP2GO_PASSWORD');                               // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = getenv('SMTP2GO_PORT');                                    // TCP port to connect to
        return $mail;
    }

}