<!-- JQuery DataTable Css -->
<link href="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"
      rel="stylesheet">
<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
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
                if (!empty($user_exam_details)) { ?>
                    <div style="margin-top: 20px;">
                        <a href="<?= base_url('user/exam_submission/submit_exam'); ?>"
                           class="btn bg-pink waves-effect pull-left"> Submit</a>
                    </div>
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

<!-- Jquery DataTable Plugin Js -->
<script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
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
            {"targets": 3, "name": "ci_user_exam_details.venue_details", 'searchable': true, 'orderable': true},
            {"targets": 4, "name": "ci_exam_type.name", 'searchable': true, 'orderable': true},
            {"targets": 5, "name": "ci_exam_type_types.name", 'searchable': true, 'orderable': true},
            {"targets": 6, "name": "ci_exam_instrument_product.instrument_name", 'searchable': true, 'orderable': true},
            {"targets": 7, "name": "ci_exam_grade_diploma.grade_name", 'searchable': true, 'orderable': true},
            {"targets": 8, "name": "ci_user_exam_details.fees", 'searchable': true, 'orderable': true},
            {"targets": 9, "name": "ci_user_exam_details.submitted", 'searchable': true, 'orderable': true},
            {"targets": 10, "name": "ci_user_exam_details.created_date", 'searchable': true, 'orderable': true},
            {"targets": 11, "name": "Action", 'searchable': false, 'orderable': false, 'width': '100px'}
        ]
    });
</script>
<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<!-- Custom Js -->
<script src="<?= base_url() ?>public/js/pages/tables/jquery-datatable.js"></script>
<script>
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Delete Dialogue
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    $("#exam_list").addClass('active');
</script>




