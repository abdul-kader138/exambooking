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
        $this->checkUsersProfileStatus();
    }

    public function index()
    {

    }

    public function get_exam_details(){

        $exam_type_id=$this->input->post('exam_type');
        $exam_type=$this->exam_registration_model->get_exam_type_by_id($exam_type_id);
        $exam_type_types=$this->exam_registration_model->get_exam_type_types_by_id($exam_type_id);
        $time_venues=$this->exam_registration_model->get_time_venue();
        $view_name=isset($exam_type)?strtolower($exam_type['name']):'';

        $html= $this->load->view('user/exam_registration/'.$view_name.'_layout',
            array('exam_type_types' => $exam_type_types,'time_venues'=>$time_venues), TRUE
        );
        $return_data['html'] = $html;
        echo json_encode($return_data);
        exit;
    }
    public function get_exam_suite(){
        $exam_type_type_id=$this->input->post('exam_type_type');
        $exam_suites=$this->exam_registration_model->get_suite_by_exam_id($exam_type_type_id);
        echo json_encode($exam_suites);
    }
    public function get_exam_type_grade(){
        $exam_type_type_id=$this->input->post('exam_type_type');
        $exam_grades=$this->exam_registration_model->get_grade_by_exam_id($exam_type_type_id);
        echo json_encode($exam_grades);
    }
    public function get_exam_type_types(){
        $exam_type_id=$this->input->post('exam_type');
        $exam_type_type_id=$this->input->post('exam_type_type');
        $exam_instruments=$this->exam_registration_model->get_instrument_by_exam_id($exam_type_id,$exam_type_type_id);
        echo json_encode($exam_instruments);
    }
    public function add_exam()
    {
        $data['exam_types'] = $this->exam_registration_model->get_exam_types();
        $data['title'] = 'Add New Exam';
        $data['view'] = 'user/exam_registration/add_exam';
        $this->load->view('layout', $data);
    }


}