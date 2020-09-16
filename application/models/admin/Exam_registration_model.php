<?php

class Exam_registration_model extends CI_Model
{

    //---------------------------------------------------

    public function update_voucher_info($submission_id, $status, $new_code)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->where('id', $submission_id);
        $this->db->update('ci_exam_submission_details', array('exam_status' => $status, 'voucher_code' => trim($new_code)));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return false;
        return true;
    }


    public function update_exam_info($submission_id, $exam, $exam_dates)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->where('id', $submission_id);
        $this->db->update('ci_exam_submission_details', array('exam_no' => $exam, 'exam_date' => $exam_dates));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return array('update_status' => 'No');
        return array('update_status' => 'Yes');
    }

    //---------------------------------------------------
    public function get_all_user_exam_details()
    {
        $wh = array();
        $SQL = 'SELECT ci_user_exam_details.id,ci_user_exam_details.created_date,ci_user_exam_details.submitted,ci_user_exam_details.first_name,ci_user_exam_details.last_name,
               ci_time_venue.time_venue, ci_exam_type.name type_name,ci_exam_type_types.name type_type,ci_user_exam_details.venue_details,
               ci_exam_instrument_product.instrument_name,ci_exam_grade_diploma.grade_name,ci_user_exam_details.exam_suite,
               ci_user_exam_details.fees,ci_user_exam_details.school_name,ci_user_exam_details.ic_no,ci_user_exam_details.dob,ci_user_exam_details.gender FROM ci_user_exam_details 
               inner join ci_time_venue on ci_user_exam_details.time_venue=ci_time_venue.id inner join ci_exam_type on 
               ci_user_exam_details.exam_type=ci_exam_type.id inner join ci_exam_type_types on 
               ci_user_exam_details.exam_type=ci_exam_type_types.exam_type_id and ci_user_exam_details.type=ci_exam_type_types.id inner join 
               ci_exam_instrument_product on ci_user_exam_details.instrument=ci_exam_instrument_product.id inner join ci_exam_grade_diploma 
               on ci_user_exam_details.grade=ci_exam_grade_diploma.id inner join ci_users on ci_user_exam_details.created_by=ci_users.id';
        if ($this->session->userdata('admin_type') == '2')
            $wh[] = "ci_user_exam_details.submitted='Yes'";
        if ($this->session->userdata('admin_type') == '3')
            $wh[] = "ci_user_exam_details.submitted='Yes' and ci_users.branch_id = '" . $this->session->userdata('branch_id') . "'";
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }

    //---------------------------------------------------
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
    public function get_exam_type_by_id($id = null)
    {
        $query = $this->db->get_where('ci_exam_type', array('id' => $id));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
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
            ->join('ci_exam_grade_diploma', 'ci_user_exam_details.grade=ci_exam_grade_diploma.id', 'inner')
            ->join('ci_users', 'ci_user_exam_details.created_by=ci_users.id', 'inner');
        if ($this->session->userdata('admin_type') == '3')
            $this->db->where('ci_users.branch_id', $this->session->userdata('branch_id'));
        $query = $this->db->get_where('ci_user_exam_details', array('md5(ci_user_exam_details.id)' => $id));
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
            ->join('ci_exam_grade_diploma', 'ci_user_exam_details.grade=ci_exam_grade_diploma.id', 'inner')
            ->join('ci_users', 'ci_user_exam_details.created_by=ci_users.id', 'inner');
        if ($this->session->userdata('admin_type') == '3')
            $this->db->where('ci_users.branch_id', $this->session->userdata('branch_id'));
//        $query = $this->db->get_where('ci_user_exam_details', array('ci_user_exam_details.created_by' => $this->session->userdata('user_id'), 'ci_user_exam_details.submitted' => 'No'));
        $query = $this->db->get_where('ci_user_exam_details', array('ci_user_exam_details.submitted' => 'Yes'));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    //---------------------------------------------------
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


    //---------------------------------------------------
    public function get_user_all_exam_list()
    {
        if ($this->session->userdata('admin_type') == '3') $this->db->where('ci_users.branch_id', $this->session->userdata('branch_id'));
        $this->db->where('ci_user_exam_details.submitted', 'Yes');
        $this->db->select('ci_user_exam_details.*')
            ->join('ci_users', 'ci_user_exam_details.created_by=ci_users.id', 'inner');
        $query = $this->db->get('ci_user_exam_details');
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    //---------------------------------------------------
    public function get_submission_summary($ref_id = null)
    {
        $this->db->select('sum(ci_exam_submission_details.fees) as total_fees,ci_exam_submission_details.ref_no,ci_exam_submission_details.created_date,ci_exam_submission_details.penalty_fee');
        $this->db->where('ci_exam_submission_details.ref_no', $ref_id);
        $this->db->group_by('ci_exam_submission_details.ref_no');
        $query = $this->db->get('ci_exam_submission_details');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_all_exam_submission_details()
    {
        $wh = array();
        $SQL = 'SELECT concat(ci_users.firstname," ",ci_users.lastname) as firstname,sum(ci_exam_submission_details.fees) as fees, ci_exam_submission_details.penalty_fee, ci_exam_submission_details.ref_no,ci_exam_submission_details.created_date,count(ci_exam_submission_details.id) as id
                  FROM ci_exam_submission_details inner join ci_users on ci_exam_submission_details.created_by=ci_users.id';
        if ($this->session->userdata('admin_type') == '3')
            $wh[] = "ci_users.branch_id = '" . $this->session->userdata('branch_id') . "'";
        else $wh[] = '';
        $group_by = ' group by ci_exam_submission_details.ref_no';
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE, $group_by);
        } else {
            return $this->datatable->LoadJson($SQL, $group_by);
        }
    }


    //---------------------------------------------------
    public function get_exam_submission_id($ref_id = null)
    {
        $this->db->select('ci_exam_submission_details.*,ci_users.firstname,ci_users.lastname')
            ->join('ci_users', 'ci_exam_submission_details.created_by=ci_users.id', 'inner');
        $query = $this->db->get_where('ci_exam_submission_details', array('md5(ref_no)' => $ref_id));
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

    public function get_single_submission_by_id($id = null)
    {
        $this->db->select('ci_exam_submission_details.*,ci_users.firstname,ci_users.lastname')
            ->join('ci_users', 'ci_exam_submission_details.created_by=ci_users.id', 'inner');
        $query = $this->db->get_where('ci_exam_submission_details', array('md5(ci_exam_submission_details.id)' => $id));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_single_submission_by_exam_id($id = null)
    {
        $this->db->select('ci_exam_submission_details.*,ci_users.firstname,ci_users.lastname')
            ->join('ci_users', 'ci_exam_submission_details.created_by=ci_users.id', 'inner');
        $query = $this->db->get_where('ci_exam_submission_details', array('md5(ci_exam_submission_details.exam_id)' => $id));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_exam_submission_details_by_id($id)
    {
        $query = $this->db->get_where('ci_exam_submission_details', array('id' => $id));
        return $result = $query->row_array();
    }

    public function get_exam_details_by_id($id)
    {
        $query = $this->db->get_where('ci_user_exam_details', array('id' => $id));
        return $result = $query->row_array();
    }

    public function get_voucher_by_code($code)
    {
        $query = $this->db->get_where('ci_voucher', array('LOWER(code)' => strtolower(trim($code))));
        return $result = $query->row_array();
    }


    public function get_suite_from_exam_by_code($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ci_time_venue');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_unused_voucher_by_code($id)
    {
        $query = $this->db->get_where('ci_voucher', array('LOWER(code)' => strtolower(trim($id)), 'status' => 'New'));
        return $result = $query->row_array();
    }

    public function get_exam_submission_by_id($id = null)
    {
        $query = $this->db->get_where('ci_exam_submission_details', array('id' => $id));
        return $result = $query->row_array();
    }

    public function get_voucher_details($id)
    {
        $query = $this->db->get_where('ci_voucher', array('LOWER(code)' => strtolower(trim($id))));
        return $result = $query->row_array();
    }

    //---------------------------------------------------
    public function delete_submission($id, $data)
    {
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        foreach ($data as $record) {
            $exam_details = $this->get_exam_details($record->exam_id);
            if ($exam_details && $exam_details['voucher_code']) {
                $this->db->where('LOWER(ci_voucher.code)', strtolower(trim($exam_details['voucher_code'])));
                $this->db->update('ci_voucher', array('ci_voucher.status' => 'New', 'ci_voucher.exam_id' => ''));
            }
            $this->db->delete('ci_user_exam_details', array('id' => $record->exam_id));
        }
        $this->db->delete('ci_exam_submission_details', array('md5(id)' => $id));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return false;
        return true;
    }


    //---------------------------------------------------
    public function get_exam_details($id)
    {
        $query = $this->db->get_where('ci_user_exam_details', array('id' => $id));
        return $result = $query->row_array();
    }


    public function get_submission_details_by_param($from, $to, $exam_type, $type)
    {
        $type_query= '';
        $exam_type_query='';
        if (!isset($from)) $from = '1999-01-01';
        if (!isset($to)) $to = '1999-01-02';
        if(!empty($type_query)) $type_query = " and ci_exam_submission_details.type_types ='" . $type . "'";
        if(!empty($exam_type_query)) $exam_type_query = " and ci_exam_submission_details.exam_types ='" . $exam_type . "'";
        $wh = array();
        $SQL = 'SELECT ci_exam_submission_details.id,ci_exam_submission_details.ref_no,ci_exam_submission_details.first_name,ci_exam_submission_details.last_name,
		ci_user_exam_details.dob,ci_user_exam_details.gender,ci_exam_submission_details.exam_suite,
		ci_exam_submission_details.instrument,ci_exam_submission_details.grade 
		FROM ci_exam_submission_details INNER join 
		ci_user_exam_details on ci_exam_submission_details.exam_id=ci_user_exam_details.id 
		inner join ci_users on ci_exam_submission_details.created_by=ci_users.id';
        if ($this->session->userdata('admin_type') == '3')
            $wh[] = "ci_users.branch_id = '" . $this->session->userdata('branch_id') . "' and "
                . " ci_exam_submission_details.created_date between '" . $from." 00:00" . "'"
                . " and '" . $to." 23:59" . "'"
                . $type_query
                . $exam_type_query;
        else $wh[] = "ci_exam_submission_details.created_date between '" . $from." 00:00" . "'"
            . " and '" .  $to." 23:59"  . "'"
            . $type_query
            . $exam_type_query;
        $group_by = '';
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE, $group_by);
        } else {
            return $this->datatable->LoadJson($SQL, $group_by);
        }
    }

    public function get_submission_details_by_id($id)
    {
        $this->db->select('ci_exam_submission_details.id,ci_exam_submission_details.ref_no,ci_exam_submission_details.first_name,
        ci_exam_submission_details.last_name,ci_exam_submission_details.grade,ci_exam_submission_details.instrument,
        ci_exam_submission_details.exam_suite,ci_user_exam_details.dob,ci_user_exam_details.gender')
            ->join('ci_user_exam_details', 'ci_exam_submission_details.exam_id=ci_user_exam_details.id', 'inner');
        $query = $this->db->get_where('ci_exam_submission_details', array('ci_exam_submission_details.id' => $id));
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function get_voucher_from_exam_by_code($code)
    {
        $query = $this->db->get_where('ci_voucher', array('LOWER(code)' => strtolower(trim($code)), 'status' => 'New'));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_submission_details($id, $ref_no)
    {
        $query = $this->db->get_where('ci_exam_submission_details', array('ref_no' => $ref_no, 'id' => $id));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function update_candidate_submission($submission_details, $exam_id)
    {
        if ($submission_details) {
            $this->db->trans_strict(TRUE);
            $this->db->trans_start();
            foreach ($submission_details as $record) {
                if ($record['id'] && $record['ref_no']) {
                    $this->db->where(array('id' => $record['id'], 'ref_no' => $record['ref_no']));
                    $this->db->update('ci_exam_submission_details', array('exam_no' => $record['exam_no'], 'exam_date' => $record['exam_date'], 'exam_status' => $record['status'], 'voucher_code' => $record['voucher_code']));
//                    $voucher_details = $this->get_voucher_from_exam_by_code($record['voucher_code']);
//                    $this->db->where(array('id' => $voucher_details->id));
//                    $this->db->update('ci_voucher', array('ci_voucher.status' => 'Used', 'ci_voucher.exam_id' => $exam_id));
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) return false;
            return true;
        }
        return false;
//        return true;
    }

    public function update_voucher($voucher_details)
    {
        if ($voucher_details) {
            $this->db->trans_strict(TRUE);
            $this->db->trans_start();
            $this->db->insert_batch('ci_voucher', $voucher_details);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) return false;
            return true;
        }
        return false;
    }

    public function get_voucher_by_csv_code($code)
    {
        $query = $this->db->get_where('ci_voucher', array('LOWER(code)' => strtolower(trim($code))));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

}

?>