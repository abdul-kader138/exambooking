<?php

class Fee_management_model extends CI_Model
{
    public function add_fee_management($data)
    {
        $this->db->insert('ci_exam_suite_fees', $data);
        return true;
    }

    //---------------------------------------------------
    public function get_all_fee_management()
    {
        $wh = array();
        $SQL = 'SELECT ci_exam_suite_fees.id,ci_exam_type.name,ci_exam_type_types.name type_name,
                ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,
                ci_exam_suite_fees.fees,ci_exam_suite.name suite_name FROM ci_exam_suite_fees 
                inner join ci_exam_grade_diploma on ci_exam_suite_fees.grade_id=ci_exam_grade_diploma.id
                inner join ci_exam_instrument_product on ci_exam_suite_fees.instrument_id=ci_exam_instrument_product.id
                inner join ci_exam_type_types on ci_exam_grade_diploma.type_types_id=ci_exam_type_types.id 
                inner join ci_exam_type on ci_exam_grade_diploma.exam_type_id=ci_exam_type.id left join 
                ci_exam_suite on ci_exam_suite_fees.suite_name=ci_exam_suite.id';
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }

    //---------------------------------------------------
    public function get_all_simple_fee_management()
    {
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_exam_suite_fees');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    public function count_all_fee_management()
    {
        return $this->db->count_all('ci_exam_fee_diploma');
    }

    //---------------------------------------------------
    public function get_all_fee_management_for_pagination($limit, $offset)
    {
        $wh = array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            $query = $this->db->get_where('ci_exam_suite_fees', $WHERE);
        } else {
            $query = $this->db->get('ci_exam_grade_diploma');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    public function get_all_fee_management_by_advance_search()
    {
        $wh = array();
        $SQL = 'SELECT * FROM ci_exam_suite_fees';
        if ($this->session->userdata('fee_management_search_from') != '')
            $wh[] = " `created_date` >= '" . date('Y-m-d', strtotime($this->session->userdata('fee_management_search_from'))) . "'";
        if ($this->session->userdata('fee_management_search_to') != '')
            $wh[] = " `created_date` <= '" . date('Y-m-d', strtotime($this->session->userdata('fee_management_search_to'))) . "'";
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }


    }


    //---------------------------------------------------
    public function get_fee_management_by_id($id)
    {
        $query = $this->db->get_where('ci_exam_suite_fees', array('md5(id)' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function get_fee_by_type_id($instrument_id, $grade_id)
    {
        $query = $this->db->get_where('ci_exam_suite_fees', array('instrument_id' => $instrument_id, 'grade_id' => $grade_id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function edit_fee_management($data, $id)
    {
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_exam_suite_fees', $data);
        return true;
    }


    public function get_types_by_exam_type_id($id = null)
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

    public function get_exam_suites()
    {
        $query = $this->db->get('ci_exam_suite');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_type_types($id)
    {
        $this->db->where('exam_type_id', $id);
        $query = $this->db->get('ci_exam_type_types');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_instrument_by_exam_type_id($id = null, $types_id = null)
    {
        $query = $this->db->get_where('ci_exam_instrument_product', array('exam_type_id' => $id, 'type_types_id' => $types_id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_instruments($id, $types_id)
    {
        $this->db->where('exam_type_id', $id);
        $this->db->where('type_types_id', $types_id);
        $query = $this->db->get('ci_exam_instrument_product');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_grade($id, $types_id, $instrument_id)
    {
        $this->db->where('exam_type_id', $id);
        $this->db->where('type_types_id', $types_id);
        $this->db->where('instrument_id', $instrument_id);
        $query = $this->db->get('ci_exam_grade_diploma');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_exam_attribute_by_id($id)
    {
        $query = $this->db->get_where('ci_exam_instrument_product', array('id' => $id));
        return $result = $query->row_array();
    }

    public function get_exam_grade()
    {
        $query = $this->db->get('ci_exam_grade_diploma');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_fee_from_exam_fee_by_id($instrument,$grade,$suite_name,$fees){
        $query = $this->db->get_where('ci_user_exam_details', array('instrument' => $instrument,'grade'=>$grade,'LOWER(exam_suite)'=>strtolower($suite_name),'fees'=>$fees));
        return $result = $query->row_array();
    }

    public function get_fee_from_exam_by_id($instrument,$grade,$suite_name){
        $query = $this->db->get_where('ci_user_exam_details', array('instrument' => $instrument,'grade'=>$grade,'LOWER(exam_suite)'=>strtolower($suite_name)));
        return $result = $query->row_array();
    }
    public function get_exam_suite_by_id($id)
    {
        $query = $this->db->get_where('ci_exam_suite', array('id' => $id));
        return $result = $query->row_array();
    }
}

?>