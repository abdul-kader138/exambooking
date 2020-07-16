<?php
class Voucher_model extends CI_Model{
    public function add_voucher($data){
        $this->db->insert('ci_voucher', $data);
        return true;
    }
    //---------------------------------------------------
    public function get_all_voucher(){
        $wh =array();
        $SQL ='SELECT * FROM ci_voucher';
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
    public function get_all_simple_voucher(){
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_voucher');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    public function count_all_voucher(){
        return $this->db->count_all('ci_voucher');
    }

    //---------------------------------------------------
    public function get_all_voucher_for_pagination($limit, $offset){
        $wh =array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if(count($wh)>0){
            $WHERE = implode(' and ',$wh);
            $query = $this->db->get_where('ci_voucher', $WHERE);
        }
        else{
            $query = $this->db->get('ci_voucher');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    // get all exam_suite for server-side datatable with advanced search
    public function get_all_voucher_by_advance_search(){
        $wh =array();
        $SQL ='SELECT * FROM ci_voucher';
        if($this->session->userdata('voucher_search_from')!='')
            $wh[]=" `created_date` >= '".date('Y-m-d', strtotime($this->session->userdata('voucher_search_from')))."'";
        if($this->session->userdata('voucher_search_to')!='')
            $wh[]=" `created_date` <= '".date('Y-m-d', strtotime($this->session->userdata('voucher_search_to')))."'";
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
    public function get_voucher_by_id($id){
        $query = $this->db->get_where('ci_voucher', array('md5(id)' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    // Edit exam_suite Record
    public function edit_voucher($data, $id){
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_voucher', $data);
        return true;
    }

    // check exam_suite association from users table by ID
    public function get_voucher_from_exam($id){
//        $query = $this->db->get_where('ci_user_exam_details', array('exam_suite_id' => $id));
//        return $result = $query->row_array();
    }

}

?>