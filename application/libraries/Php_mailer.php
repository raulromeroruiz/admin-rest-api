<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHP_Mailer {
    public function __construct()
    {
        //parent::__construct();
        $this->ci =& get_instance();
        $this->ci->config->load('email');
        $this->mail_server = $this->ci->config->item('mail_server');
        $this->mail_user = $this->ci->config->item('mail_user');
        $this->mail_password = $this->ci->config->item('mail_password');
    }

    public function PHP_Mailer() {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
    }

    public function send($params) {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
            
        $mail = new PHPMailer();
        // $mail->SMTPDebug = 1;
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = TRUE; // enabled SMTP authentication
        //$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = $this->mail_server;      // setting GMail as our SMTP server
        $mail->Port       = 587;                   // SMTP port to connect to GMail
        $mail->Username   = $this->mail_user;  // user email address
        $mail->Password   = $this->mail_password;            // password in GMail
        $mail->SetFrom( $params['from'][0], $params['from'][1]);  //Who is sending the email
        $mail->AddReplyTo( $params['from'][0], $params['from'][1] );  //email address that receives the response
        $mail->Subject    = $params['subject'];
        $mail->Body       = $params['message'];
        $mail->IsHTML(true);
        $mail->AddAddress( $params['address'][0], $params['address'][1] );
        if (isset($params['attach'])) {
            $mail->AddAttachment($params['attach']['uploadFile']['tmp_name'],
                         $params['attach']['uploadFile']['name']);
        }

        if($mail->Send()) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
}