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
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/';
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
                $row['created_date'],
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
        $obj = $this->exam_registration_model->get_single_submission_by_exam_id($id);
        $data['exam_detail'] = $obj;
        if (empty($data['exam_detail'])) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_submission_list'));
        }
        $data['exam_detail_info'] = $this->exam_registration_model->get_exam_details_by_id($obj->exam_id);
        $data['view'] = 'admin/exam_submission/submission_update';
        $this->load->view('layout', $data);
    }


    public function exam_submission_list()
    {
        $data['view'] = 'admin/exam_submission/exam_submission_list';
        $this->load->view('layout', $data);
    }


    //-----------------------------------------------------------------------
    public function exam_submission_search()
    {
        $data['view'] = 'admin/exam_submission/exam_submission_search';
        $data['exam_types'] = $this->exam_registration_model->get_exam_types();
        $data['exam_id'] = $this->input->post('exam_type') ? $this->input->post('exam_type') : NULL;
        $data['type_id'] = $this->input->post('type') ? $this->input->post('type') : NULL;
        $data['from_date'] = $this->input->post('from_date') ? $this->input->post('from_date') : NULL;
        $data['to_date'] = $this->input->post('to_date') ? $this->input->post('to_date') : NULL;
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
                ($row['fees'] + $row['penalty_fee']),
                '<a title="View" class="update btn btn-sm btn-info" href="' . base_url('admin/exam_registration/view_exam_submission/' . md5($row['ref_no'])) . '"> <i class="material-icons">visibility</i></a>' .
                '<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/exam_registration/submission_del/' . md5($row['ref_no'])) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>');
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function datatable_submission_search_json()
    {
        $exam_name = '';
        $exam_name_obj = '';
        $exam_type = $this->input->get('exam_type') ? $this->input->get('exam_type') : NULL;
        if ($exam_type) $exam_name_obj = $this->exam_registration_model->get_exam_type_by_id($exam_type);
        if (is_array($exam_name_obj)) $exam_name = $exam_name_obj['name'];
        $type = $this->input->get('type') ? $this->input->get('type') : NULL;
        $from_date = $this->input->get('from_date') ? $this->input->get('from_date') : NULL;
        $to_date = $this->input->get('to_date') ? $this->input->get('to_date') : NULL;
        $records = $this->exam_registration_model->get_submission_details_by_param($from_date, $to_date, $exam_name, $type);
        $data = array();
        foreach ($records['data'] as $row) {
            $data[] = array(
                $row['id'],
                $row['ref_no'],
                $row['first_name'],
                $row['last_name'],
                $row['dob'],
                $row['gender'],
                $row['exam_suite'],
                $row['instrument'],
                $row['grade']);
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
            redirect(base_url('admin/exam_registration/exam_submission_list'));
        }
        if ($this->exam_registration_model->delete_submission($id, $data['records'])) {
            $this->session->set_flashdata('msg', 'Information has been deleted successfully!');
            redirect(base_url('admin/exam_registration/exam_submission_list'));
        }

    }

    public function update_submission($id = null)
    {
        $obj = $this->exam_registration_model->get_single_submission_by_id($id);
        $data['exam_detail'] = $obj;
        $data['exam_detail_info'] = $this->exam_registration_model->get_exam_details_by_id($obj->exam_id);

        if (empty($data['exam_detail'])) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/exam_submission_list'));
        }
        $data['view'] = 'admin/exam_submission/submission_update';
        $this->load->view('layout', $data);
    }

    public function update_voucher_info()
    {
        $status = $this->input->post('status');
        $submission_id = $this->input->post('submission_id');
        $code = $this->input->post('voucher_code');
        $error = "";
        $update_submission = false;
        $voucher_details = '';
        if (!$code && !$status) {
            $error = "No Data Available for update";
        } else {
            if ($code) $voucher_details = $this->exam_registration_model->get_unused_voucher_by_code($code);
            if (empty($voucher_details) && $code) {
                $error = "Voucher Code not eligible for apply!";
                $code = '';
            }
            if (($voucher_details && $code) || $status == 'Pass') {
                $update_submission = $this->exam_registration_model->update_voucher_info($submission_id, $status, '');
            }
            if (($voucher_details && $code) && $status == 'Fail') {
                $update_submission = $this->exam_registration_model->update_voucher_info($submission_id, $status, $code);
            }
        }
        $response = array('update_status' => $update_submission, 'error_info' => $error);
        echo json_encode($response);

    }

    public function update_exam_info()
    {
        $exam = $this->input->post('exam');
        $exam_dates = $this->input->post('exam_dates');
        $submission_id = $this->input->post('submission_id');
        $update_exam_info = $this->exam_registration_model->update_exam_info($submission_id, $exam, $exam_dates);
        echo json_encode($update_exam_info);
    }

    public function get_type_types()
    {
        $exam_type_id = $this->input->post('exam_type');
        $exam_instruments = $this->exam_registration_model->get_exam_type_types_by_id($exam_type_id);
        echo json_encode($exam_instruments);
    }

    function submission_actions()
    {

        $this->form_validation->set_rules('form_action', "form_action", 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['id'])) {
                if ($this->input->post('form_action') == 'export_excel') {
                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle('Submission_List');
                    $this->excel->getActiveSheet()->SetCellValue('A1', 'Ref_No');
                    $this->excel->getActiveSheet()->SetCellValue('B1', 'ID');
                    $this->excel->getActiveSheet()->SetCellValue('C1', 'First Name');
                    $this->excel->getActiveSheet()->SetCellValue('D1', 'Last Name');
                    $this->excel->getActiveSheet()->SetCellValue('E1', 'DOB');
                    $this->excel->getActiveSheet()->SetCellValue('F1', 'Gender');
                    $this->excel->getActiveSheet()->SetCellValue('G1', 'Exam Suite');
                    $this->excel->getActiveSheet()->SetCellValue('H1', 'Instrument');
                    $this->excel->getActiveSheet()->SetCellValue('I1', 'Grade');
//
                    $row = 2;
                    foreach ($_POST['id'] as $id) {
                        $records = $this->exam_registration_model->get_submission_details_by_id($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $records[0]->ref_no);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $records[0]->id);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $records[0]->first_name);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $records[0]->last_name);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->functions->reformatDate($records[0]->dob));
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $records[0]->gender);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $records[0]->exam_suite);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $records[0]->instrument);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $records[0]->grade);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'submission_list_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');
                        set_time_limit(120);
                        ini_set('memory_limit', '256M');
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        ob_end_clean();
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', "No Date Selected.");
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    // File Upload
    public function update_voucher()
    {
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        if ($this->input->post('submit')) {
            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = "2048000";
                $config['overwrite'] = true;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                $csv = $this->upload->file_name;
                $data['attachment'] = $csv;

                $arrResult = array();
                $handle = fopen($this->digital_upload_path . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);

                $keys = array('voucher_code', 'fee');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                $rw = 2;

                foreach ($final as $csv_pr) {
                    if (isset($csv_pr['voucher_code']) && isset($csv_pr['fee'])) {
                        $voucher_details = $this->exam_registration_model->get_voucher_by_csv_code($csv_pr['voucher_code']);
                        if ($voucher_details) {
                            continue;
                        }

                        $obj[] = array(
                            'code' => $csv_pr['voucher_code'],
                            'fee' => $csv_pr['fee'],
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => $this->session->userdata('admin_id'),
                        );
                    }
                }
                if ($this->exam_registration_model->update_voucher($obj)) {
                    $this->session->set_flashdata('msg', count($obj) . ' records updated successfully.');
                    redirect(base_url('admin/exam_registration/update_voucher'));
                } else {
                    $this->session->set_flashdata('error', 'No data available for update.');
                    redirect($_SERVER["HTTP_REFERER"]);
                }


            } else {
                $data['error'] = array('error' => $this->upload->display_errors());
                $data['view'] = 'admin/exam_submission/update_voucher';
                $this->load->view('layout', $data);
            }
        } else {
            $data['title'] = 'Update Candidates';
            $data['view'] = 'admin/exam_submission/update_voucher';
            $this->load->view('layout', $data);
        }
    }

    public function update_candidates()
    {
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        if ($this->input->post('submit')) {
            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = "2048000";
                $config['overwrite'] = true;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                $csv = $this->upload->file_name;
                $data['attachment'] = $csv;

                $arrResult = array();
                $handle = fopen($this->digital_upload_path . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);

                $keys = array('ref_no', 'id', 'exam_no', 'exam_date', 'status', 'voucher_code');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                $rw = 2;

                foreach ($final as $csv_pr) {
                    if (isset($csv_pr['exam_no']) || isset($csv_pr['exam_date']) || isset($csv_pr['exam_no']) || isset($csv_pr['voucher_code'])) {
                        $voucher_details = $this->exam_registration_model->get_voucher_from_exam_by_code($csv_pr['voucher_code']);
                        if (!$voucher_details) {
                            $this->session->set_flashdata('error', 'Voucher code(' . $csv_pr['voucher_code'] . ') not available.');
                            redirect($_SERVER["HTTP_REFERER"]);
                        }

                        $submission_details = $this->exam_registration_model->get_submission_details($csv_pr['id'], $csv_pr['ref_no']);
                        if (!$submission_details) {
                            $this->session->set_flashdata('error', 'Candidate(' . $csv_pr['ref_no'] . ') submission is not exist.');
                            redirect($_SERVER["HTTP_REFERER"]);
                        }
                        $obj[] = array(
                            'ref_no' => $csv_pr['ref_no'],
                            'id' => $csv_pr['id'],
                            'exam_no' => $csv_pr['exam_no'],
                            'exam_date' => $this->returnDate($csv_pr['exam_date']),
                            'voucher_code' => $csv_pr['voucher_code'],
                            'status' => (($csv_pr['exam_no']) ? 'Fail' : 'Pass'),
                        );
                    }
                }
                if ($this->exam_registration_model->update_candidate_submission($obj, $submission_details->exam_id)) {
                    $this->session->set_flashdata('msg', count($obj) . ' records updated successfully.');
                    redirect(base_url('admin/exam_registration/update_candidates'));
                } else {
                    $this->session->set_flashdata('error', 'Operation failed.Please contact with system admin.');
                    redirect($_SERVER["HTTP_REFERER"]);
                }


            } else {
                $data['error'] = array('error' => $this->upload->display_errors());
                $data['view'] = 'admin/exam_submission/update_candidates';
                $this->load->view('layout', $data);
            }
        } else {
            $data['title'] = 'Update Candidates';
            $data['view'] = 'admin/exam_submission/update_candidates';
            $this->load->view('layout', $data);
        }

    }

    function returnDate($input_date)
    {
        $day = substr($input_date, 0, 2);
        $month = substr($input_date, 3, 2);
        $year = '20' . substr($input_date, 6, 2);
        $time = substr($input_date, 8);
        $output_date = $year . "-" . $month . "-" . $day . $time;
        return $output_date;
    }

}