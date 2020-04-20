<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 11-Apr-20
 * Time: 12:16 PM
 */
class Exam_registration extends UR_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/exam_registration_model', 'exam_registration_model');
        $this->load->library('form_validation');
        $this->load->library('functions');
        $this->load->model('admin/branch_model', 'branch_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
        $this->checkUsersProfileStatus();
    }

    public function index()
    {
        $data['view'] = 'user/exam_registration/exam_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------

    public function datatable_json()
    {
//        $records = $this->branch_model->get_all_branches();
        $records = $this->exam_registration_model->get_all_user_exam_details();
        $data = array();
        foreach ($records['data'] as $row) {
            $data[] = array(
                $row['first_name'],
                $row['last_name'],
                $row['school_name'],
                $row['ic_no'],
                $row['time_venue'],
                $row['type_name'],
                $row['type_type'],
                $row['instrument_name'],
                $row['grade_name'],
                $row['exam_suite'],
                $row['fees'],
                '<a title="View" class="update btn btn-sm btn-info" href="' . base_url('user/exam_registration/view_exam/' . $row['id']) . '"> <i class="material-icons">visibility</i></a>
                 <a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('user/exam_registration/edit_exam/' . $row['id']) . '"> <i class="material-icons">edit</i></a>&nbsp;
				 <a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('user/exam_registration/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }
    public function datatable_json1()
    {
        $record_s = $this->exam_registration_model->get_all_users_exam();
        $records = $this->branch_model->get_all_branches();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {

            $data[] = array(
                ++$i,
                $row['full_name'],
                $row['time_venue'],
                $row['type_name'],
                $row['type_type'],
                $row['instrument_name'],
                $row['grade_name'],
                $row['exam_suite'],
                $row['fees'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/admins/admin_edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger " data-href="' . base_url('admin/admins/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }


    public function get_exam_details()
    {

        $exam_type_id = $this->input->post('exam_type');
        $exam_type = $this->exam_registration_model->get_exam_type_by_id($exam_type_id);
        $exam_type_types = $this->exam_registration_model->get_exam_type_types_by_id($exam_type_id);
        $time_venues = $this->exam_registration_model->get_time_venue();
        $view_name = isset($exam_type) ? strtolower($exam_type['name']) : '';

        $html = $this->load->view('user/exam_registration/' . $view_name . '_layout',
            array('exam_type_types' => $exam_type_types, 'time_venues' => $time_venues), TRUE
        );
        $return_data['html'] = $html;
        echo json_encode($return_data);
        exit;
    }

    public function get_exam_suite()
    {
        $grade_id = $this->input->post('grade_id');
        $instrument_id = $this->input->post('instrument_id');
        $exam_suites = $this->exam_registration_model->get_suite_by_exam_id($grade_id, $instrument_id);
        echo json_encode($exam_suites);
    }

    public function get_exam_type_grade()
    {
        $exam_type_type_id = $this->input->post('exam_type_type');
        $instruments_id = $this->input->post('instrument');
        $exam_grades = $this->exam_registration_model->get_grade_by_exam_id($exam_type_type_id,$instruments_id);
        echo json_encode($exam_grades);
    }

    public function get_exam_type_types()
    {
        $exam_type_id = $this->input->post('exam_type');
        $exam_type_type_id = $this->input->post('exam_type_type');
        $exam_instruments = $this->exam_registration_model->get_instrument_by_exam_id($exam_type_id, $exam_type_type_id);
        echo json_encode($exam_instruments);
    }

    public function add_exam()
    {

        $this->form_validation->set_rules('exam_type', "Exam Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('first_name', "First Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
        $this->form_validation->set_rules('last_name', "Last Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
//        $this->form_validation->set_rules('dob', "exam_type", 'xss_clean|trim|required|regex_match[/^(0[1-9]|1[012])([- /.])(0[1-9]|[12][0-9]|3[01])\2(19|20)\d\d/]');
        $this->form_validation->set_rules('gender', "Gender", 'xss_clean|trim|required');
        $this->form_validation->set_rules('ic_no', "IC No", 'xss_clean|trim|required');
        $this->form_validation->set_rules('school_name', "School Name", 'xss_clean|trim|required');
        $this->form_validation->set_rules('type', "Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('time_venue', "Time & Venue", 'xss_clean|trim|required');
        $this->form_validation->set_rules('instrument', "Instrument", 'xss_clean|trim|required');
        $this->form_validation->set_rules('grade', "Grade", 'xss_clean|trim|required');
        $this->form_validation->set_rules('fees', "Fees", 'xss_clean|trim|required');
        $this->form_validation->set_rules('exam_suite', "Exam Suite", 'xss_clean|trim');
        $this->form_validation->set_rules('group_name', "Group Name", 'xss_clean|trim');
        $this->form_validation->set_rules('voucher_code', "Voucher Code", 'xss_clean|trim');

        if ($this->form_validation->run() == true) {
            $data = array(
                'exam_type' => $this->input->post('exam_type'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'dob' => $this->functions->fsd($this->input->post('dob')),
                'ic_no' => $this->input->post('ic_no'),
                'school_name' => $this->input->post('school_name'),
                'type' => $this->input->post('type'),
                'time_venue' => $this->input->post('time_venue'),
                'instrument' => $this->input->post('instrument'),
                'grade' => $this->input->post('grade'),
                'fees' => $this->input->post('fees'),
                'exam_suite' => $this->input->post('exam_suite'),
                'voucher_code' => $this->input->post('voucher_code'),
                'group_name' => $this->input->post('group_name'),
                'created_date' => date('Y-m-d : h:m:s'),
                'created_by' => $this->session->userdata('user_id'),

            );
        }
        if ($this->form_validation->run() == true && $this->exam_registration_model->add_exam($data)) {
            $this->session->set_flashdata('msg', 'Exam information has been added successfully!');
            redirect(base_url('user/exam_registration'));
        }else{
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $data['exam_types'] = $this->exam_registration_model->get_exam_types();
            $data['title'] = 'Add New Exam';
            $data['view'] = 'user/exam_registration/add_exam';
            $this->load->view('layout', $data);
        }
    }

    public  function view_exam($id=null){
        $data['records'] =$this->exam_registration_model->get_user_exam_details_by_id($id);
        $data['view'] = 'user/exam_registration/view_exam';
        $this->load->view('layout', $data);
    }


    public function edit_exam($id=null)
    {

        $this->form_validation->set_rules('exam_type', "Exam Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('first_name', "First Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
        $this->form_validation->set_rules('last_name', "Last Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
//        $this->form_validation->set_rules('dob', "exam_type", 'xss_clean|trim|required|regex_match[/^(0[1-9]|1[012])([- /.])(0[1-9]|[12][0-9]|3[01])\2(19|20)\d\d/]');
        $this->form_validation->set_rules('gender', "Gender", 'xss_clean|trim|required');
        $this->form_validation->set_rules('ic_no', "IC No", 'xss_clean|trim|required');
        $this->form_validation->set_rules('school_name', "School Name", 'xss_clean|trim|required');
        $this->form_validation->set_rules('type', "Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('time_venue', "Time & Venue", 'xss_clean|trim|required');
        $this->form_validation->set_rules('instrument', "Instrument", 'xss_clean|trim|required');
        $this->form_validation->set_rules('grade', "Grade", 'xss_clean|trim|required');
        $this->form_validation->set_rules('fees', "Fees", 'xss_clean|trim|required');
        $this->form_validation->set_rules('exam_suite', "Exam Suite", 'xss_clean|trim');
        $this->form_validation->set_rules('group_name', "Group Name", 'xss_clean|trim');
        $this->form_validation->set_rules('voucher_code', "Voucher Code", 'xss_clean|trim');

        if ($this->form_validation->run() == true) {
            $data = array(
                'exam_type' => $this->input->post('exam_type'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'dob' => $this->functions->fsd($this->input->post('dob')),
                'ic_no' => $this->input->post('ic_no'),
                'school_name' => $this->input->post('school_name'),
                'type' => $this->input->post('type'),
                'time_venue' => $this->input->post('time_venue'),
                'instrument' => $this->input->post('instrument'),
                'grade' => $this->input->post('grade'),
                'fees' => $this->input->post('fees'),
                'exam_suite' => $this->input->post('exam_suite'),
                'voucher_code' => $this->input->post('voucher_code'),
                'group_name' => $this->input->post('group_name'),
                'created_date' => date('Y-m-d : h:m:s'),
                'created_by' => $this->session->userdata('user_id'),

            );
        }
        if ($this->form_validation->run() == true && $this->exam_registration_model->add_exam($data)) {
            $this->session->set_flashdata('msg', 'Exam information has been added successfully!');
            redirect(base_url('user/exam_registration'));
        }else{
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $records =$this->exam_registration_model->get_user_exam_details_by_id($id);
            $data['records'] =$records;
            $data['exam_types'] = $this->exam_registration_model->get_exam_types();
            $data['exam_type_types'] = $this->exam_registration_model->get_exam_type_types_by_id($records->exam_type_id);
            $data['time_venues'] = $this->exam_registration_model->get_time_venue();
            $data['grade_lists'] = $this->exam_registration_model->get_grade_by_exam_id($records->type_types_id,$records->instrument_id);
            $data['instrument_lists'] = $this->exam_registration_model->get_instrument_by_exam_id($records->exam_type_id, $records->type_types_id);

            $data['title'] = 'Edit Exam';
            $data['view'] = 'user/exam_registration/edit_exam';
            $this->load->view('layout', $data);
        }
    }
    //-----------------------------------------------------------------------
    public function del($id = 0)
    {

       //@todo
        // later implement check for any association
        $this->db->delete('ci_user_exam_details', array('id' => $id));
        $this->session->set_flashdata('msg', 'Exam has been deleted successfully!');
        redirect(base_url('user/exam_registration'));
    }


}