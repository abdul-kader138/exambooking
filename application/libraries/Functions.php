<?php

class Functions
{
    function __construct()
    {
        $this->dateFormats = array(
            'js_sdate' => 'dd-mm-yyyy',
            'js_bsdate' => 'dd/mm/yyyy',
            'php_sdate' => 'm-d-Y',
            'php_ndate' => 'yyyy-mm-dd',
            'mysq_sdate' => '%m-%d-%Y',
            'js_ldate' => 'mm-dd-yyyy hh:ii:ss',
            'php_ldate' => 'm-d-Y H:i:s',
            'mysql_ldate' => '%m-%d-%Y %T'
        );
        $this->obj =& get_instance();
    }


    //--------------------------------------------------------
    // Paginaiton function
    public function pagination_config($url, $count, $perpage)
    {
        $config = array();
        $config["base_url"] = $url;
        $config["total_rows"] = $count;
        $config["per_page"] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination pagination-split">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        return $config;
    }


    // --------------------------------------------------------------
    /*
    * Function Name : File Upload
    * Param1 : Location
    * Param2 : HTML File ControlName
    * Param3 : Extension
    * Param4 : Size Limit
    * Return : FileName
    */

    function file_insert($location, $controlname, $type, $size)
    {
        $return = array();
        $type = strtolower($type);
        if (isset($_FILES[$controlname]) && $_FILES[$controlname]['name'] != NULL) {
            $filename = $_FILES[$controlname]['name'];
            $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $filesize = $_FILES[$controlname]["size"];

            if ($type == 'image') {
                if ($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif') {
                    if ($filesize <= $size) {
                        $return['msg'] = $this->file_upload($location, $controlname);
                        $return['status'] = 1;
                    } else {
                        $size = $size / 1024;
                        $return['msg'] = 'File must be smaller then  ' . $size . ' KB';
                        $return['status'] = 0;
                    }
                } else {
                    $return['msg'] = 'File Must Be In jpg,jpeg,png,gif Format';
                    $return['status'] = 0;

                }
            } elseif ($type == 'pdf') {
                if ($file_extension == 'pdf') {
                    if ($filesize <= $size) {
                        $return['msg'] = $this->file_upload($location, $controlname);
                        $return['status'] = 1;
                    } else {
                        $size = $size / 1024;
                        $return['msg'] = 'File must be smaller then  ' . $size . ' KB';
                        $return['status'] = 0;
                    }
                } else {
                    $return['msg'] = 'File Must Be In PDF Format';
                    $return['status'] = 0;
                }
            } elseif ($type == 'excel') {
                if ($file_extension == 'xlsx' || $file_extension == 'xls') {
                    if ($filesize <= $size) {
                        $return['msg'] = $this->file_upload($location, $controlname);
                        $return['status'] = 1;

                    } else {
                        $size = $size / 1024;
                        $return['msg'] = 'File must be smaller then  ' . $size . ' KB';
                        $return['status'] = 0;
                    }
                } else {
                    $return['msg'] = 'File Must Be In Excel Format Only allow .xlsx and .xls extension';
                    $return['status'] = 0;
                }
            } elseif ($type == 'doc') {
                if ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'txt' || $file_extension == 'rtf') {
                    if ($filesize <= $size) {
                        $return['msg'] = $this->file_upload($location, $controlname);
                        $return['status'] = 1;
                    } else {
                        $size = $size / 1024;
                        $return['msg'] = 'File must be smaller then  ' . $size . ' KB';
                        $return['status'] = 0;
                    }
                } else {
                    $return['msg'] = 'File Must Be In doc,docx,txt,rtf Format';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'Not Allow other than image,pdf,excel,doc file..';
                $return['status'] = 0;
            }

        } else {
            $return['msg'] = '';
            $return['status'] = 1;
        }
        return $return;
    }


    /*
    * Function Name : File Delete
    * Param1 : Location
    * Param2 : OLD Image Name
    */

    public function delete_file($oldfile)
    {
        if ($oldfile) {
            if (file_exists(FCPATH . $oldfile)) {
                unlink(FCPATH . $oldfile);
            }
        }
    }


    //--------------------------------------------------------
    /*
    * Function Name : File Upload
    * Param1 : Location
    * Param2 : HTML File ControlName
    * Return : FileName
    */
    function file_upload($location, $controlname)
    {
        if (!file_exists(FCPATH . $location)) {
            $create = mkdir(FCPATH . $location, 0777, TRUE);
            if (!$create)
                return '';
        }

        $new_filename = $this->rename_image($_FILES[$controlname]['name']);
        if (move_uploaded_file(realpath($_FILES[$controlname]['tmp_name']), $location . $new_filename)) {
            return $new_filename;
        } else {
            return '';
        }
    }

    /*
    * Function Name : Rename Image
    * Param1 : FileName
    * Return : FileName
    */
    public function rename_image($img_name)
    {
        $randString = md5(time() . $img_name);
        $fileName = $img_name;
        $splitName = explode(".", $fileName);
        $fileExt = end($splitName);
        return strtolower($randString . '.' . $fileExt);
    }


    public function hrsd($sdate)
    {
        if ($sdate) {
            return date($this->dateFormats['php_sdate'], strtotime($sdate));
        } else {
            return '';
        }
    }

    function reformatDate($date)
    {
        $newDate = date("d-m-Y", strtotime($date));
        $origDate = str_replace('-', '/', $newDate);
        return $origDate;
    }

    public function hrld($ldate)
    {
        if ($ldate) {
            return date($this->dateFormats['php_ldate'], strtotime($ldate));
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function fsd($inv_date)
    {
        $t = $this->dateFormats;
        if ($inv_date) {
            $jsd = $this->dateFormats['js_bsdate'];
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2);
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2);
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00';
        }
    }

    public function fld($ldate)
    {
        if ($ldate) {
            $date = explode(' ', $ldate);
            $jsd = $this->dateFormats['js_sdate'];
            $inv_date = $date[0];
            $time = $date[1];
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2) . " " . $time;
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2) . " " . $time;
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00 00:00:00';
        }
    }
}


?>