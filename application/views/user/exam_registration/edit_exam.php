<link href="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
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
    <?php echo form_open(base_url('user/exam_registration/edit_exam/' . $records->id), 'class="form-horizontal"'); ?>
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
                                    placeholder="Please enter first name" required="required" id="first_name" pattern="[a-z A-Z]+"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">Second Name (eg. Bin Musa, Shi Ting)</label>
                                <div class="form-line">
                                    <div class="form-line">
                                        <?php echo form_input('last_name', $records->last_name, 'class="form-control input-tip" 
                                    placeholder="Please enter second name" required="required" id="last_name" pattern="[a-z A-Z]+"'); ?>
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
                                        <input class="form-control col-md-3" required id="dob" name="dob" placeholder="Ex: 30/07/1998" type="text" value="<?=$this->functions->reformatDate($records->dob)?>" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d" />

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
                                <label for="school_name">School Name</label>
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
                            </div>
                        </div>
                    </div>

                    <div id="template"></div>
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
    <script src="<?= base_url() ?>public/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#dob').inputmask({mask: "99-99-9999"});
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
        });

    </script>