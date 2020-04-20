﻿<link href="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
      rel="stylesheet"/>
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>

<style>
    .btn {
        font-size: 14px !important;
    }

    .hide_content {
        display: none;
    }
</style>
<div class="container-fluid">
    <?php echo form_open(base_url('user/exam_registration/edit_exam'), 'class="form-horizontal"'); ?>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Add New Exam</h2>
                    <a href="<?= base_url('user/exam_registration/'); ?>"
                       class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> Registered
                        Exam List</a>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <label for="exam_type">Type Of Exam</label>
                            <div class="form-group">
                                <?php
                                $exam_type_list[''] = '-- Please select Exam Type--';
                                foreach ($exam_types as $exam_type) {
                                    $exam_type_list[$exam_type->id] = $exam_type->name;
                                }
                                echo form_dropdown('exam_type', $exam_type_list, $records->exam_type_id, 'id="exam_type" class="form-control show-tick"  required="required"" ');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <div class="form-line">
                                    <?php echo form_input('first_name', $records->first_name, 'class="form-control input-tip" 
                                    placeholder="Please enter first name" required="required" id="first_name" pattern="[a-z A-Z]+"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <div class="form-line">
                                    <div class="form-line">
                                        <?php echo form_input('last_name', $records->last_name, 'class="form-control input-tip" 
                                    placeholder="Please enter last name" required="required" id="last_name" pattern="[a-z A-Z]+"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dob">Date Of Birth</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo form_input('dob', $records->dob, 'class="form-control input-tip" 
                                      placeholder="Ex: 30/07/1998" required="required" id="dob"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="gender">Gender</label>
                            <div class="form-line">
                                <?php $sst = array('Male' => 'Male', 'Female' => 'Female');
                                echo form_dropdown('gender', $sst, $records->gender, 'class="form-control show-tick" required="required" id="gender"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ic_no">IC No.</label>
                                <div class="form-line">
                                    <?php echo form_input('ic_no', $records->ic_no, 'class="form-control input-tip" 
                                    placeholder="Please enter ic no" required="required" id="ic_no"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="school_name">School Name</label>
                                <div class="form-line">
                                    <?php echo form_input('school_name', $records->school_name, 'class="form-control input-tip" 
                                    placeholder="Please enter school name" required="required" id="school_name"'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <div class="form-line">
                                    <?php
                                    $exam_types_list[''] = '-- Please select Type--';
                                    foreach ($exam_type_types as $exam_type_type) {
                                        $exam_types_list[$exam_type_type->id] = $exam_type_type->name;
                                    }
                                    echo form_dropdown('type', $exam_types_list, $records->type_types_id, 'id="type" class="form-control show-tick select"  required="required"" ');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type">Time & Venue</label>
                                <div class="form-line">
                                    <div class="form-line">
                                        <?php
                                        $time_venue_list[''] = '-- Please select Time & Venue--';
                                        foreach ($time_venues as $time_venue_obj) {
                                            $time_venue_list[$time_venue_obj->id] = $time_venue_obj->time_venue;
                                        }
                                        echo form_dropdown('time_venue', $time_venue_list, $records->venue_id, 'id="time_venue" class="form-control show-tick select"  required="required" ');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php if ($records->exam_type_id == 2) { ?>
                                    <label for="group_name">Group name</label>
                                    <div class="form-line">
                                        <?php echo form_input('group_name', $records->group_name, 'class="form-control input-tip" 
                                       placeholder="please enter group name"  id="group_name"'); ?>
                                    </div>
                                    <br>
                                <?php } ?>
                                <label for="type" id="d_type">Instrument/Product/Categories</label>
                                <div class="form-line">
                                    <?php
                                    $instrument_list[''] = '-- Please select required Data--';
                                    foreach ($instrument_lists as $instrument) {
                                        $instrument_list[$instrument->id] = $instrument->instrument_name;
                                    }
                                    echo form_dropdown('instrument', $instrument_list, $records->instrument_id, 'id="instrument" class="form-control show-tick select"  required="required" ');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type" id="d_grade">Grade/Diploma</label>
                                <div class="form-line">
                                    <?php
                                    $grade_list[''] = '-- Please select Grade--';
                                    foreach ($grade_lists as $grade) {
                                        $grade_list[$grade->id] = $grade->grade_name;
                                    }
                                    echo form_dropdown('grade', $grade_list, $records->grade_id, 'id="grade" class="form-control show-tick select"  required="required" ');
                                    ?>
                                </div>
                                <br>
                                <label for="last_name">Exam Suite</label>
                                <div class="form-line">
                                    <?php echo form_input('exam_suite', $records->exam_suite, 'class="form-control readonly input-tip" 
                                         id="exam_suite"'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fees">Fees</label>
                                <div class="form-line">
                                    <?php echo form_input('fees', $records->fees, 'class="form-control readonly input-tip" 
                                         id="fees"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="voucher_code">Voucher Code</label>
                                <div class="form-line">
                                    <?php echo form_input('voucher_code', $records->voucher_code, 'class="form-control  input-tip" 
                                         id="voucher_code"'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="template"></div>
                    <button id="submit_info" class="btn btn-primary waves-effect hide_content" type="submit">ADD
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="container-fluid">

    <script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
    <script src="<?= base_url() ?>public/plugins/momentjs/moment.js"></script>
    <script src="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?= base_url() ?>public/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#dob').inputmask({mask: "99-99-9999"});
            // $('.common').hide();
            $('#exam_type').change(function () {
                $('.common').hide();
                var exam_types = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('user/exam_registration/get_exam_details'); ?>",
                    data: {exam_type: exam_types},
                    dataType: "json",//return type expected as json
                    success: function (states) {
                        $('.common').show();

                        // refreh all option
                        $('#template').empty();
                        $('#template').append(states.html);
                        $("#time_venue").selectpicker('refresh');
                        $("#type").selectpicker('refresh');
                        $("#instrument").selectpicker('refresh');
                        $("#grade").selectpicker('refresh');
                        $("#exam_suite").selectpicker('refresh');
                        $("#submit_info").show();
                    },
                });
            });

        });

    </script>