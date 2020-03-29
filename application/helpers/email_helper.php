<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function sendEmail($to = '', $subject  = '', $body = '', $attachment = '', $cc = '')
{
		$controller =& get_instance();
       	$controller->load->helper('path'); 
		
		$config = array();
        $config['useragent']            = "CodeIgniter";
        $config['mailpath']             = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']             = "smtp";
        $config['smtp_host']            = "mail.mindyourapp.com.my";
        $config['smtp_port']            = "587";
		$config['smtp_timeout'] 		= '30';
		$config['smtp_user']    		= "no-reply@mindyourapp.com.my";
		$config['smtp_pass']    		= "0Orj)RAXH4(7";
        $config['mailtype'] 			= 'html';
        $config['charset']  			= 'utf-8';
        $config['newline']  			= "\r\n";
        $config['wordwrap'] 			= TRUE;

        $controller->load->library('email');

        $controller->email->initialize($config);
			
		$controller->email->from( 'no-reply@mindyourapp.com.my' , 'Trinity Malaysia' );
		
		$controller->email->to($to);
		
		$controller->email->subject($subject);
		
		$controller->email->message($body);
		if($cc != '') 
		{	
			$controller->email->cc($cc);
		}	
		if($attachment != '')
		{
			$controller->email->attach(base_url()."pdfs/" . $attachment );
		 
		}
		if($controller->email->send()){
			return true;
		}
		else
		{
			return false;
		}
    }
?>