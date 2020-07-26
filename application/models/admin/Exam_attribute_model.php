<?php

class Exam_attribute_model extends CI_Model
{
    public function add_exam_attribute($data)
    {
        $this->db->insert('ci_exam_instrument_product', $data);
        return true;
    }
    //---------------------------------------------------
    public function get_all_exam_attribute()
    {
        $wh = array();
        $SQL = 'SELECT ci_exam_instrument_product.id,ci_exam_instrument_product.instrument_name as attribute_name,
                ci_exam_type.name as type_name, ci_exam_type_types.name as type_types_name, 
                ci_exam_instrument_product.created_date FROM ci_exam_instrument_product inner join ci_exam_type on 
                ci_exam_instrument_product.exam_type_id=ci_exam_type.id 
                INNER join ci_exam_type_types on ci_exam_instrument_product.type_types_id=ci_exam_type_types.id';
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }

    //---------------------------------------------------
    public function get_all_simple_exam_attribute()
    {
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_exam_instrument_product');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    public function count_all_exam_attribute()
    {
        return $this->db->count_all('ci_exam_instrument_product');
    }

    //---------------------------------------------------
    public function get_all_exam_attribute_for_pagination($limit, $offset)
    {
        $wh = array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            $query = $this->db->get_where('ci_exam_instrument_product', $WHERE);
        } else {
            $query = $this->db->get('ci_exam_instrument_product');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    public function get_all_exam_attribute_by_advance_search()
    {
        $wh = array();
        $SQL = 'SELECT * FROM ci_exam_suite';
        if ($this->session->userdata('exam_attribute_search_from') != '')
            $wh[] = " `created_date` >= '" . date('Y-m-d', strtotime($this->session->userdata('exam_attribute_search_from'))) . "'";
        if ($this->session->userdata('exam_attribute_search_to') != '')
            $wh[] = " `created_date` <= '" . date('Y-m-d', strtotime($this->session->userdata('exam_attribute_search_to'))) . "'";
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }
    //---------------------------------------------------
    public function get_exam_attribute_by_id($id)
    {
        $query = $this->db->get_where('ci_exam_instrument_product', array('md5(id)' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function get_attribute_by_type_id($exam_type,$type_id,$name)
    {
        $test=strtolower($name);
        $query = $this->db->get_where('ci_exam_instrument_product', array('exam_type_id' => $exam_type,'type_types_id' => $type_id,'LOWER(instrument_name)' => strtolower($name)));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function edit_exam_attribute($data, $id)
    {
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_exam_instrument_product', $data);
        return true;
    }

    //---------------------------------------------------

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


    //---------------------------------------------------
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
    public function get_type_types($id)
    {
        $this->db->where('exam_type_id',$id);
        $query = $this->db->get('ci_exam_type_types');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_attribute_from_grade_by_id($id){
        $query = $this->db->get_where('ci_exam_grade_diploma', array('instrument_id' => $id));
        return $result = $query->row_array();
    }

    public function get_exam_details_by_instrument_id($id){
        $query = $this->db->get_where('ci_user_exam_details', array('md5(instrument)' => $id));
        return $result = $query->row_array();
    }
}

?>