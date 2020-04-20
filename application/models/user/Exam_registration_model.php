<?php

class Exam_registration_model extends CI_Model
{

    public function add_exam($data)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->insert('ci_user_exam_details', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return false;
        return true;
    }
    //---------------------------------------------------
    // get all user exam for server-side datatable processing (ajax based)
    public function get_all_user_exam_details()
    {
        $wh =array();
        $SQL ='SELECT ci_user_exam_details.id,ci_user_exam_details.first_name,ci_user_exam_details.last_name,
               ci_time_venue.time_venue, ci_exam_type.name type_name,ci_exam_type_types.name type_type,
               ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,ci_user_exam_details.exam_suite,
               ci_user_exam_details.fees,ci_user_exam_details.school_name,ci_user_exam_details.ic_no FROM ci_user_exam_details 
               inner join ci_time_venue on ci_user_exam_details.time_venue=ci_time_venue.id inner join ci_exam_type on 
               ci_user_exam_details.exam_type=ci_exam_type.id inner join ci_exam_type_types on 
               ci_user_exam_details.exam_type=ci_exam_type_types.exam_type_id and ci_user_exam_details.type=ci_exam_type_types.id inner join 
               ci_exam_instrument_product on ci_user_exam_details.instrument=ci_exam_instrument_product.id inner join ci_exam_grade_diploma 
               on ci_user_exam_details.grade=ci_exam_grade_diploma.id';
        if($this->session->userdata('user_id')!='')
            $wh[]="ci_user_exam_details.created_by = '".$this->session->userdata('user_id')."'";

        if(count($wh)>0)
        {
            $WHERE = implode(' and ',$wh);
            return $this->datatable->LoadJson($SQL,$WHERE);
        }
        else
        {
            return $this->datatable->LoadJson($SQL);
        }
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
    // Get Exam Types by id
    public function get_exam_type_by_id($id = null)
    {
        $query = $this->db->get_where('ci_exam_type', array('id' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    // Get Exam Type Types
    public function get_exam_type_types_by_id($id = null)
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
    public function get_instrument_by_exam_id($exam_type_id = null, $exam_type_types_id = null)
    {
        $query = $this->db->get_where('ci_exam_instrument_product', array('exam_type_id' => $exam_type_id, 'type_types_id' => $exam_type_types_id));
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
    public function get_grade_by_exam_id($exam_type_types_id = null,$instruments_id=null)
    {
        $this->db->select('ci_exam_grade_diploma.id,ci_exam_grade_diploma.grade_name')
            ->join('ci_exam_suite_fees', 'ci_exam_grade_diploma.id=ci_exam_suite_fees.grade_id', 'left');
        $this->db->where('ci_exam_suite_fees.fees !=', '');
        $this->db->where('ci_exam_suite_fees.instrument_id', $instruments_id);
        $query = $this->db->get_where('ci_exam_grade_diploma', array('type_types_id' => $exam_type_types_id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //---------------------------------------------------
    public function get_user_exam_details_by_id($id)
    {
        $this->db->select('ci_user_exam_details.id,ci_user_exam_details.dob,ci_user_exam_details.gender,
        ci_user_exam_details.group_name,ci_user_exam_details.first_name,ci_user_exam_details.last_name,
		ci_time_venue.time_venue,ci_time_venue.id venue_id,ci_exam_type.id exam_type_id,ci_exam_type.name type_name,
		ci_exam_type_types.id type_types_id,ci_exam_type_types.name type_type,ci_exam_instrument_product.id instrument_id,
		ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,ci_exam_grade_diploma.id grade_id,
		ci_user_exam_details.exam_suite,ci_user_exam_details.voucher_code,ci_user_exam_details.fees,
		ci_user_exam_details.school_name,ci_user_exam_details.ic_no')
            ->join('ci_time_venue', 'ci_user_exam_details.time_venue=ci_time_venue.id', 'inner')
        ->join('ci_exam_type', 'ci_user_exam_details.exam_type=ci_exam_type.id', 'inner')
        ->join('ci_exam_type_types', 'ci_user_exam_details.type=ci_exam_type_types.id', 'inner')
        ->join('ci_exam_instrument_product', 'ci_user_exam_details.instrument=ci_exam_instrument_product.id', 'inner')
        ->join('ci_exam_grade_diploma', 'ci_user_exam_details.grade=ci_exam_grade_diploma.id', 'inner');
        $query = $this->db->get_where('ci_user_exam_details', array('ci_user_exam_details.id' => $id));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;

    }

    //---------------------------------------------------
    // Get Exam Type fee Details
    public function get_suite_by_exam_id($grade_id = null, $instrument_id = null)
    {
        $query = $this->db->get_where('ci_exam_suite_fees', array('grade_id' => $grade_id, 'instrument_id' => $instrument_id), 1);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

}

?>