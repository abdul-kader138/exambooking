<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 11-Apr-20
 * Time: 12:16 PM
 */
class Exam_registration extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/exam_registration_model', 'exam_registration_model');
        $this->load->library('form_validation');
        $this->load->library('functions');
        $this->load->model('admin/branch_model', 'branch_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    public function index()
    {
        $data['view'] = 'admin/exam_registration/exam_list';
        $data['user_exam_details'] = $this->exam_registration_model->get_user_all_exam_list();
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
                $row['venue_details'],
                $row['type_name'],
                $row['type_type'],
                $row['instrument_name'],
                $row['grade_name'],
                $row['fees'],
                $row['submitted'],
                '<a title="View" class="update btn btn-sm btn-info" href="' . base_url('admin/exam_registration/view_exam/' . md5($row['id'])) . '"> <i class="material-icons">visibility</i></a>',
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
        $time_venues = $this->exam_registration_model->get_time_venue($exam_type_id);
        $view_name = isset($exam_type) ? strtolower($exam_type['name']) : '';

        $html = $this->load->view('admin/exam_registration/' . $view_name . '_layout',
            array('exam_type_types' => $exam_type_types, 'time_venues' => $time_venues), TRUE
        );
        $return_data['html'] = $html;
        echo json_encode($return_data);
        exit;
    }

    public function get_types_by_exam_type_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $exam_suites = $this->exam_registration_model->get_types_by_exam_type_id($exam_type_id);
        echo json_encode($exam_suites);
    }

    public function get_venues_by_exam_type_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $time_venues = $this->exam_registration_model->get_time_venue($exam_type_id);
        echo json_encode($time_venues);
    }


    public function get_exam_type_grade()
    {
        $exam_type_type_id = $this->input->post('exam_type_type');
        $instruments_id = $this->input->post('instrument');
        $exam_grades = $this->exam_registration_model->get_grade_by_exam_id($exam_type_type_id, $instruments_id);
        echo json_encode($exam_grades);
    }

    public function get_exam_type_types()
    {
        $exam_type_id = $this->input->post('exam_type');
        $exam_type_type_id = $this->input->post('exam_type_type');
        $exam_instruments = $this->exam_registration_model->get_instrument_by_exam_id($exam_type_id, $exam_type_type_id);
        echo json_encode($exam_instruments);
    }

    public function get_exam_suite()
    {
        $grade_id = $this->input->post('grade_id');
        $instrument_id = $this->input->post('instrument_id');
        $exam_suites = $this->exam_registration_model->get_suite_by_exam_id($grade_id, $instrument_id);
        echo json_encode($exam_suites);
    }


    public function view_exam($id = null)
    {
        $data['records'] = $this->exam_registration_model->get_user_exam_details_by_id($id);
        if (empty($data['records'])) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_registration'));
        }
        $data['view'] = 'admin/exam_registration/view_exam';
        $this->load->view('layout', $data);
    }


    public function exam_submission_list()
    {
        $data['view'] = 'admin/exam_submission/exam_submission_list';
        $this->load->view('layout', $data);
    }


    //-----------------------------------------------------------------------

    public function datatable_submission_json()
    {
//        $records = $this->branch_model->get_all_branches();

        $records = $this->exam_registration_model->get_all_exam_submission_details();
        $data = array();
        foreach ($records['data'] as $row) {
            $data[] = array(
                $row['firstname'],
                $row['created_date'],
                $row['ref_no'],
                $row['id'],
                $row['fees'],
                '<a title="View" class="update btn btn-sm btn-info" href="' . base_url('admin/exam_registration/view_exam_submission/' . md5($row['ref_no'])) . '"> <i class="material-icons">visibility</i></a>
                 <a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/exam_registration/submission_del/' . md5($row['ref_no'])) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>');
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function view_exam_submission($id = null)
    {
        $data['records'] = $this->exam_registration_model->get_exam_submission_id($id);
        if (empty($data['records'])) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_submission_list'));
        }
        $data['view'] = 'admin/exam_submission/view_exam_submission';
        $this->load->view('layout', $data);
    }

    public function submission_del($id = null)
    {
        $data['records'] = $this->exam_registration_model->get_exam_submission_id($id);
        if (empty($data['records'])) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_submission_list'));
        }
        $this->db->delete('ci_exam_submission_details', array('md5(ref_no)' => $id));
        $this->session->set_flashdata('msg', 'Exam Attribute has been deleted successfully!');
        redirect(base_url('admin/exam_attribute'));
    }
    public function update_submission($id = null)
    {
        $data['exam_detail'] = $this->exam_registration_model->get_single_submission_by_id($id);
        if (empty($data['exam_detail'])) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_submission_list'));
        }
        $data['view'] = 'admin/exam_submission/submission_update';
        $this->load->view('layout', $data);
    }

}