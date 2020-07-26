<?php

class Exam_registration_model extends CI_Model
{

    public function add_exam($data, $voucher_code, $voucher_details)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->insert('ci_user_exam_details', $data);
        $last_id = $this->db->insert_id();
        if ($voucher_code && $voucher_details) {
            $this->db->where('LOWER(ci_voucher.code)', strtolower(trim($voucher_code)));
            $this->db->update('ci_voucher', array('ci_voucher.status' => 'Used', 'ci_voucher.exam_id' => $last_id));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return false;
        return true;
    }

    //---------------------------------------------------
    public function update_exam($data, $id,$exam_id, $voucher_code_old, $voucher_code_new, $voucher_details_old, $voucher_details_new)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->where('md5(id)', $id);
        $this->db->update('ci_user_exam_details', $data);
        if ($voucher_code_old && $voucher_details_old) {
            $this->db->where('LOWER(ci_voucher.code)', strtolower(trim($voucher_code_old)));
            $this->db->update('ci_voucher', array('ci_voucher.status' => 'New', 'ci_voucher.exam_id' => ''));
        }
        if ($voucher_code_new && $voucher_details_new) {
            $this->db->where('LOWER(ci_voucher.code)', strtolower(trim($voucher_code_new)));
            $this->db->update('ci_voucher', array('ci_voucher.status' => 'Used', 'ci_voucher.exam_id' => $exam_id));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return false;
        return true;
    }

    //---------------------------------------------------
    public function delete_exam($id, $voucher_code, $voucher_details)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->delete('ci_user_exam_details', array('md5(id)' => $id));
        if ($voucher_code && $voucher_details) {
            $this->db->where('LOWER(ci_voucher.code)', strtolower(trim($voucher_code)));
            $this->db->update('ci_voucher', array('ci_voucher.status' => 'New', 'ci_voucher.exam_id' => ''));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return false;
        return true;
    }

    //---------------------------------------------------
    // get all user exam for server-side datatable processing (ajax based)
    public function get_all_user_exam_details()
    {
        $wh = array();
        $SQL = 'SELECT ci_user_exam_details.id,ci_user_exam_details.submitted,ci_user_exam_details.first_name,ci_user_exam_details.last_name,
               ci_time_venue.time_venue, ci_exam_type.name type_name,ci_user_exam_details.created_date,ci_exam_type_types.name type_type,ci_user_exam_details.venue_details,
               ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,ci_user_exam_details.exam_suite,
               ci_user_exam_details.fees,ci_user_exam_details.school_name,ci_user_exam_details.ic_no FROM ci_user_exam_details 
               inner join ci_time_venue on ci_user_exam_details.time_venue=ci_time_venue.id inner join ci_exam_type on 
               ci_user_exam_details.exam_type=ci_exam_type.id inner join ci_exam_type_types on 
               ci_user_exam_details.exam_type=ci_exam_type_types.exam_type_id and ci_user_exam_details.type=ci_exam_type_types.id inner join 
               ci_exam_instrument_product on ci_user_exam_details.instrument=ci_exam_instrument_product.id inner join ci_exam_grade_diploma 
               on ci_user_exam_details.grade=ci_exam_grade_diploma.id';
        if ($this->session->userdata('user_id') != '')
            $wh[] = "ci_user_exam_details.submitted='No' and ci_user_exam_details.created_by = '" . $this->session->userdata('user_id') . "'";

        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }

    //---------------------------------------------------
    // Get Exam Types
    public function get_exam_types()
    {
        $query = $this->db->get('ci_exam_type');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //---------------------------------------------------
    // Get Exam Types by id
    public function get_exam_type_by_id($id = null)
    {
        $query = $this->db->get_where('ci_exam_type', array('id' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    // Get Exam Type Types
    public function get_exam_type_types_by_id($id = null)
    {
        $query = $this->db->get_where('ci_exam_type_types', array('exam_type_id' => $id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //---------------------------------------------------
    // Get Time &  Venue
    public function get_time_venue($exam_type_id)
    {
        $this->db->where('exam_type_id', $exam_type_id);
        $query = $this->db->get('ci_time_venue');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    //---------------------------------------------------
    // Get Exam Type Types Details
    public function get_instrument_by_exam_id($exam_type_id = null, $exam_type_types_id = null)
    {
        $query = $this->db->get_where('ci_exam_instrument_product', array('exam_type_id' => $exam_type_id, 'type_types_id' => $exam_type_types_id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    //---------------------------------------------------
    // Get Exam Type grade Details
    public function get_grade_by_exam_id($exam_type_types_id = null, $instruments_id = null)
    {
        $this->db->select('ci_exam_grade_diploma.id,ci_exam_grade_diploma.grade_name')
            ->join('ci_exam_suite_fees', 'ci_exam_grade_diploma.id=ci_exam_suite_fees.grade_id', 'left');
        $this->db->where('ci_exam_suite_fees.fees !=', '');
        $this->db->where('ci_exam_suite_fees.instrument_id', $instruments_id);
        $query = $this->db->get_where('ci_exam_grade_diploma', array('type_types_id' => $exam_type_types_id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //---------------------------------------------------
    public function get_user_exam_details_by_id($id)
    {
        $this->db->select('ci_user_exam_details.id,ci_user_exam_details.submitted,ci_user_exam_details.discount,ci_user_exam_details.dob,ci_user_exam_details.gender,
        ci_user_exam_details.group_name,ci_user_exam_details.first_name,ci_user_exam_details.last_name,ci_user_exam_details.venue_details,
		ci_time_venue.time_venue,ci_time_venue.id venue_id,ci_exam_type.id exam_type_id,ci_exam_type.name type_name,
		ci_exam_type_types.id type_types_id,ci_exam_type_types.name type_type,ci_exam_instrument_product.id instrument_id,
		ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,ci_exam_grade_diploma.id grade_id,
		ci_user_exam_details.exam_suite,ci_user_exam_details.voucher_code,ci_user_exam_details.fees,
		ci_user_exam_details.school_name,ci_user_exam_details.ic_no')
            ->join('ci_time_venue', 'ci_user_exam_details.time_venue=ci_time_venue.id', 'inner')
            ->join('ci_exam_type', 'ci_user_exam_details.exam_type=ci_exam_type.id', 'inner')
            ->join('ci_exam_type_types', 'ci_user_exam_details.type=ci_exam_type_types.id', 'inner')
            ->join('ci_exam_instrument_product', 'ci_user_exam_details.instrument=ci_exam_instrument_product.id', 'inner')
            ->join('ci_exam_grade_diploma', 'ci_user_exam_details.grade=ci_exam_grade_diploma.id', 'inner');
        $query = $this->db->get_where('ci_user_exam_details', array('md5(ci_user_exam_details.id)' => $id, 'ci_user_exam_details.created_by' => $this->session->userdata('user_id')));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;

    }

    //---------------------------------------------------
    public function get_user_all_exam_details()
    {
        $this->db->select('ci_user_exam_details.id,ci_user_exam_details.dob,ci_user_exam_details.gender,
        ci_user_exam_details.group_name,ci_user_exam_details.first_name,ci_user_exam_details.last_name,ci_user_exam_details.venue_details,
		ci_time_venue.time_venue,ci_time_venue.id venue_id,ci_exam_type.id exam_type_id,ci_exam_type.name type_name,
		ci_exam_type_types.id type_types_id,ci_exam_type_types.name type_type,ci_exam_instrument_product.id instrument_id,
		ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,ci_exam_grade_diploma.id grade_id,
		ci_user_exam_details.exam_suite,ci_user_exam_details.voucher_code,ci_user_exam_details.fees,
		ci_user_exam_details.school_name,ci_user_exam_details.ic_no')
            ->join('ci_time_venue', 'ci_user_exam_details.time_venue=ci_time_venue.id', 'inner')
            ->join('ci_exam_type', 'ci_user_exam_details.exam_type=ci_exam_type.id', 'inner')
            ->join('ci_exam_type_types', 'ci_user_exam_details.type=ci_exam_type_types.id', 'inner')
            ->join('ci_exam_instrument_product', 'ci_user_exam_details.instrument=ci_exam_instrument_product.id', 'inner')
            ->join('ci_exam_grade_diploma', 'ci_user_exam_details.grade=ci_exam_grade_diploma.id', 'inner');

        $query = $this->db->get_where('ci_user_exam_details', array('ci_user_exam_details.created_by' => $this->session->userdata('user_id'), 'ci_user_exam_details.submitted' => 'No'));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
    //---------------------------------------------------
    // Get Exam Type types by exam type id
    public function get_types_by_exam_type_id($exam_type_id = null)
    {
        $query = $this->db->get_where('ci_exam_type_types', array('exam_type_id' => $exam_type_id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_suite_by_exam_id($grade_id = null, $instrument_id = null)
    {
        $this->db->select('ci_exam_suite_fees.fees,ci_exam_suite.name as suite_name')
            ->join('ci_exam_suite', 'ci_exam_suite_fees.suite_name=ci_exam_suite.id', 'inner');
        $query = $this->db->get_where('ci_exam_suite_fees', array('grade_id' => $grade_id, 'instrument_id' => $instrument_id), 1);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_user_detail()
    {
        $id = $this->session->userdata('user_id');
        $query = $this->db->get_where('ci_users', array('id' => $id));
        return $result = $query->row_array();
    }

    public function add_exam_submission($data)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        foreach ($data as $obj) {
            $this->db->where('id', $obj['exam_id']);
            $this->db->update('ci_user_exam_details', array('submitted' => 'Yes'));
            $this->db->insert('ci_exam_submission_details', $obj);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return false;
        return true;
    }

    //---------------------------------------------------
    public function get_user_all_exam_list()
    {
        $this->db->select('*');
        $query = $this->db->get_where('ci_user_exam_details', array('ci_user_exam_details.created_by' => $this->session->userdata('user_id'), 'ci_user_exam_details.submitted' => 'No'));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    //---------------------------------------------------
    // Get Exam Type grade Details
    public function get_submission_summary($ref_id = null)
    {
        $this->db->select('sum(ci_exam_submission_details.fees) as total_fees,ci_exam_submission_details.ref_no,ci_exam_submission_details.created_date');
        $this->db->where('ci_exam_submission_details.ref_no', $ref_id);
        $this->db->group_by('ci_exam_submission_details.ref_no');
        $query = $this->db->get('ci_exam_submission_details');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }


    // get all user exam for server-side datatable processing (ajax based)
    public function get_all_exam_submission_details()
    {
        $wh = array();
        $SQL = 'SELECT sum(fees) as fees, ref_no,created_date,count(id) as id
                FROM ci_exam_submission_details';
        if ($this->session->userdata('user_id') != '')
            $wh[] = "ci_exam_submission_details.created_by = '" . $this->session->userdata('user_id') . "'";

        $group_by = ' group by ref_no';
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE, $group_by);
        } else {
            return $this->datatable->LoadJson($SQL, $group_by);
        }
    }

    public function get_exam_submission_id($ref_id = null)
    {
        $query = $this->db->get_where('ci_exam_submission_details', array('md5(ref_no)' => $ref_id, 'ci_exam_submission_details.created_by' => $this->session->userdata('user_id')));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    //---------------------------------------------------

    public function get_branch_admin($branch_id)
    {
        $this->db->where('branch_id', $branch_id);
        $this->db->where('admin_type', 3);
        $query = $this->db->get('ci_users');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //---------------------------------------------------

    public function get_super_admin()
    {
        $this->db->where('admin_type', 2);
        $query = $this->db->get('ci_users');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    //---------------------------------------------------
    // Get Time &  Venue
    public function get_time_venue_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ci_time_venue');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_voucher_by_code($id)
    {
        $query = $this->db->get_where('ci_voucher', array('code' => $id, 'status' => 'Used'));
        return $result = $query->row_array();
    }

    public function get_unused_voucher_by_code($id)
    {
        $query = $this->db->get_where('ci_voucher', array('LOWER(code)' => strtolower(trim($id)), 'status' => 'New'));
        return $result = $query->row_array();
    }

    public function get_user_exam_details_for_submission_by_id($id)
    {
        $this->db->select('ci_user_exam_details.id,ci_user_exam_details.submitted,ci_user_exam_details.dob,ci_user_exam_details.gender,
        ci_user_exam_details.group_name,ci_user_exam_details.first_name,ci_user_exam_details.last_name,ci_user_exam_details.venue_details,
		ci_time_venue.time_venue,ci_time_venue.id venue_id,ci_exam_type.id exam_type_id,ci_exam_type.name type_name,
		ci_exam_type_types.id type_types_id,ci_exam_type_types.name type_type,ci_exam_instrument_product.id instrument_id,
		ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,ci_exam_grade_diploma.id grade_id,
		ci_user_exam_details.exam_suite,ci_user_exam_details.voucher_code,ci_user_exam_details.fees,
		ci_user_exam_details.school_name,ci_user_exam_details.ic_no')
            ->join('ci_time_venue', 'ci_user_exam_details.time_venue=ci_time_venue.id', 'inner')
            ->join('ci_exam_type', 'ci_user_exam_details.exam_type=ci_exam_type.id', 'inner')
            ->join('ci_exam_type_types', 'ci_user_exam_details.type=ci_exam_type_types.id', 'inner')
            ->join('ci_exam_instrument_product', 'ci_user_exam_details.instrument=ci_exam_instrument_product.id', 'inner')
            ->join('ci_exam_grade_diploma', 'ci_user_exam_details.grade=ci_exam_grade_diploma.id', 'inner');
        $query = $this->db->get_where('ci_user_exam_details', array('ci_user_exam_details.id' => $id, 'ci_user_exam_details.created_by' => $this->session->userdata('user_id')));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;

    }

    public function get_unused_voucher_by_exam_id($id, $code)
    {
        $sql = "select * from (SELECT code,fee FROM ci_voucher where 
              exam_id ='' or exam_id =" . $id . ") as a where LOWER(a.code)='" . strtolower(trim($code)) . "'";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function get_voucher_details($id)
    {
        $query = $this->db->get_where('ci_voucher', array('LOWER(code)' => strtolower(trim($id))));
        return $result = $query->row_array();
    }

}

?>