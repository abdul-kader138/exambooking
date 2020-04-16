<?php

class Dashboard_model extends CI_Model
{

    public function get_all_users()
    {
        if ($this->session->userdata('admin_type') == 3) {

            $this->db->select('count(id) as total', FALSE)
                ->where('is_admin', 0)
                ->where('branch_id', $this->session->userdata('branch_id'));
            $q = $this->db->get('ci_users');
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        } else {
            $this->db->select('count(id) as total', FALSE)
                ->where('is_admin',0);
            $q = $this->db->get('ci_users');
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        }
    }

    public function get_active_users()
    {
        $this->db->where('is_active', 1);
        if ($this->session->userdata('admin_type') == 3) {

            $this->db->select('count(id) as total', FALSE)
                ->where('is_admin', 0)
                ->where('branch_id', $this->session->userdata('branch_id'));
            $q = $this->db->get('ci_users');
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        } else {
            $this->db->select('count(id) as total', FALSE)
                ->where('is_admin',0);
            $q = $this->db->get('ci_users');
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        }
    }

    public function get_deactive_users()
    {
        $this->db->where('is_active', 0);
        if ($this->session->userdata('admin_type') == 3) {

            $this->db->select('count(id) as total', FALSE)
                ->where('branch_id', $this->session->userdata('branch_id'))
                ->where('is_admin', 0);
            $q = $this->db->get('ci_users');
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        } else {
            $this->db->select('count(id) as total', FALSE)
                ->where('is_admin',0);
            $q = $this->db->get('ci_users');
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        }
    }
}

?>
