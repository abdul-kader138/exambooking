<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/admin_model', 'admin_model');
        $this->load->model('activity_model', 'activity_model');
    }

    //-------------------------------------------------------------------------
    public function index()
    {

        $user_details = $this->admin_model->get_user_detail();
        $data['user'] = $user_details;
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('username', 'Username', 'trim');
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            if ($this->input->post('email') != $user_details['email']) {
                $this->form_validation->set_rules('email', 'Email', 'is_unique[ci_users.email]');
            }
            if ($this->form_validation->run() == FALSE) {
                $data['title'] = 'User Profile';
                $data['view'] = 'admin/profile';
                $this->load->view('layout', $data);

            } else {
                $data = array(
                    'username' => $this->input->post('username'),
                    'firstname' => $this->input->post('firstname'),
                    'email' => $this->input->post('email'),
                    'updated_at' => date('Y-m-d : h:m:s'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->admin_model->update_user($data);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(6);

                    $this->session->set_flashdata('msg', 'Profile has been Updated Successfully!');
                    redirect(base_url('admin/profile'), 'refresh');
                }
            }
        } else {
            $data['title'] = 'User Profile';
            $data['view'] = 'admin/profile';
            $this->load->view('layout', $data);
        }
    }

    //-------------------------------------------------------------------------
    public function change_pwd()
    {
        $id = $this->session->userdata('admin_id');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_pwd', 'Confirm Password', 'trim|required|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                $data['user'] = $this->admin_model->get_user_detail();
                $data['view'] = 'admin/profile';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
                );
                $data = $this->security->xss_clean($data);
                $result = $this->admin_model->change_pwd($data, $id);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(7);

                    $this->session->set_flashdata('msg', 'Password has been changed successfully!');
                    redirect(base_url('admin/profile'));
                }
            }
        } else {
            $data['user'] = $this->admin_model->get_user_detail();
            $data['title'] = 'Change Password';
            $data['view'] = 'admin/profile';
            $this->load->view('layout', $data);
        }
    }
}

?>	