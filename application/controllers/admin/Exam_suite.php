<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 29-Mar-20
 * Time: 10:45 PM
 */

class Exam_suite extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/exam_suite_model', 'exam_suite_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/exam_suite/exam_suite_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->exam_suite_model->get_all_exam_suite();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['name'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/exam_suite/exam_suite_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
		   		<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/exam_suite/exam_suite_del/' . md5($row['id'])) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function exam_suite_add()
    {
        if ($this->input->post('submit')) {
            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('error', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('suite_name', 'Suite Name', 'trim|required|is_unique[ci_exam_suite.name]');
            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/exam_suite/add';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'name' => $this->input->post('suite_name'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->exam_suite_model->add_exam_suite($data);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Exam Suite has been added successfully!');
                    redirect(base_url('admin/exam_suite'));
                }
            }
        } else {
            $data['view'] = 'admin/exam_suite/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function exam_suite_edit($id = 0)
    {
        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);
        $exam_suite_info = $this->exam_suite_model->get_exam_suite_by_id($id);
        if (empty($exam_suite_info)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_suite'));
        }

        $suite_association = $this->exam_suite_model->get_suite_from_exam_by_code($exam_suite_info['name']);
        if ($suite_association) {
            $this->session->set_flashdata('error', 'Information edit not possible due to association with exam!!');
            redirect(base_url('admin/exam_suite'));
        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('suite_name', 'Suite Name', 'trim|required');
            if (strtolower($exam_suite_info['name']) != strtolower(trim($this->input->post('suite_name')))) {
                $this->form_validation->set_rules('suite_name', 'Suite Name', 'is_unique[ci_exam_suite.name]');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['exam_suite'] = $exam_suite_info;
                $data['view'] = 'admin/exam_suite/edit';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'name' => $this->input->post('suite_name'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->exam_suite_model->edit_exam_suite($data, $id);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Exam Suite has been updated successfully!');
                    redirect(base_url('admin/exam_suite'));
                }
            }
        } else {
            $data['exam_suite'] = $exam_suite_info;
            $data['view'] = 'admin/exam_suite/edit';
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function exam_suite_del($id = 0)
    {
        $id = $this->secure_data($id);
        $exam_suite_info = $this->exam_suite_model->get_exam_suite_by_id($id);
        if (empty($exam_suite_info)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_suite'));
        }

        $suite_association = $this->exam_suite_model->get_suite_from_exam_by_code($exam_suite_info['name']);
        if ($suite_association) {
            $this->session->set_flashdata('error', 'Information edit not possible due to association with exam!!');
            redirect(base_url('admin/exam_suite'));
        }
        $this->db->delete('ci_exam_suite', array('id' => $id));
        $this->session->set_flashdata('msg', 'Exam Suite has been deleted successfully!');
        redirect(base_url('admin/exam_suite'));
    }

}