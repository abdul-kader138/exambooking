<?php
	class Branch_model extends CI_Model{
		public function add_branch($data){
			$this->db->insert('ci_branches', $data);
			return true;
		}
		//---------------------------------------------------
		// get all branch for server-side datatable processing (ajax based)
		public function get_all_branches(){
			$wh =array();
			$SQL ='SELECT * FROM ci_branches';
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
		// get all branch records
		public function get_all_simple_branches(){
			$this->db->order_by('created_at', 'desc');
			$query = $this->db->get('ci_branches');
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Count total branch for pagination
		public function count_all_branches(){
			return $this->db->count_all('ci_branches');
		}

		//---------------------------------------------------
		// Get all branch for pagination
		public function get_all_branches_for_pagination($limit, $offset){
			$wh =array();	
			$this->db->order_by('created_at', 'desc');
			$this->db->limit($limit, $offset);

			if(count($wh)>0){
				$WHERE = implode(' and ',$wh);
				$query = $this->db->get_where('ci_branches', $WHERE);
			}
			else{
				$query = $this->db->get('ci_branches');
			}
			return $query->result_array();
			//echo $this->db->last_query();
		}


		//---------------------------------------------------
		// get all branch for server-side datatable with advanced search
		public function get_all_branches_by_advance_search(){
			$wh =array();
			$SQL ='SELECT * FROM ci_branches';
			if($this->session->userdata('branch_search_from')!='')
			$wh[]=" `created_at` >= '".date('Y-m-d', strtotime($this->session->userdata('branch_search_from')))."'";
			if($this->session->userdata('branch_search_to')!='')
			$wh[]=" `created_at` <= '".date('Y-m-d', strtotime($this->session->userdata('branch_search_to')))."'";
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
		// Get branch detial by ID
		public function get_branch_by_id($id){
			$query = $this->db->get_where('ci_branches', array('md5(id)' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit branch Record
		public function edit_branch($data, $id){
			$this->db->where('md5(id)', $id);
			$this->db->update('ci_branches', $data);
			return true;
		}

        // check branch association from users table by ID
        public function get_branch_from_users_by_id($id){
            $query = $this->db->get_where('ci_users', array('branch_id' => $id));
            return $result = $query->row_array();
        }

	}

?>