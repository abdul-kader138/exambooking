<?php

class User_model extends CI_Model
{

    //--------------------------------------------------------------------
    public function get_user_detail()
    {
        $id = $this->session->userdata('user_id');
        $query = $this->db->get_where('ci_users', array('id' => $id));
        return $result = $query->row_array();
    }

    //--------------------------------------------------------------------
    public function update_user($data)
    {
        $id = $this->session->userdata('user_id');
        $this->db->where('id', $id);
        $this->db->update('ci_users', $data);
        return true;
    }

    //--------------------------------------------------------------------
    public function change_pwd($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('ci_users', $data);
        return true;
    }

    //---------------------------------------------------
    // Get User Role/Group
    public function get_user_groups()
    {
        $id = $this->session->userdata('role');
//            $query = $this->db->get('ci_user_groups');
        $query = $this->db->get_where('ci_user_groups', array('id' => $id), 1);
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    // Get Branch
    public function get_branches()
    {
        $this->db->where('id', $this->session->userdata('branch_id'));
        $query = $this->db->get('ci_branches');
        return $result = $query->result_array();
    }

}

?>