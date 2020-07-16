<?php
class Exam_suite_model extends CI_Model{
    public function add_exam_suite($data){
        $this->db->insert('ci_exam_suite', $data);
        return true;
    }
    //---------------------------------------------------
    // get all branch for server-side datatable processing (ajax based)
    public function get_all_exam_suite(){
        $wh =array();
        $SQL ='SELECT * FROM ci_exam_suite';
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
    // get all exam_suite records
    public function get_all_simple_exam_suite(){
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_exam_suite');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    // Count total exam_suite for pagination
    public function count_all_exam_suite(){
        return $this->db->count_all('ci_exam_suite');
    }

    //---------------------------------------------------
    // Get all exam_suite for pagination
    public function get_all_exam_suite_for_pagination($limit, $offset){
        $wh =array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if(count($wh)>0){
            $WHERE = implode(' and ',$wh);
            $query = $this->db->get_where('ci_exam_suite', $WHERE);
        }
        else{
            $query = $this->db->get('ci_exam_suite');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    // get all exam_suite for server-side datatable with advanced search
    public function get_all_exam_suite_by_advance_search(){
        $wh =array();
        $SQL ='SELECT * FROM ci_exam_suite';
        if($this->session->userdata('exam_suite_search_from')!='')
            $wh[]=" `created_date` >= '".date('Y-m-d', strtotime($this->session->userdata('exam_suite_search_from')))."'";
        if($this->session->userdata('exam_suite_search_to')!='')
            $wh[]=" `created_date` <= '".date('Y-m-d', strtotime($this->session->userdata('exam_suite_search_to')))."'";
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
    // Get exam_suite detial by ID
    public function get_exam_suite_by_id($id){
        $query = $this->db->get_where('ci_exam_suite', array('md5(id)' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    // Edit exam_suite Record
    public function edit_exam_suite($data, $id){
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_exam_suite', $data);
        return true;
    }

    // check exam_suite association from users table by ID
    public function get_exam_suite_from_exam($id){
//        $query = $this->db->get_where('ci_user_exam_details', array('exam_suite_id' => $id));
//        return $result = $query->row_array();
    }

}

?>