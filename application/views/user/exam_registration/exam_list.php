<link href="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"
      rel="stylesheet">
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<link href="<?= base_url() ?>public/plugins/toastr/toastr.min.css" rel="stylesheet"/>
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2 style="display: inline-block;">
                    Candidates
                </h2>
                <a href="<?= base_url('user/exam_registration/add_exam'); ?>"
                   class="btn bg-deep-orange waves-effect pull-right"><i
                            class="material-icons">view_list</i> ADD New Exam</a>
            </div>
            <div class="body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Second Name</th>
                            <th>School Name</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Venue</th>
                            <th>Type</th>
                            <th>Exam Type</th>
                            <th>Instrument/Product</br>/Category</th>
                            <th>Grade</th>
                            <th>Fees</th>
                            <th>Submitted</th>
                            <th>Created Date</th>
                            <th width="200" class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>First Name</th>
                            <th>Second Name</th>
                            <th>School Name</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Venue</th>
                            <th>Type</th>
                            <th>Exam Type</th>
                            <th>Instrument/Product</br>/Category</th>
                            <th>Grade</th>
                            <th>Fees</th>
                            <th>Submitted</th>
                            <th>Created Date</th>
                            <th style="width: 150px;" class="text-right">Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <?php
                if (!empty($user_exam_details) && !empty($submission_time)) { ?>
                    <div style="margin-top: 20px;">
                        <a href="<?= base_url('user/exam_submission/submit_exam'); ?>"
                           class="btn bg-pink waves-effect pull-left"> Submit</a>
                    </div>
                <?php } ?>
                <?php if (empty($submission_time) && !empty($user_exam_details)) { ?>
                    <div style="margin-top: 20px;" class="col-sm-6">
                        <a href="#" disabled class="btn bg-pink waves-effect"> Submit</a>&nbsp;&nbsp;
                        <span><b class="bg-pink"
                                 style="font-size: 12px">&nbsp;&nbsp;Submission is Over! &nbsp;</b></span>
                    </div>
                    <div style="margin-top: 20px;" class="col-sm-6">
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => 'overtime_submit_exam');
                        echo form_open(base_url('user/exam_submission/overtime_submit_exam'), $attributes); ?>
                        <label for="">Overtime Code:&nbsp;</label>&nbsp;
                        <input type="text" id="overtime_code" name="overtime_code" required>&nbsp;&nbsp;
                        <button class="btn bg-blue waves-effect" id="overtime_code_submit"> Apply & Submit</button>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->

<!-- Modal -->
<div id="confirm-delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <div class="modal-body">
                <p>As you sure you want to delete.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<script src="<?= base_url() ?>public/js/pages/tables/jquery-datatable.js"></script>
<script src="<?= base_url() ?>public/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
    //---------------------------------------------------
    var table = $('#na_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?=base_url('user/exam_registration/datatable_json')?>",
        "order": [[10, 'desc']],
        "columnDefs": [
            {"targets": 0, "name": "ci_user_exam_details.first_name", 'searchable': true, 'orderable': true},
            {"targets": 1, "name": "ci_user_exam_details.last_name", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "ci_user_exam_details.school_name", 'searchable': true, 'orderable': true},
            {"targets": 3, "name": "ci_user_exam_details.dob", 'searchable': true, 'orderable': true},
            {"targets": 4, "name": "ci_user_exam_details.gender", 'searchable': true, 'orderable': true},
            {"targets": 5, "name": "ci_user_exam_details.venue_details", 'searchable': true, 'orderable': true},
            {"targets": 6, "name": "ci_exam_type.name", 'searchable': true, 'orderable': true},
            {"targets": 7, "name": "ci_exam_type_types.name", 'searchable': true, 'orderable': true},
            {"targets": 8, "name": "ci_exam_instrument_product.instrument_name", 'searchable': true, 'orderable': true},
            {"targets": 9, "name": "ci_exam_grade_diploma.grade_name", 'searchable': true, 'orderable': true},
            {"targets": 10, "name": "ci_user_exam_details.fees", 'searchable': true, 'orderable': true},
            {"targets": 11, "name": "ci_user_exam_details.submitted", 'searchable': true, 'orderable': true},
            {"targets": 12, "name": "ci_user_exam_details.created_date", 'searchable': true, 'orderable': true},
            {"targets": 13, "name": "Action", 'searchable': false, 'orderable': false, 'width': '100px'}
        ]
    });
    autosize($('textarea.auto-growth'));

    //Delete Dialogue
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    $("#exam_list").addClass('active');

    $('#overtime_code_submit').click(function (e) {
        e.preventDefault();
        var code = $('#overtime_code').val();
        if (code == '' || code == undefined) toastr.error('Please enter overtime code.', 'Error');
        if (code != '' && code != undefined) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('user/exam_registration/check_overtime_details'); ?>",
                data: {code: code},
                dataType: "json",//return type expected as json
                success: function (states) {
                    debugger;
                    if (states.error_info == '') {
                        $('#overtime_submit_exam').submit();
                    } else {
                        toastr.error(states.error_info, 'Error');
                    }
                },
                error: function (error) {
                    toastr.error('Something went wrong,Please contact with system admin', 'Error');
                }
            });
        }
    });
</script>




