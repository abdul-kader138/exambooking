<?php
/**
 * Created by a.kader
 * Email: codelover138@gmail.com
 * Date: 09-Sep-20
 * Time: 11:40 AM
 */

class Submission_time_model extends CI_Model
{
//---------------------------------------------------
    public function get_all_submission_time(){
        $wh =array();
        $SQL ='SELECT * FROM ci_submission_time';
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
    public function get_all_simple_submission_time(){
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_submission_time');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    public function count_all_submission_time(){
        return $this->db->count_all('ci_submission_time');
    }

    //---------------------------------------------------
    public function get_all_submission_time_for_pagination($limit, $offset){
        $wh =array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if(count($wh)>0){
            $WHERE = implode(' and ',$wh);
            $query = $this->db->get_where('ci_submission_time', $WHERE);
        }
        else{
            $query = $this->db->get('ci_submission_time');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    public function get_all_submission_time_by_advance_search(){
        $wh =array();
        $SQL ='SELECT * FROM ci_submission_time';
        if($this->session->userdata('submission_time_search_from')!='')
            $wh[]=" `created_date` >= '".date('Y-m-d', strtotime($this->session->userdata('submission_time_search_from')))."'";
        if($this->session->userdata('submission_time_search_to')!='')
            $wh[]=" `created_date` <= '".date('Y-m-d', strtotime($this->session->userdata('submission_time_search_to')))."'";
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

    public function add_submission_time($data){
        $this->db->insert('ci_submission_time', $data);
        return true;
    }
    //---------------------------------------------------
    public function get_active_time_by_date($date){
        $sql="SELECT * FROM ci_submission_time WHERE ('".$date."' BETWEEN start_date and end_date)";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function get_submission_time_by_id($id){
        $query = $this->db->get_where('ci_submission_time', array('md5(id)' => $id));
        return $result = $query->row_array();
    }
    public function edit_submission_time($data, $id){
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_submission_time', $data);
        return true;
    }



}