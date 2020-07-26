<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<?php
if ($grade_management['type_types_id'] == '1') $d_type = 'Instrument';
elseif ($grade_management['type_types_id'] == '2')
    $d_type = 'Instrument';
elseif ($grade_management['type_types_id'] == '3')
    $d_type = 'Product';
elseif ($grade_management['type_types_id'] == '4')
    $d_type = 'Instrument';
elseif ($grade_management['type_types_id'] == '5')
    $d_type = 'Categories';
elseif ($grade_management['type_types_id'] == '6')
    $d_type = 'Categories';
elseif ($grade_management['type_types_id'] == '7')
    $d_type = 'Categories';
else
    $d_type = 'Instrument';
?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    EDIT Grade
                </h2>
                <a href="<?= base_url('admin/grade_management/'); ?>" class="btn bg-deep-orange waves-effect pull-right">List
                    Grade</a>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <?php if (isset($msg) || validation_errors() !== ''): ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                            <?= validation_errors(); ?>
                            <?= isset($msg) ? $msg : ''; ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open(base_url('admin/grade_management/grade_management_edit/' . md5($grade_management['id'])), 'class="form-horizontal"') ?>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Type Of Exam</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php
                                    $exam_type_list[''] = '-- Please select Type Of Exam--';
                                    foreach ($exam_types as $exam_type) {
                                        $exam_type_list[$exam_type->id] = $exam_type->name;
                                    }
                                    echo form_dropdown('exam_type', $exam_type_list, $grade_management['exam_type_id'], 'id="exam_type" class="form-control show-tick"  required="required"" ');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="type">Type</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php
                                    $type_type_list[''] = '-- Please select Type--';
                                    foreach ($type_types as $type) {
                                        $type_type_list[$type->id] = $type->name;
                                    }
                                    echo form_dropdown('type', $type_type_list, $grade_management['type_types_id'], 'id="type" class="form-control show-tick"  required="required"" ');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="d_type" id="d_type"><?= $d_type ?></label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php
                                    $instrument_list[''] = '-- Please select --';
                                    foreach ($instruments as $instrument) {
                                        $instrument_list[$instrument->id] = $instrument->instrument_name;
                                    }
                                    echo form_dropdown('instrument_id', $instrument_list, $grade_management['instrument_id'], 'id="instrument_id" class="form-control show-tick"  required="required"" ');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="d_type" >Grade</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="grade_name" name="grade_name" required
                                           value="<?= $grade_management['grade_name']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <input type="submit" name="submit" value="UPDATE"
                                   class="btn btn-primary m-t-15 waves-effect">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<script type="application/javascript">
    $(document).ready(function () {
        $('#exam_type').change(function () {
            var exam_types = $('#exam_type').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/grade_management/get_types_by_exam_type_id'); ?>",
                data: {exam_type: exam_types},
                dataType: "json",//return type expected as json
                success: function (states) {
                    $("#type").empty();
                    $("#instrument_id").empty();
                    $("#type").append('<option value="">-- Please Select Type--</option>');
                    $.each(states, function (index, key) {
                        $("#type").append('<option value=' + key.id + '>' + key.name + '</option>');

                    });
                    $("#type").selectpicker('refresh');
                    $("#instrument_id").selectpicker('refresh');

                },
            });
        });
        $('#type').change(function () {
            var exam_types = $('#exam_type').val();
            var type_types = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/grade_management/get_instrument_by_exam_type_id'); ?>",
                data: {exam_type: exam_types, type_types_id: type_types},
                dataType: "json",//return type expected as json
                success: function (states) {
                    $("#instrument_id").empty();
                    $("#instrument_id").append('<option value="">-- Please Select --</option>');
                    $.each(states, function (index, key) {
                        $("#instrument_id").append('<option value=' + key.id + '>' + key.instrument_name + '</option>');

                    });
                    $("#type").selectpicker('refresh');
                    $("#instrument_id").selectpicker('refresh');
                },
            });
        });
        $('#type').change(function () {
            var exam_type_types = $(this).val();
            var l_type = "Categories";
            if (exam_type_types == '3') l_type = 'Product Name';
            if (exam_type_types == '1' || exam_type_types == '2' || exam_type_types == '4') l_type = 'Instrument';
            $("#l_type").text(l_type);
        });
    });
</script>
