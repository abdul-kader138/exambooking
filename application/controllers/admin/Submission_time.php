<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 09-Sep-20
 * Time: 11:05 AM
 */

class Submission_time extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/submission_time_model', 'submission_time_model');
        $this->load->library('functions');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/submission_time/submission_time_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->submission_time_model->get_all_submission_time();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {

            $status = ($row['status'] == 0) ? 'Inactive' : 'Active';
            $class = ($row['status'] == 0) ? 'bg-brown' : 'bg-teal';
            $data[] = array(
                ++$i,
                $row['start_date'],
                $row['end_date'],
                '<span class="btn ' . $class . ' waves-effect" title="status">' . $status . '<span>',
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/submission_time/submission_time_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger " data-href="' . base_url('admin/submission_time/submission_time_del/' . md5($row['id'])) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function submission_time_add()
    {

        // get all data to populate UI

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('start_date', 'Start Time', 'trim|required');
            $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|callback_is_start_date_valid[' . $this->input->post('start_date') . ']');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['view'] = 'admin/submission_time/add';
                $this->load->view('layout', $data);
            } else {
                $obj_start_date = $this->submission_time_model->get_active_time_by_date($this->input->post('start_date'));
                $obj_end_date = $this->submission_time_model->get_active_time_by_date($this->input->post('end_date'));
                if ($obj_start_date || $obj_end_date) {
                    $this->session->set_flashdata('error', 'Input date range already used,please try with different date range');
                    redirect(base_url('admin/submission_time'));
                }

                $data = array(
                    'start_date' => ($this->input->post('start_date')),
                    'end_date' => ($this->input->post('end_date')),
                    'status' => $this->input->post('status'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->submission_time_model->add_submission_time($data);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Submission time added successfully!');
                    redirect(base_url('admin/submission_time/'));
                }
            }
        } else {
            $data['view'] = 'admin/submission_time/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function submission_time_edit($id = 0)
    {

        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);
        //Existence Checking
        $submission_time_info = $this->submission_time_model->get_submission_time_by_id($id);
        if (empty($submission_time_info)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/submission_time'));
        }

        //Association Checking with exam or submission
//        if($voucher_info['status']=='Used'){
//            $this->session->set_flashdata('error', 'Overtime code already used.So edit operation not possible!');
//            redirect(base_url('admin/overtime_submission'));
//        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('start_date', 'Start Time', 'trim|required');
            $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|callback_is_start_date_valid[' . $this->input->post('start_date') . ']');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                if ($submission_time_info['start_date'] != $this->input->post('start_date')) {
                    $obj_start_date = $this->submission_time_model->get_active_time_by_date($this->input->post('start_date'));
                    if ($obj_start_date) {
                        $this->session->set_flashdata('error', 'Input date range already used,please try with different date range');
                        redirect(base_url('admin/submission_time'));
                    }
                }
                if ($submission_time_info['end_date'] != $this->input->post('end_date')) {
                    $obj_end_date = $this->submission_time_model->get_active_time_by_date($this->input->post('end_date'));
                    if ($obj_end_date) {
                        $this->session->set_flashdata('error', 'Input date range already used,please try with different date range');
                        redirect(base_url('admin/submission_time'));
                    }
                }
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['submission_time'] = $submission_time_info;
                $data['view'] = 'admin/submission_time/edit';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'start_date' => ($this->input->post('start_date')),
                    'end_date' => ($this->input->post('end_date')),
                    'status' => $this->input->post('status'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->submission_time_model->edit_submission_time($data, $id);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Submission time has been updated successfully!');
                    redirect(base_url('admin/submission_time'));
                }
            }
        } else {
            $data['submission_time'] = $submission_time_info;
            $data['view'] = 'admin/submission_time/edit';
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function submission_time_del($id = 0)
    {
        $id = $this->secure_data($id);
        //Existence Checking
        $obj = $this->submission_time_model->get_submission_time_by_id($id);
        if (empty($obj)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/overtime_submission'));
        }

        //Association Checking with exam or submission
//        if ($voucher_info['status'] == 'Used') {
//            $this->session->set_flashdata('error', 'Overtime code already used.So delete operation not possible!');
//            redirect(base_url('admin/overtime_submission'));
//        }

        //Association Checking with exam or submission
//        $submission_association = $this->overtime_submission_model->get_submission_from_voucher_by_code($voucher_info['code']);
//        if ($submission_association) {
//            $this->session->set_flashdata('error', 'Overtime code already used in exam submission.So delete operation not possible!');
//            redirect(base_url('admin/overtime_submission'));
//        }

        $this->db->delete('ci_submission_time', array('md5(id)' => $id));
        $this->session->set_flashdata('msg', 'information deleted successfully!');
        redirect(base_url('admin/submission_time'));
    }

    function is_start_date_valid($end_date, $start_date)
    {
        if (strtotime($start_date) <= strtotime($end_date)) return TRUE;
        else {
            $this->form_validation->set_message('is_start_date_valid', 'To date must be greater than From Date');
            return FALSE;
        }

    }

}