<?php
	class Exam_registration_model extends CI_Model
    {

        //--------------------------------------------------------------------
        public function get_user_detail()
        {
            $id = $this->session->userdata('user_id');
            $query = $this->db->get_where('ci_users', array('id' => $id));
            return $result = $query->row_array();
        }

        //--------------------------------------------------------------------
        public function update_user($data)
        {
            $id = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update('ci_users', $data);
            return true;
        }

        //--------------------------------------------------------------------
        public function change_pwd($data, $id)
        {
            $this->db->where('id', $id);
            $this->db->update('ci_users', $data);
            return true;
        }

        //---------------------------------------------------
        // Get User Role/Group
        public function get_user_groups()
        {
            $id = $this->session->userdata('role');
//            $query = $this->db->get('ci_user_groups');
            $query = $this->db->get_where('ci_user_groups', array('id' => $id), 1);
            return $result = $query->row_array();
        }

        //---------------------------------------------------
        // Get Exam Types
        public function get_exam_types()
        {
            $query = $this->db->get('ci_exam_type');
            if ($query->num_rows() > 0) {
                foreach (($query->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }

        //---------------------------------------------------
       // Get Exam Type
        public function get_exam_type_by_id($id=null)
        {
            $query = $this->db->get_where('ci_exam_type', array('id' => $id));
            return $result = $query->row_array();
        }

        //---------------------------------------------------
        // Get Exam Type Types
        public function get_exam_type_types_by_id($id=null)
        {
            $query = $this->db->get_where('ci_exam_type_types', array('exam_type_id' => $id));
            if ($query->num_rows() > 0) {
                foreach (($query->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }

        //---------------------------------------------------
        // Get Time &  Venue
        public function get_time_venue()
        {
            $query = $this->db->get('ci_time_venue');
            if ($query->num_rows() > 0) {
                foreach (($query->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }

        //---------------------------------------------------
        // Get Exam Type Types Details
    public function get_instrument_by_exam_id($exam_type_id=null,$exam_type_types_id=null)
    {
        $query = $this->db->get_where('ci_exam_instrument_product', array('exam_type_id' => $exam_type_id,'type_types_id'=>$exam_type_types_id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

        //---------------------------------------------------
        // Get Exam Type grade Details
        public function get_grade_by_exam_id($exam_type_types_id=null)
        {
            $query = $this->db->get_where('ci_exam_grade_diploma', array('type_types_id'=>$exam_type_types_id));
            if ($query->num_rows() > 0) {
                foreach (($query->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }

        //---------------------------------------------------
        // Get Exam Type fee Details
        public function get_suite_by_exam_id($grade_id=null,$instrument_id=null)
        {
            $query = $this->db->get_where('ci_exam_suite_fees', array('grade_id'=>$grade_id,'instrument_id'=>$instrument_id),1);
            if ($query->num_rows() > 0) {
                return $query->row();
            }
            return false;
        }

    }

?>