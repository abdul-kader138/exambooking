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
                <h2>
                   &nbsp;  <h2 style="display: inline-block;">
                        List Fee
                      </h2>
                </h2>
                <a href="<?= base_url('admin/fee_management/fee_management_add'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i
                            class="material-icons">add_circle</i> ADD Fee</a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th>#ID</th>
                            <th> Type Of Exam</th>
                            <th>Type</th>
                            <th>Instrument/Categories</th>
                            <th>Grade</th>
                            <th>Fees</th>
                            <th>Suite Name</th>
                            <th width="200" class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td>#ID</td>
                            <td> Type Of Exam</td>
                            <td>Type</td>
                            <td>Instrument/Categories</td>
                            <td>Grade</td>
                            <td>Fees</td>
                            <td>Suite Name</td>
                            <td style="width: 150px;" class="text-right">Action</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
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
        "ajax": "<?=base_url('admin/fee_management/datatable_json')?>",
        "order": [[3, 'asc'],[4,'asc']],
        "columnDefs": [
            {"targets": 0, "name": "ci_exam_suite_fees.id", 'searchable': true, 'orderable': true},
            {"targets": 1, "name": "ci_exam_type.name", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "ci_exam_type_types.name", 'searchable': true, 'orderable': true},
            {"targets": 3, "name": "ci_exam_instrument_product.instrument_name", 'searchable': true, 'orderable': true},
            {"targets": 4, "name": "ci_exam_grade_diploma.grade_name", 'searchable': true, 'orderable': true},
            {"targets": 5, "name": "ci_exam_suite_fees.fees", 'searchable': true, 'orderable': true},
            {"targets": 6, "name": "ci_exam_suite.name", 'searchable': true, 'orderable': true},
            {"targets": 7, "name": "Action", 'searchable': false, 'orderable': false, 'width': '100px'}
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
    $("#fee_management_list").addClass('active');
</script>
  

  

