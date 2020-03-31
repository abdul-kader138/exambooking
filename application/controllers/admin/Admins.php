<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/admin_model', 'admin_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('email');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/admins/admin_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->admin_model->get_all_users_without_current();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {

            $status = ($row['is_active'] == 0) ? 'inactive' : 'active' . '<span>';
            $disabled = ($row['is_admin'] == $this->session->userdata()) ? 'disabled' : '' . '<span>';
            $data[] = array(
                ++$i,
                $row['firstname'],
                $row['lastname'],
                $row['email'],
                date('F j, Y', strtotime($row['created_at'])),
                '<span class="btn bg-teal  waves-effect" title="status">' . getTypeName($row['admin_type']) . '<span>',    // get type name by ID (getTypeName() is a helper function)
                '<span class="btn bg-blue  waves-effect" title="status">' . $status . '<span>',

                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/admins/admin_edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger " data-href="' . base_url('admin/admins/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function admin_add()
    {

        // get all data to populate UI
        $data['admin_types'] = $this->admin_model->get_admin_types();
        $data['branches'] = $this->admin_model->get_branches();

        if ($this->input->post('submit')) {
            //$this->form_validation->set_rules('username', 'Username', 'trim|min_length[3]|required');
            $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[ci_users.email]|required');
            $this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim');
            $this->form_validation->set_rules('branch', 'Branch', 'trim');
            $this->form_validation->set_rules('admin_type', 'Admin Type', 'trim|required');
            $this->form_validation->set_rules('status', 'Active', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['view'] = 'admin/admins/admin_add';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    //'username' => $this->input->post('username'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'email' => $this->input->post('email'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'address' => $this->input->post('address'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'admin_type' => $this->input->post('admin_type'),
                    'is_active' => $this->input->post('status'),
                    'branch_id' => $this->input->post('branch'),
                    'is_verify' => 1,
                    'is_admin' => 1,
                    'created_at' => date('Y-m-d : h:m:s'),
                    'updated_at' => date('Y-m-d : h:m:s'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->admin_model->add_user($data);
                if ($result) {
                    // Add User Activity
                    $this->activity_model->add(1);

                    $this->session->set_flashdata('msg', 'Admin has been added successfully!');
                    redirect(base_url('admin/admins'));
                }
            }
        } else {
            $data['view'] = 'admin/admins/admin_add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function admin_edit($id = 0)
    {
        // get all data to populate UI
        $data['user'] = $this->admin_model->get_user_by_id($id);
        $data['admin_types'] = $this->admin_model->get_admin_types();
        $data['branches'] = $this->admin_model->get_branches();

        if ($this->input->post('submit')) {
            //$this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('firstname', 'Username', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim');
            $this->form_validation->set_rules('branch', 'Branch', 'trim');
            $this->form_validation->set_rules('admin_type', 'Admin Type', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $data['view'] = 'admin/admins/admin_edit';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    //'username' => $this->input->post('username'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'email' => $this->input->post('email'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'admin_type' => $this->input->post('admin_type'),
                    'is_verify' => 1,
                    'address' => $this->input->post('address'),
                    'is_active' => $this->input->post('status'),
                    'updated_at' => date('Y-m-d : h:m:s'),
                    'branch_id' => ($this->input->post('admin_type')==3)?$this->input->post('branch'):0,
                );
                $data = $this->security->xss_clean($data);
                $result = $this->admin_model->edit_user($data, $id);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(2);

                    $this->session->set_flashdata('msg', 'Admin has been updated successfully!');
                    redirect(base_url('admin/admins'));
                }
            }
        } else {
            $data['view'] = 'admin/admins/admin_edit';
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function del($id = 0)
    {
        $this->db->delete('ci_users', array('id' => $id));

        // Add User Activity
        $this->activity_model->add(3);

        $this->session->set_flashdata('msg', 'Admin has been deleted successfully!');
        redirect(base_url('admin/admins'));
    }
}

?>