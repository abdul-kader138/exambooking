<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 07-Sep-20
 * Time: 8:31 PM
 */

class Overtime_submission extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/overtime_submission_model', 'overtime_submission_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/overtime_submission/overtime_submission_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->overtime_submission_model->get_all_voucher();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['code'],
                $row['fee'],
                $row['status'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/overtime_submission/overtime_submission_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
					<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/overtime_submission/overtime_submission_del/' . md5($row['id'])) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function overtime_submission_add()
    {
        if ($this->input->post('submit')) {
            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('error', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('code', 'Overtime Code', 'trim|required|is_unique[ci_overtime_submission.code]');
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/overtime_submission/add';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'code' => trim($this->input->post('code')),
                    'fee' => $this->input->post('fee'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->overtime_submission_model->add_voucher($data);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Overtime code has been added successfully!');
                    redirect(base_url('admin/overtime_submission'));
                }
            }
        } else {
            $data['view'] = 'admin/overtime_submission/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function overtime_submission_edit($id = 0)
    {

        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);

        //Existence Checking
        $voucher_info = $this->overtime_submission_model->get_voucher_by_id($id);
        if (empty($voucher_info)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/overtime_submission'));
        }

        //Association Checking with exam or submission
        $submission_association = $this->overtime_submission_model->get_submission_from_voucher_by_code($voucher_info['code']);
        if($submission_association){
            $this->session->set_flashdata('error', 'Overtime code already used in exam submission.So edit operation not possible!');
            redirect(base_url('admin/overtime_submission'));
        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('code', 'Voucher Code', 'trim|required');
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required');
            if (strtolower($voucher_info['code']) != strtolower(trim($this->input->post('code')))) {
                $this->form_validation->set_rules('code', 'Overtime Code', 'is_unique[ci_overtime_submission.code]');
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
                $result = $this->overtime_submission_model->edit_voucher($data, $id);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Overtime code has been updated successfully!');
                    redirect(base_url('admin/overtime_submission'));
                }
            }
        } else {
            $data['voucher'] = $voucher_info;
            $data['view'] = 'admin/overtime_submission/edit';
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function overtime_submission_del($id = 0)
    {
        $id = $this->secure_data($id);
        //Existence Checking
        $voucher_info = $this->overtime_submission_model->get_voucher_by_id($id);
        if (empty($voucher_info)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/overtime_submission'));
        }

        //Association Checking with exam or submission
        $submission_association = $this->overtime_submission_model->get_submission_from_voucher_by_code($voucher_info['code']);
        if($submission_association){
            $this->session->set_flashdata('error', 'Overtime code already used in exam submission.So edit operation not possible!');
            redirect(base_url('admin/overtime_submission'));
        }


        $this->db->delete('ci_overtime_submission', array('md5(id)' => $id));
        $this->session->set_flashdata('msg', 'Overtime code has been deleted successfully!');
        redirect(base_url('admin/overtime_submission'));
    }
}