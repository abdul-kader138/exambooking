<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 11-Apr-20
 * Time: 12:16 PM
 */
class Exam_submission extends UR_Controller
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

    public function submit_exam()
    {

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $data['exam_details'] = $this->exam_registration_model->get_user_all_exam_details();
        $data['title'] = 'Exam Submission';
        $data['view'] = 'user/exam_submission/submit_exam';
        $this->load->view('layout', $data);
    }

    public function save_submit_exam()
    {
        $total_fees = 0;
        if ($this->input->post('submit')) {
            if (!empty($_POST['val'])) {
                $user_details = $this->exam_registration_model->get_user_detail();
                $branch_admin_list = $this->exam_registration_model->get_branch_admin($user_details['branch_id']);
                $super_admin_list = $this->exam_registration_model->get_super_admin();
                foreach ($_POST['val'] as $id) {
                    $exam_details = $this->exam_registration_model->get_user_exam_details_by_id($id);
                    $total_fees += $exam_details->fees;
                    $employees[] = array(
                        'exam_id' => $id,
                        'first_name' => $exam_details->first_name,
                        'ref_no' => 'S-' . strtotime(date("Y-m-d H:i:s")),
                        'last_name' => $exam_details->last_name,
                        'venue' => $exam_details->venue_details,
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
                $this->email_send_user($employees[0], $total_fees, $user_details);
                if (!empty($branch_admin_list)) {
                    foreach ($branch_admin_list as $admin) {
                        $this->email_send_admin($employees[0], $total_fees, $user_details, $admin->email);
                    }
                }
                if (!empty($super_admin_list)) {
                    foreach ($super_admin_list as $super_admin) {
                        $this->email_send_admin($employees[0], $total_fees, $user_details, $super_admin->email);
                    }
                }
                $submission_details = $this->exam_registration_model->get_submission_summary($employees[0]['ref_no']);
                $this->session->set_userdata('submission_details', $submission_details);
                redirect(base_url('user/exam_submission/exam_submission_success'));
            }
        } else {
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $data['exam_details'] = $this->exam_registration_model->get_user_all_exam_details();
            $data['title'] = 'Exam Submission';
            $data['view'] = 'user/exam_submission/submit_exam';
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
        $data['view'] = 'user/exam_submission/submit_success';
        $obj = $this->session->all_userdata();
        $data['submission_details'] = $obj['submission_details'];
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
                '<a title="View" class="update btn btn-sm btn-info" href="' . base_url('user/exam_submission/view_exam_submission/' . md5($row['ref_no'])) . '"> <i class="material-icons">visibility</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function view_exam_submission($id = null)
    {
        $data['records'] = $this->exam_registration_model->get_exam_submission_id($id);
        if (empty($data['records'])) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('user/exam_submission_list'));
        }
        $data['view'] = 'user/exam_submission/view_exam_submission';
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
            'submission_link' => base_url('user/exam_submission/view_exam_submission/' . $data['ref_no']),
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