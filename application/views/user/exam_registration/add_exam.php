﻿<link href="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
      rel="stylesheet"/>
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<link href="<?= base_url() ?>public/plugins/toastr/toastr.min.css" rel="stylesheet"/>
<style>
    [type=checkbox]:not(:checked) {
        left: inherit;
        margin-top: 8px;
    }
</style>
<div class="container-fluid">
    <?php echo form_open(base_url('user/exam_registration/add_exam'), 'class="form-horizontal"'); ?>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Add New Exam</h2>
                    <a href="<?= base_url('user/exam_registration/'); ?>"
                       class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> Candidates</a>
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
                                echo form_dropdown('exam_type', $exam_type_list, "", 'id="exam_type" class="form-control show-tick"  required="required"" ');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name">First Name (eg. Abdullah, Carol Lim)</label>
                                <div class="form-line">
                                    <input type="text" name="first_name" class="form-control" required
                                           placeholder="Please enter first name" pattern="^[a-zA-Z][a-z A-Z0]{1,15}$"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">Second Name (eg. Bin Musa, Shi Ting)</label>
                                <div class="form-line">
                                    <input type="text" name="last_name" class="form-control" required
                                           placeholder="Please enter second name"  pattern="^[a-zA-Z][a-z A-Z0]{1,15}$"/>
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
                                               data-value="2015-08-01" placeholder="Please Choose DOB">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="gender">Gender</label>
                            <div class="form-line">
                                <select class="form-control show-tick" name="gender" required>
                                    <option value="">-- Please select Gender--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="common row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="school_name">School Name (only for school name to print on
                                    certificate) </label>
                                <div class="form-line">
                                    <input type="text" name="school_name" class="form-control"
                                           placeholder="Please enter school name"/>
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
    <script src="
    <?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>
    <script src="<?= base_url() ?>public/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('.common').hide();
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