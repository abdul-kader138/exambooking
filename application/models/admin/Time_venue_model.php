<?php
class Time_venue_model extends CI_Model{
    public function add_time_venue($data){
        $this->db->insert('ci_time_venue', $data);
        return true;
    }
    //---------------------------------------------------
    public function get_all_time_venue(){
        $wh =array();
        $SQL ='SELECT ci_time_venue.id,ci_time_venue.time_venue,ci_exam_type.name
               FROM ci_time_venue left join ci_exam_type on ci_time_venue.exam_type_id=ci_exam_type.id';
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
    public function get_all_simple_time_venue(){
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('ci_time_venue');
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    public function count_all_time_venue(){
        return $this->db->count_all('ci_time_venue');
    }

    //---------------------------------------------------
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
    public function edit_time_venue($data, $id){
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_time_venue', $data);
        return true;
    }

    //---------------------------------------------------
    public function get_venue_by_type_id($exam_type,$name)
    {
        $test=strtolower($name);
        $query = $this->db->get_where('ci_time_venue', array('exam_type_id' => $exam_type,'LOWER(time_venue)' => strtolower($name)));
        return $result = $query->row_array();
    }

    public function get_venue_from_exam_by_id($id){
        $query = $this->db->get_where('ci_user_exam_details', array('time_venue' => $id));
        return $result = $query->row_array();
    }

}

?>