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
            $edit_link = '';
            $delete_link = '';
            if ($row['submitted'] == 'No') $edit_link = '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('user/exam_registration/edit_exam/' . $row['id']) . '"> <i class="material-icons">edit</i></a>&nbsp;';
            if ($row['submitted'] == 'No') $delete_link = '<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('user/exam_registration/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>';
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
                '<a title="View" class="update btn btn-sm btn-info" href="' . base_url('user/exam_registration/view_exam/' . $row['id']) . '"> <i class="material-icons">visibility</i></a>' . $edit_link . $delete_link,
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

        $html = $this->load->view('user/exam_registration/' . $view_name . '_layout',
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

    public function add_exam()
    {

        $this->form_validation->set_rules('exam_type', "Exam Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('first_name', "First Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
        $this->form_validation->set_rules('last_name', "Last Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
        $this->form_validation->set_rules('dob', "Date of Birth", 'xss_clean|trim|required');
//        $this->form_validation->set_rules('dob', "exam_type", 'xss_clean|trim|required|regex_match[/^(0[1-9]|1[012])([- /.])(0[1-9]|[12][0-9]|3[01])\2(19|20)\d\d/]');
        $this->form_validation->set_rules('gender', "Gender", 'xss_clean|trim|required');
//        $this->form_validation->set_rules('ic_no', "IC No", 'xss_clean|trim|required');
        $this->form_validation->set_rules('school_name', "School Name", 'xss_clean|trim');
        $this->form_validation->set_rules('type', "Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('time_venue', "Time & Venue", 'xss_clean|trim|required');
        $this->form_validation->set_rules('instrument', "Instrument", 'xss_clean|trim|required');
        $this->form_validation->set_rules('grade', "Grade", 'xss_clean|trim|required');
        $this->form_validation->set_rules('fees', "Fees", 'xss_clean|trim|required');
        $this->form_validation->set_rules('exam_suite', "Exam Suite", 'xss_clean|trim');
        $this->form_validation->set_rules('group_name', "Group Name", 'xss_clean|trim');
        $this->form_validation->set_rules('voucher_code', "Voucher Code", 'xss_clean|trim');

        if ($this->form_validation->run() == true) {
            $venue=$this->exam_registration_model->get_time_venue_by_id($this->input->post('time_venue'));
            $venue_details=$venue->time_venue;
            if(trim($venue->time_venue) == "Others") $venue_details=$this->input->post('time_venue_other');
            $data = array(
                'exam_type' => $this->input->post('exam_type'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'venue_details' => $venue_details,
                'dob' => $this->input->post('dob'),
                'dob' => $this->input->post('dob'),
                'school_name' => $this->input->post('school_name'),
                'type' => $this->input->post('type'),
                'time_venue' => $this->input->post('time_venue'),
                'instrument' => $this->input->post('instrument'),
                'grade' => $this->input->post('grade'),
                'fees' => $this->input->post('fees'),
                'exam_suite' => $this->input->post('exam_suite'),
                'voucher_code' => $this->input->post('voucher_code'),
                'group_name' => $this->input->post('group_name'),
                'created_date' => date('Y-m-d h:i:s'),
                'created_by' => $this->session->userdata('user_id'),

            );
        }
        if ($this->form_validation->run() == true && $this->exam_registration_model->add_exam($data)) {
            $this->session->set_flashdata('msg', 'Exam information has been added successfully!');
            redirect(base_url('user/exam_registration'));
        } else {
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $data['exam_types'] = $this->exam_registration_model->get_exam_types();
            $data['title'] = 'Add New Exam';
            $data['view'] = 'user/exam_registration/add_exam';
            $this->load->view('layout', $data);
        }
    }

    public function view_exam($id = null)
    {
        $data['records'] = $this->exam_registration_model->get_user_exam_details_by_id($id);
        $data['view'] = 'user/exam_registration/view_exam';
        $this->load->view('layout', $data);
    }


    public function edit_exam($id = null)
    {

        $this->form_validation->set_rules('exam_type', "Exam Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('first_name', "First Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
        $this->form_validation->set_rules('last_name', "Last Name", 'xss_clean|trim|required|regex_match[/^\+?[a-z A-Z]+$/]');
//        $this->form_validation->set_rules('dob', "exam_type", 'xss_clean|trim|required|regex_match[/^(0[1-9]|1[012])([- /.])(0[1-9]|[12][0-9]|3[01])\2(19|20)\d\d/]');
        $this->form_validation->set_rules('gender', "Gender", 'xss_clean|trim|required');
//        $this->form_validation->set_rules('ic_no', "IC No", 'xss_clean|trim|required');
        $this->form_validation->set_rules('school_name', "School Name", 'xss_clean|trim');
        $this->form_validation->set_rules('type', "Type", 'xss_clean|trim|required');
        $this->form_validation->set_rules('time_venue', "Time & Venue", 'xss_clean|trim|required');
        $this->form_validation->set_rules('instrument', "Instrument", 'xss_clean|trim|required');
        $this->form_validation->set_rules('grade', "Grade", 'xss_clean|trim|required');
        $this->form_validation->set_rules('fees', "Fees", 'xss_clean|trim|required');
        $this->form_validation->set_rules('exam_suite', "Exam Suite", 'xss_clean|trim');
        $this->form_validation->set_rules('group_name', "Group Name", 'xss_clean|trim');
        $this->form_validation->set_rules('voucher_code', "Voucher Code", 'xss_clean|trim');
        $records = $this->exam_registration_model->get_user_exam_details_by_id($id);

        if ($records->submitted == 'Yes') {
            $this->session->set_flashdata('error', 'Exam information already submitted.');
            redirect(base_url('user/exam_registration'));
        }

        if ($this->form_validation->run() == true) {
            $venue=$this->exam_registration_model->get_time_venue_by_id($this->input->post('time_venue'));
            $venue_details=$venue->time_venue;
            if(trim($venue->time_venue) == "Others") $venue_details=$this->input->post('time_venue_other');
            $data = array(
                'exam_type' => $this->input->post('exam_type'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'dob' => $this->input->post('dob'),
                'venue_details'=>$venue_details,
                'school_name' => $this->input->post('school_name'),
                'type' => $this->input->post('type'),
                'time_venue' => $this->input->post('time_venue'),
                'instrument' => $this->input->post('instrument'),
                'grade' => $this->input->post('grade'),
                'fees' => $this->input->post('fees'),
                'exam_suite' => $this->input->post('exam_suite'),
                'voucher_code' => $this->input->post('voucher_code'),
                'group_name' => $this->input->post('group_name'),
                'updated_date' => date('Y-m-d h:i:s'),
                'updated_by' => $this->session->userdata('user_id'),

            );
        }
        if ($this->form_validation->run() == true && $this->exam_registration_model->update_exam($data, $id)) {
            $this->session->set_flashdata('msg', 'Exam information has been updated successfully!');
            redirect(base_url('user/exam_registration'));
        } else {
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $data['records'] = $records;
            $data['exam_types'] = $this->exam_registration_model->get_exam_types();
            $data['exam_type_types'] = $this->exam_registration_model->get_exam_type_types_by_id($records->exam_type_id);
            $data['time_venues'] = $this->exam_registration_model->get_time_venue($records->exam_type_id);
            $data['grade_lists'] = $this->exam_registration_model->get_grade_by_exam_id($records->type_types_id, $records->instrument_id);
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

    public function submit_exam()
    {

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $data['exam_details'] = $this->exam_registration_model->get_user_all_exam_details();
        $data['title'] = 'Exam Submission';
        $data['view'] = 'user/exam_registration/submit_exam';
        $this->load->view('layout', $data);
    }

    public function save_submit_exam()
    {
        $total_fees = 0;
        if ($this->input->post('submit')) {
            if (!empty($_POST['val'])) {
                $user_details = $this->exam_registration_model->get_user_detail();
                $branch_admin_list = $this->exam_registration_model->get_branch_admin($user_details['branch_id']);
                foreach ($_POST['val'] as $id) {
                    $exam_details = $this->exam_registration_model->get_user_exam_details_by_id($id);
                    $total_fees += $exam_details->fees;
                    $employees[] = array(
                        'exam_id' => $id,
                        'first_name' => $exam_details->first_name,
                        'ref_no' => 'S-' . strtotime(date("Y-m-d H:i:s")),
                        'last_name' => $exam_details->last_name,
                        'venue' => $exam_details->time_venue,
                        'exam_types' => $exam_details->type_name,
                        'type_types' => $exam_details->type_type,
                        'grade' => $exam_details->grade_name,
                        'instrument' => $exam_details->instrument_name,
                        'exam_suite' => $exam_details->exam_suite,
                        'fees' => $exam_details->fees,
                        'created_date' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),

                    );
                }
            }
            if (isset($employees) && $this->exam_registration_model->add_exam_submission($employees)) {
                $this->email_send_admin($employees[0], $total_fees, $user_details, 'kam@mindyourapp.com.my');
                $this->email_send_user($employees[0], $total_fees, $user_details);
                if (!empty($branch_admin_list)) {
                    foreach ($branch_admin_list as $admin) {
                        $this->email_send_admin($employees[0], $total_fees, $user_details, $admin->email);
                    }
                }
                $submission_details = $this->exam_registration_model->get_submission_summary($employees[0]['ref_no']);
                $this->session->set_userdata('submission_details', $submission_details);
                redirect(base_url('user/exam_registration/exam_submission_success'));
            }
        } else {
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $data['exam_details'] = $this->exam_registration_model->get_user_all_exam_details();
            $data['title'] = 'Exam Submission';
            $data['view'] = 'user/exam_registration/submit_exam';
            $this->load->view('layout', $data);
        }
    }

    public function exam_submission_list()
    {
        $data['view'] = 'user/exam_submission/exam_submission_list';
        $this->load->view('layout', $data);
    }

    public function exam_submission_success()
    {
        $data['title'] = 'Exam Submission';
        $data['view'] = 'user/exam_registration/submit_success';
        $obj =  $this->session->all_userdata();
        $data['submission_details'] =  $obj['submission_details'];
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
                $row['created_date'],
                $row['ref_no'],
                $row['id'],
                $row['fees'],
                '<a title="View" class="update btn btn-sm btn-info" href="' . base_url('user/exam_registration/view_exam_submission/' . $row['ref_no']) . '"> <i class="material-icons">visibility</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function view_exam_submission($id = null)
    {
        $data['records'] = $this->exam_registration_model->get_exam_submission_id($id);
        $data['view'] = 'user/exam_registration/view_exam_submission';
        $this->load->view('layout', $data);
    }

    public function email_send_admin($data, $fees, $user_details, $user_email)
    {
        $this->load->library('parser');
        $parse_data = array(
            'user' => $user_details['firstname'] . " " . $user_details['lastname'],
            'ref_no' => $data['ref_no'],
            'submission_date' => $data['created_date'],
            'total_amount' => $fees,
            'submission_link' => base_url('user/exam_registration/view_exam_submission/' . $data['ref_no']),
        );
        $msg = file_get_contents('uploads/email_templates/exam_submission.html');
        $message = $this->parser->parse_string($msg, $parse_data);
        $subject = 'Notification for Exam Submission (' . $data['ref_no'] . ')';
        $this->load->helper('email_helper');
        $email = sendEmail($user_email, $subject, $message, $file = '', $cc = '');

    }

    public function email_send_user($data, $fees, $user_details)
    {
        $this->load->library('parser');
        $parse_data = array(
            'user' => $user_details['firstname'] . " " . $user_details['lastname'],
            'ref_no' => $data['ref_no'],
            'submission_date' => $data['created_date'],
            'total_amount' => $fees
        );
        $msg = file_get_contents('uploads/email_templates/exam_submission_user.html');
        $message = $this->parser->parse_string($msg, $parse_data);
        $subject = 'Notification for Exam Submission (' . $data['ref_no'] . ')';
        $this->load->helper('email_helper');
        $response = sendEmail($user_details['email'], $subject, $message, $file = '', $cc = '');
    }

}