<?php

class Exam_suite_model extends CI_Model
{
    public function add_exam_suite($data)
    {
        $this->db->insert('ci_exam_suite', $data);
        return true;
    }

    //---------------------------------------------------
    public function get_all_exam_suite()
    {
        $wh = array();
        $SQL = 'SELECT * FROM ci_exam_suite';
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }

    //---------------------------------------------------
    public function get_all_simple_exam_suite()
    {
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_exam_suite');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    public function count_all_exam_suite()
    {
        return $this->db->count_all('ci_exam_suite');
    }

    //---------------------------------------------------
    public function get_all_exam_suite_for_pagination($limit, $offset)
    {
        $wh = array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            $query = $this->db->get_where('ci_exam_suite', $WHERE);
        } else {
            $query = $this->db->get('ci_exam_suite');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    public function get_all_exam_suite_by_advance_search()
    {
        $wh = array();
        $SQL = 'SELECT * FROM ci_exam_suite';
        if ($this->session->userdata('exam_suite_search_from') != '')
            $wh[] = " `created_date` >= '" . date('Y-m-d', strtotime($this->session->userdata('exam_suite_search_from'))) . "'";
        if ($this->session->userdata('exam_suite_search_to') != '')
            $wh[] = " `created_date` <= '" . date('Y-m-d', strtotime($this->session->userdata('exam_suite_search_to'))) . "'";
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }

    //---------------------------------------------------
    public function get_exam_suite_by_id($id)
    {
        $query = $this->db->get_where('ci_exam_suite', array('md5(id)' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function edit_exam_suite($data, $id)
    {
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_exam_suite', $data);
        return true;
    }

}

?>