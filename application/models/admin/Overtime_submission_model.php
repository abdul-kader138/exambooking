<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 07-Sep-20
 * Time: 9:01 PM
 */

class Overtime_submission_model extends CI_Model{
    public function add_voucher($data){
         $this->db->insert('ci_overtime_submission', $data);
         return true;
    }
    //---------------------------------------------------
    public function get_all_voucher(){
        $wh =array();
        $SQL ='SELECT * FROM ci_overtime_submission';
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
        $query = $this->db->get('ci_overtime_submission');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    public function count_all_voucher(){
        return $this->db->count_all('ci_overtime_submission');
    }

    //---------------------------------------------------
    public function get_all_voucher_for_pagination($limit, $offset){
        $wh =array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if(count($wh)>0){
            $WHERE = implode(' and ',$wh);
            $query = $this->db->get_where('ci_overtime_submission', $WHERE);
        }
        else{
            $query = $this->db->get('ci_overtime_submission');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    public function get_all_voucher_by_advance_search(){
        $wh =array();
        $SQL ='SELECT * FROM ci_overtime_submission';
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
    public function get_voucher_by_id($id){
        $query = $this->db->get_where('ci_overtime_submission', array('md5(id)' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function edit_voucher($data, $id){
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_overtime_submission', $data);
        return true;
    }


    public function get_submission_from_voucher_by_code($id){
        $query = $this->db->get_where('ci_exam_submission_details', array('overtime_code' => $id));
        return $result = $query->row_array();
    }

    public function get_voucher_from_exam_by_code($id){
        $query = $this->db->get_where('ci_user_exam_details', array('LOWER(voucher_code)' => strtolower(trim($id))));
        return $result = $query->row_array();
    }

}