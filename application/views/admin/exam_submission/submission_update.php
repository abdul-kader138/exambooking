<div class="container-fluid">
    <link href="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
          rel="stylesheet"/>
    <link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>public/plugins/toastr/toastr.min.css" rel="stylesheet"/>
    <?php if (!empty($exam_detail)) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <input type="hidden" id="submission_id" value="<?= $exam_detail->id ?>"/>
                        <h2>Submission No. -(<?= $exam_detail->ref_no ?>)</h2><br><br>
                        <h2>Candidate ID -<?= $exam_detail->id ?></h2>
                        <a href="<?= base_url('admin/exam_registration/exam_submission_list'); ?>"
                           class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> List
                            Submission</a>

                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Candidate: <?= $exam_detail->first_name . " " . $exam_detail->last_name ?></b>
                            </div>
                            <div class="col-sm-4">
                                <b> Submitted By : <?= $exam_detail->firstname . ' ' . $exam_detail->lastname ?></b>
                            </div>
                            <div class="col-sm-4">
                                <b>Submission Date: <?= $exam_detail->created_date ?></b>
                            </div>
                            <hr>
                            <div class="col-sm-6">

                                <div class="table-responsive" style="overflow-x:auto;">
                                    <table id="na_datatable"
                                           class="table table-bordered" style="background-color: #d1d1d1">
                                        <tbody>
                                        <tr>
                                            <td>Venue : <?= $exam_detail->venue ?></td>
                                        </tr>
                                        <tr>
                                            <td>Type Of Exam : <?= $exam_detail->exam_types ?></td>
                                        </tr>
                                        <tr>
                                            <td>Type : <?= $exam_detail->type_types ?></td>
                                        </tr>
                                        <tr>
                                            <td>Instrument/Product/Category : <?= $exam_detail->instrument ?></td>
                                        </tr>
                                        <tr>
                                            <td>Grade : <?= $exam_detail->grade ?></td>
                                        </tr>
                                        <tr>
                                            <td>Fees : <?= $exam_detail->fees ?></td>
                                        </tr>
                                        <tr>
                                            <td>Voucher Code
                                                : <?= isset($exam_detail_info['voucher_code']) ? $exam_detail_info['voucher_code'] : '' ?></td>
                                        </tr>
                                        <?php if (isset($exam_detail_info['voucher_code'])) { ?>
                                            <tr>
                                                <td>Discount
                                                    : <?= isset($exam_detail_info['discount']) ? $exam_detail_info['discount'] : '' ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-lg-6 col-md-5 col-sm-8 col-xs-7 form-control-label">
                                        <label for="name">Exam No</label>
                                    </div>
                                    <div class="col-lg-5 col-md-7 col-sm-4 col-xs-5">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="exam_no" name="exam_no" required
                                                       value="<?= $exam_detail->exam_no ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-5 col-sm-8 col-xs-7 form-control-label">
                                        <label for="name">Exam Date/Time</label>
                                    </div>
                                    <div class="col-lg-5 col-md-7 col-sm-4 col-xs-5">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="datetimepicker form-control" required
                                                       id="exam_date"
                                                       name="exam_date"
                                                       value="<?= (($exam_detail->exam_date) ? substr($exam_detail->exam_date, 0, 16) : ''); ?>"
                                                       placeholder="Please Choose Exam Date"></div>
                                        </div>
                                        <input type="button" name="add_exam_no" id="add_exam_no" value="ADD"
                                               class="btn btn-primary m-t-15 waves-effect pull-right">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-lg-6 col-md-5 col-sm-8 col-xs-7 form-control-label">
                                        <label for="name">Status</label>
                                    </div>
                                    <div class="col-lg-5 col-md-7 col-sm-4 col-xs-5">
                                        <select class="form-control show-tick" name="status" id="status" required>
                                            <option value="">-- Please select--</option>
                                            <option value="Pass" <?= ($exam_detail->exam_status == 'Pass' ? 'selected' : ''); ?>>
                                                Pass
                                            </option>
                                            <option value="Fail" <?= ($exam_detail->exam_status == 'Fail' ? 'selected' : ''); ?>>
                                                Fail
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-5 col-sm-8 col-xs-7 form-control-label">
                                        <label for="name" class="voucher-code-class">voucher No.</label>
                                    </div>
                                    <div class="col-lg-5 col-md-7 col-sm-4 col-xs-5">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="voucher_code" name="voucher_code" required
                                                       value="<?= $exam_detail->voucher_code ?>" class="form-control">
                                            </div>
                                        </div>
                                        <input type="button" name="add_voucher" id="add_voucher" value="ADD"
                                               class="btn btn-primary m-t-15 waves-effect pull-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<script src="<?= base_url() ?>public/plugins/momentjs/moment.js"></script>
<script src="
    <?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>
<script src="<?= base_url() ?>public/plugins/toastr/toastr.min.js"></script>
<script type="application/javascript">
    $('#add_voucher').on('click', function () {
        var voucher = $('#voucher_code').val();
        var status_val = $('#status').val();
        var submission_obj = $('#submission_id').val();

        if (status_val == '' || status_val == 'undefined') {
            toastr.warning('Status is required', 'Error');
            return true;
        }
        if ((voucher == '' || voucher == 'undefined') && status_val == 'Fail') {
            toastr.warning('Voucher No. is required', 'Error');
            return true;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/exam_registration/update_voucher_info'); ?>",
            data: {voucher_code: voucher, status: status_val, submission_id: submission_obj},
            dataType: "json",//return type expected as json
            success: function (states) {
                if (states.error_info === '') {
                    toastr.success('Status & Voucher code updated successfully', 'Success')
                } else {
                    toastr.error(states.error_info, 'Error')
                }
            },
            error: function (error) {
                toastr.error('Something went wrong,Please contact with system admin', 'Error')
            }
        });
    });

    $('#add_exam_no').on('click', function () {
        var exam_no = $('#exam_no').val();
        var exam_date = $('#exam_date').val();
        var submission_obj = $('#submission_id').val();
        if (exam_no == '' || exam_no == 'undefined') {
            toastr.warning('Exam No is required', 'Error');
            return true;
        }
        if ((exam_date == '' || exam_date == 'undefined') && exam_no) {
            toastr.warning('Exam Date/Time is required', 'Error');
            return true;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/exam_registration/update_exam_info'); ?>",
            data: {exam: exam_no, exam_dates: exam_date, submission_id: submission_obj},
            dataType: "json",//return type expected as json
            success: function (states) {
                if (states.update_status == 'Yes') {
                    toastr.success('Exam No & Date/Time updated successfully', 'Success')
                } else {
                    toastr.error('Update operation failed.', 'error')
                }
            },
            error: function (error) {
                toastr.error('Something went wrong,Please contact with system admin', 'Error')
            }
        });
    });
</script>