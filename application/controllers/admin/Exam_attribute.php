<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 29-Mar-20
 * Time: 10:45 PM
 */

class Exam_attribute extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/exam_attribute_model', 'exam_attribute_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/exam_attribute/exam_attribute_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->exam_attribute_model->get_all_exam_attribute();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['type_name'],
                $row['type_types_name'],
                $row['attribute_name'],
//                $row['created_date'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/exam_attribute/exam_attribute_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
					<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/exam_attribute/exam_attribute_del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function exam_attribute_add()
    {
        if ($this->input->post('submit')) {

            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('error', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('attribute_name', 'Attribute Name', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Type Of Exam', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            $exam_attribute_info = $this->exam_attribute_model->get_attribute_by_type_id($this->input->post('exam_type'), $this->input->post('type'), trim($this->input->post('attribute_name')));
            if (strtolower($exam_attribute_info['instrument_name']) == strtolower(trim($this->input->post('attribute_name')))) {
                $this->form_validation->set_rules('attribute_name', 'Attribute Name', 'is_unique[ci_exam_instrument_product.instrument_name]');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/exam_attribute/add';
                $data['exam_types'] = $this->exam_attribute_model->get_exam_types();
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'instrument_name' => $this->input->post('attribute_name'),
                    'exam_type_id' => $this->input->post('exam_type'),
                    'type_types_id' => $this->input->post('type'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->exam_attribute_model->add_exam_attribute($data);
                if ($result) {
                    // Add User Activity
                    $this->activity_model->add(12);
                    $this->session->set_flashdata('msg', 'Exam Attribute has been added successfully!');
                    redirect(base_url('admin/exam_attribute'));
                }
            }
        } else {
            $data['exam_types'] = $this->exam_attribute_model->get_exam_types();
            $data['view'] = 'admin/exam_attribute/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function exam_attribute_edit($id = null)
    {
        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);
        $exam_attribute = $this->exam_attribute_model->get_exam_attribute_by_id($id);

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('attribute_name', 'Attribute Name', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Type Of Exam', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            $exam_attribute_info = $this->exam_attribute_model->get_attribute_by_type_id($this->input->post('exam_type'), $this->input->post('type'), trim($this->input->post('attribute_name')));
            if (strtolower($exam_attribute['name']) != strtolower(trim($this->input->post('attribute_name')))) {
                if (strtolower($exam_attribute_info['instrument_name']) == strtolower(trim($this->input->post('attribute_name')))) {
                    $this->form_validation->set_rules('attribute_name', 'Attribute Name', 'is_unique[ci_exam_instrument_product.instrument_name]');
                }
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['exam_attribute'] = $exam_attribute;
                $data['view'] = 'admin/exam_attribute/edit';
                $data['exam_types'] = $this->exam_attribute_model->get_exam_types();
                $data['type_types'] = $this->exam_attribute_model->get_type_types($exam_attribute['exam_type_id']);
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'instrument_name' => $this->input->post('attribute_name'),
                    'exam_type_id' => $this->input->post('exam_type'),
                    'type_types_id' => $this->input->post('type'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->exam_attribute_model->edit_exam_attribute($data, $id);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(13);

                    $this->session->set_flashdata('msg', 'Exam Attribute has been updated successfully!');
                    redirect(base_url('admin/exam_attribute'));
                }
            }
        } else {
            $data['exam_attribute'] = $exam_attribute;
            $data['view'] = 'admin/exam_attribute/edit';
            $data['exam_types'] = $this->exam_attribute_model->get_exam_types();
            $data['type_types'] = $this->exam_attribute_model->get_type_types($exam_attribute['exam_type_id']);
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function exam_attribute_del($id = 0)
    {

//        if ($this->exam_attribute_model->get_exam_attribute_from_exam($id)) {
//            $this->session->set_flashdata('error', 'Exam Attribute has association with Exam,please first remove the association.');
//            redirect(base_url('admin/exam_attribute'));
//        }
        $this->db->delete('ci_exam_instrument_product', array('id' => $id));

        // Add User Activity
        $this->activity_model->add(14);

        $this->session->set_flashdata('msg', 'Exam Attribute has been deleted successfully!');
        redirect(base_url('admin/exam_attribute'));
    }

    public function get_types_by_exam_type_id()
    {
        $exam_type_id = $this->input->post('exam_type');
        $exam_suites = $this->exam_attribute_model->get_types_by_exam_type_id($exam_type_id);
        echo json_encode($exam_suites);
    }

}