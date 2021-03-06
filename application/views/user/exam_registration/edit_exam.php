﻿﻿
<link href="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
      rel="stylesheet"/>
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<link href="<?= base_url() ?>public/plugins/toastr/toastr.min.css" rel="stylesheet"/>
<style>
    [type=checkbox]:not(:checked) {
        left: inherit;
        margin-top: 8px;
    }
    .hide_content {
        display: none;
    }
</style>
<?php
if ($records->type_types_id == '1') {
    $d_type = 'Instrument';
    $g_type = 'Grade';

} elseif ($records->type_types_id == '2') {
    $d_type = 'Instrument';
    $g_type = 'Diploma';

} elseif ($records->type_types_id == '3') {
    $d_type = 'Product';
    $g_type = 'Grade';
} elseif ($records->type_types_id == '4') {
    $d_type = 'Instrument';
    $g_type = 'Grade';
} elseif ($records->type_types_id == '5') {
    $d_type = 'Categories';
    $g_type = 'Grade';
} elseif ($records->type_types_id == '6') {
    $d_type = 'Categories';
    $g_type = 'Grade';
} elseif ($records->type_types_id == '7') {
    $d_type = 'Categories';
    $g_type = 'Grade';
} else {
    $d_type = 'Instrument';
    $g_type = 'Grade';
}
?>
<div class="container-fluid">
    <?php echo form_open(base_url('user/exam_registration/edit_exam/' . md5($records->id)), 'class="form-horizontal"'); ?>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Edit Exam</h2>
                    <a href="<?= base_url('user/exam_registration/'); ?>"
                       class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> Candidates</a>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <label for="exam_type">Type Of Exam</label>
                            <div class="form-group">
                                <?php
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
                                <label for="first_name">First Name (eg. Abdullah, Carol Lim)</label>
                                <div class="form-line">
                                    <?php echo form_input('first_name', $records->first_name, 'class="form-control input-tip" 
                                    placeholder="Please enter first name" required="required" id="first_name" pattern="^[a-zA-Z][a-z A-Z0]{1,15}$"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">Second Name (eg. Bin Musa, Shi Ting)</label>
                                <div class="form-line">
                                    <div class="form-line">
                                        <?php echo form_input('last_name', $records->last_name, 'class="form-control input-tip" 
                                    placeholder="Please enter second name" required="required" id="last_name" pattern="^[a-zA-Z][a-z A-Z0]{1,15}$"'); ?>
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
                                    </span>
                                    <div class="form-line">
                                        <input type="date" class="datepicker form-control" required id="dob" name="dob"
                                               data-value="2015-08-01" placeholder="Please Choose DOB"
                                               value="<?= $records->dob; ?>"/>

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
                                <label for="school_name">School Name (only for school name to print on
                                    certificate) </label>
                                <div class="form-line">
                                    <?php echo form_input('school_name', $records->school_name, 'class="form-control input-tip" 
                                    placeholder="Please enter school name" id="school_name"'); ?>

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
                                <label for="type">Date & Venue</label>
                                <div class="form-line">
                                    <div class="form-line">
                                        <?php
                                        $time_venue_list[''] = '-- Please select Date & Venue--';
                                        foreach ($time_venues as $time_venue_obj) {
                                            $time_venue_list[$time_venue_obj->id] = $time_venue_obj->time_venue;
                                        }
                                        echo form_dropdown('time_venue', $time_venue_list, $records->venue_id, 'id="time_venue" class="form-control show-tick select"  required="required" ');
                                        ?>
                                    </div>
                                    <div class="form-line" id="time_venue_other_div">
                                        <?php echo form_input('time_venue_other', $records->venue_details, 'class="form-control input-tip" 
                                    placeholder="Please Enter Other Date & Venue" id="time_venue_other"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" id="group_name_show">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <!--                                --><?php //if ($records->exam_type_id == 2) { ?>
                                <label for="group_name">Group name</label>
                                <div class="form-line">
                                    <?php echo form_input('group_name', $records->group_name, 'class="form-control input-tip" 
                                       placeholder="please enter group name"  id="group_name"'); ?>
                                </div>
                                <br>
                                <!--                                --><?php //} ?>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type" id="d_type"><?= $d_type ?></label>
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
                                <label for="type" id="g_type"><?= $g_type ?></label>
                                <div class="form-line">
                                    <?php
                                    $grade_list[''] = '-- Please select Grade--';
                                    foreach ($grade_lists as $grade) {
                                        $grade_list[$grade->id] = $grade->grade_name;
                                    }
                                    echo form_dropdown('grade', $grade_list, $records->grade_id, 'id="grade" class="form-control show-tick select"  required="required" ');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">Exam Suite</label>
                                <div class="form-line">
                                    <?php
                                    $att = array('name' => 'exam_suite', 'type' => 'text', 'readonly' => 'readonly');
                                    echo form_input($att, $records->exam_suite, 'class="form-control readonly input-tip" 
                                         id="exam_suite"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fees">Fees</label>
                                <div class="form-line">
                                    <?php
                                    $att = array('name' => 'fees', 'type' => 'text', 'readonly' => 'readonly');
                                    echo form_input($att, $records->fees, 'class="form-control input-tip" 
                                         id="fees"'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="voucher_code">Voucher Code</label>
                                <div class="form-line">
                                    <?php echo form_input('voucher_code', $records->voucher_code, 'class="form-control  input-tip" 
                                         id="voucher_code"'); ?>
                                </div>
                                <br>
                                <input type="checkbox" <?= $records->voucher_code?'checked' :''?> style=" <?= $records->voucher_code?'' :'display:none'?>" id="voucher_apply" class="form-line"/><label
                                        for="voucher_apply" style="<?= $records->voucher_code?'' :'display:none;'?> font-size: 14px" id="voucher_label_apply"> <b>Voucher
                                        Apply</b></label>
                                <p id="voucher_apply_details"><label class="label-info" for="voucher_apply_details"><?=$records->voucher_code?'Available Discount :'.$records->discount.' RM':''?></label></p>
                            </div>
                        </div>
                    </div>

                    <div id="template"></div>
                    <input type="hidden" value="<?=$records->id?>" id="exam_id">
                    <button id="submit_info" class="btn btn-primary waves-effect" type="submit">Edit
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
    <script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>
    <script src="<?= base_url() ?>public/plugins/toastr/toastr.min.js"></script>
    <script type="text/javascript" charset="utf-8">


        $(document).ready(function () {
            var obj = $("#time_venue option:selected").text();
            if (obj == 'Others') {
                $("#time_venue_other_div").show();
                $('#time_venue_other').attr('required', true);
            } else {
                $('#time_venue_other').removeAttr('required');
                $("#time_venue_other_div").hide();
            }
            $('#time_venue').change(function () {
                var obj = $("#time_venue option:selected").text();
                if (obj == 'Others') {
                    $("#time_venue_other_div").show();
                    $('#time_venue_other').val('');
                    $('#time_venue_other').attr('required', true);
                } else {
                    $('#time_venue_other').removeAttr('required');
                    $('#time_venue_other').val('');
                    $("#time_venue_other_div").hide();
                }
            });


            var exam_types = $('#exam_type').val();
            if (exam_types == '2') $('#group_name_show').show();
            else $('#group_name_show').hide();

            $('#exam_type').change(function () {
                var exam_types = $(this).val();
                if (exam_types == '2') $('#group_name_show').show();
                else $('#group_name_show').hide();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('user/exam_registration/get_types_by_exam_type_id'); ?>",
                    data: {exam_type: exam_types},
                    dataType: "json",//return type expected as json
                    success: function (states) {
                        $("#exam_suite").val('');
                        $("#fees").val('');
                        $("#group_name").val('');
                        $('#instrument').empty();
                        $('#grade').empty();
                        $('#type').empty();
                        $("#type").append('<option value="">-- Please Select Type--</option>');
                        $.each(states, function (index, key) {
                            $("#type").append('<option value=' + key.id + '>' + key.name + '</option>');

                        });
                        $("#time_venue").selectpicker('refresh');
                        $("#type").selectpicker('refresh');
                        $("#instrument").selectpicker('refresh');
                        $("#grade").selectpicker('refresh');
                    },
                });
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('user/exam_registration/get_venues_by_exam_type_id'); ?>",
                    data: {exam_type: exam_types},
                    dataType: "json",//return type expected as json
                    success: function (states) {
                        $('#time_venue').empty();
                        $("#time_venue").append('<option value="">-- Please Select Time & Venue--</option>');
                        $.each(states, function (index, key) {
                            $("#time_venue").append('<option value=' + key.id + '>' + key.time_venue + '</option>');

                        });
                        $("#time_venue").selectpicker('refresh');
                    },
                });
            });

            $('#type').change(function () {
                var exam_types = $('#exam_type').val();
                var exam_type_types = $(this).val();
                if (exam_type_types == '1') $('#d_type').text('Instrument');
                else if (exam_type_types == '2') $('#d_type').text('Instrument');
                else if (exam_type_types == '3') $('#d_type').text('Product');
                else if (exam_type_types == '4') $('#d_type').text('Instrument');
                else if (exam_type_types == '5') $('#d_type').text('Categories');
                else if (exam_type_types == '6') $('#d_type').text('Categories');
                else if (exam_type_types == '7') $('#d_type').text('Categories');
                else $('#d_type').text('Instrument');
                //
                if (exam_type_types == '1') $('#g_type').text('Grade');
                else if (exam_type_types == '2') $('#g_type').text('Diploma');
                else if (exam_type_types == '4') $('#g_type').text('Grade');
                else if (exam_type_types == '5') $('#g_type').text('Grade');
                else if (exam_type_types == '6') $('#g_type').text('Grade');
                else if (exam_type_types == '7') $('#g_type').text('Grade');
                else $('#g_type').text('Grade');
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('user/exam_registration/get_exam_type_types'); ?>",
                    data: {exam_type: exam_types, exam_type_type: exam_type_types},
                    dataType: "json",//return type expected as json
                    success: function (states) {
                        $("#instrument").empty();
                        $("#grade").empty();
                        $("#instrument").append('<option value="">-- Please select Instrument--</option>');
                        $.each(states, function (index, key) {
                            $("#instrument").append('<option value=' + key.id + '>' + key.instrument_name + '</option>');

                        });
                        $("#instrument").selectpicker('refresh');
                        $("#grade").selectpicker('refresh');
                        $("#exam_suite").val('');
                        $("#fees").val('');
                    },
                });
            });
            $('#instrument').change(function () {
                $("#exam_suite").val('');
                $("#fees").val('');
                var types = $('#type').val();
                var instruments = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('user/exam_registration/get_exam_type_grade'); ?>",
                    data: {exam_type_type: types, instrument: instruments},
                    dataType: "json",//return type expected as json
                    success: function (states) {
                        // $("#d_grade").text(d_grade);
                        $("#grade").empty();
                        $("#grade").append('<option value="">-- Please Select Grade--</option>');
                        $.each(states, function (index, key) {
                            $("#grade").append('<option value=' + key.id + '>' + key.grade_name + '</option>');

                        });
                        $("#grade").selectpicker('refresh');
                    },
                });
            });

            $('#grade').change(function () {
                var instrument = $('#instrument').val();
                var grade = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('user/exam_registration/get_exam_suite'); ?>",
                    data: {instrument_id: instrument, grade_id: grade},
                    dataType: "json",//return type expected as json
                    success: function (states) {
                        $("#exam_suite").val(states.suite_name);
                        $("#fees").val(states.fees);
                    },
                });
            });
            $(document).on('blur', '#voucher_code', function (e) {
                var obj = $.trim($('#voucher_code').val());
                $('#voucher_apply').prop('checked', false);
                $('#voucher_apply_details').empty();
                if (obj) {
                    $('#voucher_label_apply').show();
                    $('#voucher_apply').show();
                    $('#voucher_apply').attr('required', 'required');
                } else {
                    $('#voucher_apply').removeAttr('required');
                    $('#voucher_label_apply').hide();
                    $('#voucher_apply').hide();
                }

            });
            $('#voucher_apply').click(function () {
                if ($(this).prop('checked') == true) {
                    var code = $('#voucher_code').val();
                    var exam_id = $('#exam_id').val();
                    toastr.options.positionClass = 'toast-bottom-right';
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('user/exam_registration/check_voucher_details_for_update'); ?>",
                        data: {exam_id: exam_id,code:code},
                        dataType: "json",//return type expected as json
                        success: function (states) {
                            console.log(states);
                            if (states.error_info == '') {
                                $('#voucher_apply_details').empty();
                                var label_obj = '<label style="font-size: 13px" class="label label-info" for="voucher_apply_details">Available Discount :' + states.update_status.fee + ' RM</label>'
                                $('#voucher_apply_details').append(label_obj);
                            } else {
                                toastr.error(states.error_info, 'Error');
                                $('#voucher_code').val('');
                                $('#voucher_apply').prop('checked', false);
                                $('#voucher_apply').removeAttr('required');
                                $('#voucher_apply').hide();
                                $('#voucher_label_apply').hide();
                            }
                        },
                        error: function (error) {
                            toastr.error('Something went wrong,Please contact with system admin', 'Error')
                        }
                    });
                }
                else {
                    if ($('#voucher_code').val() == '' || $('#voucher_code').val() == undefined)
                        toastr.error('Please enter voucher code', 'Error');
                    $('#voucher_code').val('');
                    $('#voucher_apply').removeAttr('required');
                    $('#voucher_apply').hide();
                    $('#voucher_label_apply').hide();
                    $('#voucher_apply_details').empty();
                }
            });
        });

    </script>