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
                    <h2 style="display: inline-block;">
                        List Exam Suite
                    </h2>
                </h2>
                <a href="<?= base_url('admin/exam_suite/exam_suite_add'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i
                            class="material-icons">add_circle</i> ADD Exam Suite</a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th style="width: 40px;" class="text-left">#ID</th>
                            <th>Exam Suite Name</th>
                            <th width="200" class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td style="width: 40px;" class="text-left">#ID</td>
                            <td>Exam Suite Name</td>
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
        "ajax": "<?=base_url('admin/exam_suite/datatable_json')?>",
        "order": [[1, 'asc']],
        "columnDefs": [
            {"targets": 0, "name": "id", 'searchable': true, 'orderable': true},
            {"targets": 1, "name": "name", 'searchable': true, 'orderable': true},
            // {"targets": 2, "name": "created_date", 'searchable': true, 'orderable': true},
            {"targets": 2, "name": "Action", 'searchable': false, 'orderable': false, 'width': '100px'}
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
    $("#exam_suite_list").addClass('active');
</script>
  

  

