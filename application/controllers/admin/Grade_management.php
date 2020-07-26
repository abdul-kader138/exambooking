<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 29-Mar-20
 * Time: 10:45 PM
 */

class Grade_management extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/grade_management_model', 'grade_management_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/grade_management/grade_management_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->grade_management_model->get_all_grade_management();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['type_name'],
                $row['type_types_name'],
                $row['instrument_name'],
                $row['grade_name'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/grade_management/grade_management_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
				 <a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/grade_management/grade_management_del/' . md5($row['id'])) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function grade_management_add()
    {
        if ($this->input->post('submit')) {

            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('error', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('grade_name', 'Grade Name', 'trim|required');
            $this->form_validation->set_rules('instrument_id', 'Attribute Name', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Type Of Exam', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');

            // uniqueness checking
            $grade_management_info = $this->grade_management_model->get_grade_by_type_id($this->input->post('exam_type'), $this->input->post('type'),
                $this->input->post('instrument_id'), trim($this->input->post('grade_name')));
            if ($grade_management_info) {
                $this->form_validation->set_rules('grade_name', 'Grade Name', 'is_unique[ci_exam_grade_diploma.grade_name]');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/grade_management/add';
                $data['exam_types'] = $this->grade_management_model->get_exam_types();
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'grade_name' => $this->input->post('grade_name'),
                    'instrument_id' => $this->input->post('instrument_id'),
                    'exam_type_id' => $this->input->post('exam_type'),
                    'type_types_id' => $this->input->post('type'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->grade_management_model->add_grade_management($data);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Grade Management has been added successfully!');
                    redirect(base_url('admin/grade_management'));
                }
            }
        } else {
            $data['exam_types'] = $this->grade_management_model->get_exam_types();
            $data['view'] = 'admin/grade_management/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function grade_management_edit($id = null)
    {
        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);

        // Existence Checking
        $grade_management = $this->grade_management_model->get_grade_management_by_id($id);
        if (empty($grade_management)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/grade_management'));
        }

        // Association Checking with User Exam
        $grade_association = $this->grade_management_model->get_exam_details_by_grade_id($id);
        if ($grade_association) {
            $this->session->set_flashdata('error', 'Information edit not possible due to association with exam!!');
            redirect(base_url('admin/grade_management'));
        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('grade_name', 'Grade Name', 'trim|required');
            $this->form_validation->set_rules('instrument_id', 'Attribute Name', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Type Of Exam', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');

            $grade_management_info = $this->grade_management_model->get_grade_by_type_id($this->input->post('exam_type'), $this->input->post('type'),
                $this->input->post('instrument_id'), trim($this->input->post('grade_name')));
            if ($grade_management['instrument_id'] != $this->input->post('instrument_id') || strtolower($grade_management['grade_name']) != strtolower(trim($this->input->post('grade_name')))) {
                if ($grade_management_info) {
                    $this->form_validation->set_rules('grade_name', 'Grade Name', 'is_unique[ci_exam_grade_diploma.grade_name]');
                }
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['grade_management'] = $grade_management;
                $data['view'] = 'admin/grade_management/edit';
                $data['exam_types'] = $this->grade_management_model->get_exam_types();
                $data['type_types'] = $this->grade_management_model->get_type_types($grade_management['exam_type_id']);
                $data['instruments'] = $this->grade_management_model->get_instruments($grade_management['exam_type_id'], $grade_management['type_types_id']);
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'grade_name' => $this->input->post('grade_name'),
                    'instrument_id' => $this->input->post('instrument_id'),
                    'exam_type_id' => $this->input->post('exam_type'),
                    'type_types_id' => $this->input->post('type'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->grade_management_model->edit_grade_management($data, $id);
                if ($result) {
                    $this->session->set_flashdata('msg', 'Grade has been updated successfully!');
                    redirect(base_url('admin/grade_management'));
                }
            }
        } else {
            $data['grade_management'] = $grade_management;
            $data['view'] = 'admin/grade_management/edit';
            $data['exam_types'] = $this->grade_management_model->get_exam_types();
            $data['type_types'] = $this->grade_management_model->get_type_types($grade_management['exam_type_id']);
            $data['instruments'] = $this->grade_management_model->get_instruments($grade_management['exam_type_id'], $grade_management['type_types_id']);
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function grade_management_del($id = 0)
    {

        $id = $this->secure_data($id);

        // Existence Checking
        $grade_management = $this->grade_management_model->get_grade_management_by_id($id);
        if (empty($grade_management)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/grade_management'));
        }

        // Association Checking with User Exam
        $exam_association = $this->grade_management_model->get_exam_details_by_grade_id($id);
        if ($exam_association) {
            $this->session->set_flashdata('error', 'Information delete not possible due to association with exam!!');
            redirect(base_url('admin/grade_management'));
        }

        // Association Checking with User grade
        $grade_association = $this->grade_management_model->get_grade_from_fees_by_id($id);
        if ($grade_association) {
            $this->session->set_flashdata('error', 'Information delete not possible due to association with grade!!');
            redirect(base_url('admin/grade_management'));
        }


        $this->db->delete('ci_exam_grade_diploma', array('md5(id)' => $id));
        $this->session->set_flashdata('msg', 'Grade has been deleted successfully!');
        redirect(base_url('admin/grade_management'));
    }

    public function get_types_by_exam_type_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $exam_suites = $this->grade_management_model->get_types_by_exam_type_id($exam_type_id);
        echo json_encode($exam_suites);
    }

    public function get_instrument_by_exam_type_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $type_types_id = $this->input->post('type_types_id');
        $grade = $this->grade_management_model->get_instrument_by_exam_type_id($exam_type_id, $type_types_id);
        echo json_encode($grade);
    }

}