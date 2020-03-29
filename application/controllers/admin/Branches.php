<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 29-Mar-20
 * Time: 10:45 PM
 */

class Branches extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/branch_model', 'branch_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/branch/branch_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->branch_model->get_all_branches();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['branch_name'],
                $row['created_at'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/branches/branch_edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
					<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/branches/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function branch_add()
    {
        if ($this->input->post('submit')) {

            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('msg', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required|is_unique[ci_branches.branch_name]');
            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/branch/branch_add';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'branch_name' => $this->input->post('branch_name'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $data = $this->security->xss_clean($data);
                $result = $this->branch_model->add_branch($data);
                if ($result) {
                    // Add User Activity
                    $this->activity_model->add(12);

                    $this->session->set_flashdata('msg', 'Branch has been added successfully!');
                    redirect(base_url('admin/branches'));
                }
            }
        } else {
            $data['view'] = 'admin/branch/branch_add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function branch_edit($id = 0)
    {

        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('msg', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $branch_info = $this->branch_model->get_branch_by_id($id);
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
            if ($branch_info['branch_name'] != $this->input->post('branch_name')) {
                $this->form_validation->set_rules('branch_name', 'Branch Name', 'is_unique[ci_branches.branch_name]');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['branch'] = $branch_info;
                $data['view'] = 'admin/branch/branch_edit';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'branch_name' => $this->input->post('branch_name'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->branch_model->edit_branch($data, $id);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(13);

                    $this->session->set_flashdata('msg', 'Branch has been updated successfully!');
                    redirect(base_url('admin/branches'));
                }
            }
        } else {
            $data['branch'] = $branch_info;
            $data['view'] = 'admin/branch/branch_edit';
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function del($id = 0)
    {

        //@todo
//        Later add user association check
        $this->db->delete('ci_branches', array('id' => $id));

        // Add User Activity
        $this->activity_model->add(14);

        $this->session->set_flashdata('msg', 'Branch has been deleted successfully!');
        redirect(base_url('admin/branches'));
    }

}