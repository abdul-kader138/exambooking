<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Time_venue extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_type') != '2') {
            redirect('/');
        }
        $this->load->model('admin/time_venue_model', 'time_venue_model');
        $this->load->model('activity_model', 'activity_model');
        $this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    //-----------------------------------------------------------------------
    public function index()
    {
        $data['view'] = 'admin/time_venue/time_venue_list';
        $this->load->view('layout', $data);
    }

    //-----------------------------------------------------------------------
    public function datatable_json()
    {
        $records = $this->time_venue_model->get_all_time_venue();
        $data = array();
        $i = 0;
        foreach ($records['data'] as $row) {
            $data[] = array(
                ++$i,
                $row['time_venue'],
                $row['name'],
                '<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/time_venue/time_venue_edit/' . md5($row['id'])) . '"> <i class="material-icons">edit</i></a>
					<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/time_venue/time_venue_del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',

            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    //-----------------------------------------------------------------------
    public function time_venue_add()
    {
        if ($this->input->post('submit')) {

            if (!$this->session->userdata('is_admin_login')) {
                $this->session->set_flashdata('error', 'Access Denied!!!');
                redirect(base_url('admin'));
            }

            $this->form_validation->set_rules('time_venue', 'Time Venue', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Type Of Exam', 'trim|required');
            $time_venue_info = $this->time_venue_model->get_venue_by_type_id($this->input->post('exam_type'), trim($this->input->post('time_venue')));
            if (strtolower($time_venue_info['time_venue']) == strtolower(trim($this->input->post('time_venue')))) {
                $this->form_validation->set_rules('time_venue', 'Time & Venue', 'is_unique[ci_time_venue.time_venue]');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['view'] = 'admin/time_venue/add';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'time_venue' => $this->input->post('time_venue'),
                    'exam_type_id' => $this->input->post('exam_type'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->time_venue_model->add_time_venue($data);
                if ($result) {
                    // Add User Activity
                    $this->activity_model->add(12);

                    $this->session->set_flashdata('msg', 'Time & Venue has been added successfully!');
                    redirect(base_url('admin/time_venue'));
                }
            }
        } else {
            $data['view'] = 'admin/time_venue/add';
            $this->load->view('layout', $data);
        }

    }

    //-----------------------------------------------------------------------
    public function time_venue_edit($id = 0)
    {

        //Access check
        if (!$this->session->userdata('is_admin_login')) {
            $this->session->set_flashdata('error', 'Access Denied!!!');
            redirect(base_url('admin'));
        }
        $id = $this->secure_data($id);
        $time_venue_info = $this->time_venue_model->get_time_venue_by_id($id);
        if (empty($time_venue_info)) {
            $this->session->set_flashdata('error', 'Information not found!!');
            redirect(base_url('admin/time_venue'));
        }
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('time_venue', 'Time Venue', 'trim|required');
            $this->form_validation->set_rules('exam_type', 'Time Venue', 'trim|required');
            if (strtolower($time_venue_info['time_venue']) != strtolower(trim($this->input->post('time_venue')))) {
                $time_venue = $this->time_venue_model->get_venue_by_type_id($this->input->post('exam_type'), trim($this->input->post('time_venue')));
                if ($time_venue) {
                    $this->form_validation->set_rules('time_venue', 'Time & Venue', 'is_unique[ci_time_venue.time_venue]');
                }
            }

            if ($this->form_validation->run() == FALSE) {
                $this->data['msg'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $data['exam_type'] = $time_venue_info;
                $data['view'] = 'admin/time_venue/edit';
                $this->load->view('layout', $data);
            } else {
                $data = array(
                    'time_venue' => $this->input->post('time_venue'),
                    'exam_type_id' => $this->input->post('exam_type'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('admin_id'),
                );
                $data = $this->security->xss_clean($data);
                $result = $this->time_venue_model->edit_time_venue($data, $id);
                if ($result) {

                    // Add User Activity
                    $this->activity_model->add(13);

                    $this->session->set_flashdata('msg', 'Time & Venue has been updated successfully!');
                    redirect(base_url('admin/time_venue'));
                }
            }
        } else {
            $data['time_venue'] = $time_venue_info;
            $data['view'] = 'admin/time_venue/edit';
            $this->load->view('layout', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function time_venue_del($id = 0)
    {

        if($this->time_venue_model->get_venue_from_exam_by_id($id)){
            $this->session->set_flashdata('error', 'Venue name has association with Exam,please first remove the association.');
            redirect(base_url('admin/time_venue'));
        }
        $this->db->delete('ci_time_venue', array('id' => $id));

        // Add User Activity
        $this->activity_model->add(14);

        $this->session->set_flashdata('msg', 'Time & Venue has been deleted successfully!');
        redirect(base_url('admin/time_venue'));
    }

}

?>