<?php
class Time_venue_model extends CI_Model{
    public function add_time_venue($data){
        $this->db->insert('ci_time_venue', $data);
        return true;
    }
    //---------------------------------------------------
    // get all branch for server-side datatable processing (ajax based)
    public function get_all_time_venue(){
        $wh =array();
        $SQL ='SELECT ci_time_venue.id,ci_time_venue.time_venue as time_venue,ci_exam_type.name as e_name FROM ci_time_venue left join ci_exam_type on ci_time_venue.exam_type_id=ci_exam_type.id';
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
    public function get_all_simple_time_venue(){
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_time_venue');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    // Count total exam_suite for pagination
    public function count_all_time_venue(){
        return $this->db->count_all('ci_time_venue');
    }

    //---------------------------------------------------
    // Get all exam_suite for pagination
    public function get_all_time_venue_for_pagination($limit, $offset){
        $wh =array();
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);

        if(count($wh)>0){
            $WHERE = implode(' and ',$wh);
            $query = $this->db->get_where('ci_time_venue', $WHERE);
        }
        else{
            $query = $this->db->get('ci_time_venue');
        }
        return $query->result_array();
        //echo $this->db->last_query();
    }


    //---------------------------------------------------
    // get all exam_suite for server-side datatable with advanced search
    public function get_all_time_venue_by_advance_search(){
        $wh =array();
        $SQL ='SELECT * FROM ci_time_venue';
        if($this->session->userdata('time_venue_search_from')!='')
            $wh[]=" `created_date` >= '".date('Y-m-d', strtotime($this->session->userdata('time_venue_search_from')))."'";
        if($this->session->userdata('time_venue_search_to')!='')
            $wh[]=" `created_date` <= '".date('Y-m-d', strtotime($this->session->userdata('time_venue_search_to')))."'";
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
    public function get_time_venue_by_id($id){
        $query = $this->db->get_where('ci_time_venue', array('md5(id)' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    // Edit exam_suite Record
    public function edit_time_venue($data, $id){
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_time_venue', $data);
        return true;
    }

    // check exam_suite association from users table by ID
    public function get_exam_suite_from_exam($id){
//        $query = $this->db->get_where('ci_user_exam_details', array('exam_suite_id' => $id));
//        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function get_venue_by_type_id($exam_type,$name)
    {
        $test=strtolower($name);
        $query = $this->db->get_where('ci_time_venue', array('exam_type_id' => $exam_type,'LOWER(time_venue)' => strtolower($name)));
        return $result = $query->row_array();
    }

}

?>