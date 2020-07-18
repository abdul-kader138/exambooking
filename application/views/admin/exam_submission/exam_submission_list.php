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
                    List Submission
                </h2>
                <a href="<?= base_url('admin/exam_registration/');?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> Candidates</a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th>Submitted By</th>
                            <th>Submission Date</th>
                            <th>Reference No</th>
                            <th>Candidate</th>
                            <th>Fees</th>
                            <th width="50" class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Submitted By</th>
                            <th>Submission Date</th>
                            <th>Reference No</th>
                            <th>Candidate</th>
                            <th>Fees</th>
                            <th style="width: 50px;" class="text-right">Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->


<!-- Jquery DataTable Plugin Js -->
<script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    //---------------------------------------------------
    var table = $('#na_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?=base_url('admin/exam_registration/datatable_submission_json')?>",
        "order": [[0, 'desc']],
        "columnDefs": [
            {"targets": 0, "name": "ci_exam_submission_details.created_date", 'searchable': true, 'orderable': true},
            {"targets": 1, "name": "ci_users.firstname", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "ci_exam_submission_details.ref_no", 'searchable': true, 'orderable': true},
            {"targets": 3, "name": "ci_exam_submission_details.id", 'searchable': true, 'orderable': true},
            {"targets": 4, "name": "ci_exam_submission_details.fees", 'searchable': true, 'orderable': true},
            {"targets": 5, "name": "Action", 'searchable': false, 'orderable': false, 'width': '40px'}

        ]
    });
</script>
<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<!-- Custom Js -->
<script src="<?= base_url() ?>public/js/pages/tables/jquery-datatable.js"></script>
<script>
    //Delete Dialogue
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    $("#exam_submission_list").addClass('active');
</script>




