<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 29-Mar-20
 * Time: 10:45 PM
 */

class Voucher extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/voucher_model', 'voucher_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/voucher/voucher_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->voucher_model->get_all_voucher();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['code'],
                $row['fee'],
                $row['status'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/voucher/voucher_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
					<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/voucher/voucher_del/' . md5($row['id'])) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function voucher_add()
    {
        if ($this->input->post('submit')) {

            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('error', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('code', 'Voucher Code', 'trim|required|is_unique[ci_voucher.code]');
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/voucher/add';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'code' => trim($this->input->post('code')),
                    'fee' => $this->input->post('fee'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->voucher_model->add_voucher($data);
                if ($result) {
                    // Add User Activity
                    $this->activity_model->add(12);

                    $this->session->set_flashdata('msg', 'Voucher has been added successfully!');
                    redirect(base_url('admin/voucher'));
                }
            }
        } else {
            $data['view'] = 'admin/voucher/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function voucher_edit($id = 0)
    {

        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);
        $voucher_info = $this->voucher_model->get_voucher_by_id($id);
        if (empty($voucher_info)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/voucher'));
        }
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('code', 'Voucher Code', 'trim|required');
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required');
            if (strtolower($voucher_info['code']) != strtolower(trim($this->input->post('code')))) {
                $this->form_validation->set_rules('code', 'Voucher Code', 'is_unique[ci_voucher.code]');
            }

            if($voucher_info['status']=='Used'){
                $this->session->set_flashdata('error', 'Voucher already used.So edit operation not possible!');
                redirect(base_url('admin/voucher'));
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['voucher'] = $voucher_info;
                $data['view'] = 'admin/voucher/edit';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'code' => trim($this->input->post('code')),
                    'fee' => $this->input->post('fee'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->voucher_model->edit_voucher($data, $id);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(13);

                    $this->session->set_flashdata('msg', 'Voucher has been updated successfully!');
                    redirect(base_url('admin/voucher'));
                }
            }
        } else {
            $data['voucher'] = $voucher_info;
            $data['view'] = 'admin/voucher/edit';
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function voucher_del($id = 0)
    {

//        Check brach association with Exam
        $voucher_management = $this->voucher_model->get_voucher_by_id($id);
        if($this->voucher_model->get_submission_from_voucher_by_code($voucher_management['code'])){
            $this->session->set_flashdata('error', 'Voucher has association with Exam,please first remove the association.');
            redirect(base_url('admin/voucher'));
        }
        $this->db->delete('ci_voucher', array('md5(id)' => $id));

        // Add User Activity
        $this->activity_model->add(14);

        $this->session->set_flashdata('msg', 'Voucher has been deleted successfully!');
        redirect(base_url('admin/voucher'));
    }

}