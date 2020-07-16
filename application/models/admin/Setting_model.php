<?php
class Setting_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	public function update_general_setting($data){
		$this->db->where('id', 1);
		$this->db->update('ci_general_settings', $data);
		return true;

	}

	//-----------------------------------------------------
    public function update_terms($data){
        $this->db->where('id', 1);
        $this->db->update('ci_terms_condition', $data);
        return true;

    }

	//-----------------------------------------------------
	public function get_general_settings(){
		$this->db->where('id', 1);
        $query = $this->db->get('ci_general_settings');
        return $query->row_array();
	}


    //-----------------------------------------------------
    public function get_terms(){
        $this->db->where('id', 1);
        $query = $this->db->get('ci_terms_condition');
        return $query->row_array();
    }
}
?>