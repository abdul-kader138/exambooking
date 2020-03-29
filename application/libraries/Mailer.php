<?php
class Mailer 
{
	function __construct()
	{
		$this->CI =& get_instance();
	}
	//=============================================================
	function Tpl_Registration($username, $email_verification_link)
	{
    $login_link = base_url('auth/login');  

		$tpl = '<h3>Hi ' .strtoupper($username).'</h3>
            <p>Welcome to Trinity Malaysia!</p>
            <p>Active your account with the link below:</p>  
            <p><a href="'.$email_verification_link.'">'.$email_verification_link.'</a></p>

            <br>
            <br>

            <p>Regards, <br> 
               Trinity Malaysia Team <br> 
            </p>
    ';
		return $tpl;		
	}

	//=============================================================
	function Tpl_PwdResetLink($username, $reset_link)
	{
		$tpl = '<h3>Hi ' .strtoupper($username).'</h3>
            <p>Welcome to Trinity Malaysia!</p>
            <p>We have received a request to reset your password. If you did not initiate this request, you can simply ignore this message and no action will be taken.</p> 
            <p>To reset your password, please click the link below:</p> 
            <p><a href="'.$reset_link.'">'.$reset_link.'</a></p>

            <br>
            <br>

            <p>Trinity Malaysia Team</p>
    ';
		return $tpl;		
	}

	

}
?>