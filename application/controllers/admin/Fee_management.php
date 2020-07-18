<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 29-Mar-20
 * Time: 10:45 PM
 */

class Fee_management extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/fee_management_model', 'fee_management_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/fee_management/fee_management_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->fee_management_model->get_all_fee_management();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['name'],
                $row['type_name'],
                $row['instrument_name'],
                $row['grade_name'],
                $row['fees'],
                $row['suite_name'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/fee_management/fee_management_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
				 <a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/fee_management/fee_management_del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function fee_management_add()
    {
        if ($this->input->post('submit')) {

            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('error', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('grade_id', 'Grade Name', 'required');
            $this->form_validation->set_rules('instrument_id', 'Attribute Name', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Type Of Exam', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            $this->form_validation->set_rules('suite_id', 'Suite Name', 'trim');
            $this->form_validation->set_rules('fees', 'Fee', 'trim');
            $fee_management_info = $this->fee_management_model->get_fee_by_type_id($this->input->post('instrument_id'), $this->input->post('grade_id'));
            if ($fee_management_info) {
                $this->form_validation->set_rules('grade_id', 'Grade Fees', 'trim|grade_check');
                $this->form_validation->set_message('grade_check', 'Fee already exist.');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/fee_management/add';
                $data['exam_types'] = $this->fee_management_model->get_exam_types();
                $data['exam_suites'] = $this->fee_management_model->get_exam_suites();
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'grade_id' => $this->input->post('grade_id'),
                    'instrument_id' => $this->input->post('instrument_id'),
                    'suite_name' => $this->input->post('suite_id'),
                    'fees' => $this->input->post('fee'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->fee_management_model->add_fee_management($data);
                if ($result) {
                    // Add User Activity
                    $this->activity_model->add(12);
                    $this->session->set_flashdata('msg', 'Fee has been added successfully!');
                    redirect(base_url('admin/fee_management'));
                }
            }
        } else {
            $data['exam_types'] = $this->fee_management_model->get_exam_types();
            $data['exam_suites'] = $this->fee_management_model->get_exam_suites();
            $data['view'] = 'admin/fee_management/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function fee_management_edit($id = null)
    {
        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);
        $fee_management = $this->fee_management_model->get_fee_management_by_id($id);
        if (empty($fee_management)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/fee_management'));
        }
        $exam_type_details = $this->fee_management_model->get_exam_attribute_by_id($fee_management['instrument_id']);

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('grade_id', 'Grade Name', 'required');
            $this->form_validation->set_rules('instrument_id', 'Attribute Name', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Type Of Exam', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            $this->form_validation->set_rules('suite_id', 'Suite Name', 'trim');
            $this->form_validation->set_rules('fees', 'Fee', 'trim');

            $fee_management_info = $this->fee_management_model->get_fee_by_type_id($this->input->post('instrument_id'), $this->input->post('grade_id'));
            if (($fee_management['grade_id'] != $this->input->post('grade_id')) || ($fee_management['instrument_id'] != $this->input->post('instrument_id'))) {
                if ($fee_management_info) {
                    $this->form_validation->set_rules('grade_id', 'Grade Fees', 'trim|grade_check');
                    $this->form_validation->set_message('grade_check', 'Fee already exist.');
                }
            }


            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['fee_management'] = $fee_management;
                $data['exam_type_details'] = $exam_type_details;
                $data['view'] = 'admin/fee_management/edit';
                $data['exam_types'] = $this->fee_management_model->get_exam_types();
                $data['exam_suites'] = $this->fee_management_model->get_exam_suites();
                $data['exam_grades'] = $this->fee_management_model->get_exam_grade();
                $data['type_types'] = $this->fee_management_model->get_type_types($exam_type_details['exam_type_id']);
                $data['instruments'] = $this->fee_management_model->get_instruments($exam_type_details['exam_type_id'], $exam_type_details['type_types_id']);
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'grade_id' => $this->input->post('grade_id'),
                    'instrument_id' => $this->input->post('instrument_id'),
                    'suite_name' => $this->input->post('suite_id'),
                    'fees' => $this->input->post('fee'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->fee_management_model->edit_fee_management($data, $id);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(13);

                    $this->session->set_flashdata('msg', 'Fee has been updated successfully!');
                    redirect(base_url('admin/fee_management'));
                }
            }
        } else {
            $data['fee_management'] = $fee_management;
            $data['exam_type_details'] = $exam_type_details;
            $data['view'] = 'admin/fee_management/edit';
            $data['exam_types'] = $this->fee_management_model->get_exam_types();
            $data['exam_suites'] = $this->fee_management_model->get_exam_suites();
            $data['exam_grades'] = $this->fee_management_model->get_exam_grade();
            $data['type_types'] = $this->fee_management_model->get_type_types($exam_type_details['exam_type_id']);
            $data['instruments'] = $this->fee_management_model->get_instruments($exam_type_details['exam_type_id'], $exam_type_details['type_types_id']);
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function fee_management_del($id = 0)
    {

//        if ($this->exam_attribute_model->get_exam_attribute_from_exam($id)) {
//            $this->session->set_flashdata('error', 'Exam Attribute has association with Exam,please first remove the association.');
//            redirect(base_url('admin/exam_attribute'));
//        }
        $this->db->delete('ci_exam_suite_fees', array('id' => $id));

        // Add User Activity
        $this->activity_model->add(14);

        $this->session->set_flashdata('msg', 'Fee has been deleted successfully!');
        redirect(base_url('admin/fee_management'));
    }

    public function get_types_by_exam_type_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $exam_suites = $this->fee_management_model->get_types_by_exam_type_id($exam_type_id);
        echo json_encode($exam_suites);
    }

    public function get_instrument_by_exam_type_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $type_types_id = $this->input->post('type_types_id');
        $instrument = $this->fee_management_model->get_instrument_by_exam_type_id($exam_type_id, $type_types_id);
        echo json_encode($instrument);
    }

    public function get_grade_by_instrument_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $type_types_id = $this->input->post('type_types_id');
        $instrument_id = $this->input->post('instrument_id');
        $grade = $this->fee_management_model->get_grade($exam_type_id, $type_types_id, $instrument_id);
        echo json_encode($grade);
    }

    function grade_check($str)
    {
        if ($str) return false;
        else return true;
    }

}