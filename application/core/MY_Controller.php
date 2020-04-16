<?php

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata('is_admin_login')) {
            redirect('auth/login');
        }

        //general settings
        $global_data['general_settings'] = $this->setting_model->get_general_settings();
        $this->general_settings = $global_data['general_settings'];

        //set timezone
        date_default_timezone_set($this->general_settings['timezone']);
    }
}

class UR_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata('is_user_login')) {
            redirect('auth/login');
        }


        //general settings
        $global_data['general_settings'] = $this->setting_model->get_general_settings();
        $this->general_settings = $global_data['general_settings'];

        //set timezone
        date_default_timezone_set($this->general_settings['timezone']);

        //recaptcha status
        /*$global_data['recaptcha_status'] = true;
        if (empty($this->general_settings['recaptcha_site_key']) || empty($this->general_settings['recaptcha_secret_key']) || $this->$global_data['recaptcha_status'] == '0') {
            $global_data['recaptcha_status'] = false;
        }
        $this->recaptcha_status = $global_data['recaptcha_status'];*/

    }

    public function checkUsersProfileStatus()
    {
        $this->load->model('user/user_model', 'user_model');
        $user_details = $this->user_model->get_user_detail();
        if (!$user_details['mobile_no'] || !$user_details['address'] || !$user_details['branch_id']) {
            $this->session->set_flashdata('alert', 'Please update your profile first');
            redirect(base_url('user/profile'), 'refresh');
        }
    }
}

?>