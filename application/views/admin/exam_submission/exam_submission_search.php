<!-- JQuery DataTable Css -->
<link href="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"
      rel="stylesheet">
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<link href="<?= base_url() ?>public/plugins/toastr/toastr.min.css" rel="stylesheet"/>

<style>
    [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
        position: static;
        opacity: 1;
    }
</style>
<!-- Exportable Table -->
<?php
$v = "";
if ($this->input->post('exam_type')) {
    $v .= "&exam_type=" . $this->input->post('exam_type');
}
if ($this->input->post('type')) {
    $v .= "&type=" . $this->input->post('type');
}
if ($this->input->post('from_date')) {
    $v .= "&from_date=" . $this->input->post('from_date');
}
if ($this->input->post('to_date')) {
    $v .= "&to_date=" . $this->input->post('to_date');
}

?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <?php echo form_open(base_url('admin/exam_registration/exam_submission_search')); ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="dob">From</label>
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    </span>
                                <div class="form-line">
                                    <input type="date" class="datepicker form-control" required id="from_date"
                                           name="from_date" value="<?php echo $from_date; ?>"
                                           data-value="2015-08-01" placeholder="From">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="dob">To</label>
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    </span>
                                <div class="form-line">
                                    <input type="date" class="datepicker form-control" required id="to_date"
                                           name="to_date" value="<?php echo $to_date ?>"
                                           data-value="2015-08-01" placeholder="To">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="exam_type">Type Of Exam</label>
                        <div class="form-group">
                            <?php
                            $exam_type_list[''] = '-- Please select Type--';
                            foreach ($exam_types as $exam_type) {
                                $exam_type_list[$exam_type->id] = $exam_type->name;
                            }
                            echo form_dropdown('exam_type', $exam_type_list, $exam_id, 'id="exam_type" class="form-control show-tick" ');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="type" id="d_grade">Grade</label>
                            <div class="form-line">
                                <select class="form-control show-tick" name="type" id="type">
                                    <option value="">-- Please select Grade--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="submit_info" class="btn btn-primary waves-effect" type="submit">Search
                </button>
                <?php echo form_close(); ?>
                <div class="clearfix"><br></div>

                <div class="table-responsive">
                    <?php echo form_open(base_url('admin/exam_registration/submission_actions'), 'id="action-form"'); ?>
                    <?php echo form_open('employees/employees_actions', 'id="action-form"'); ?>
                    <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="filled-in"
                                       id="check_all"
                                       name="select_all"></th>
                            <th>Ref No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Exam Suite</th>
                            <th>Examination/Product Name </th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Ref No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Exam Suite</th>
                            <th>Examination/Product Name </th>
                        </tr>
                        </tfoot>
                    </table>
                    <div style="margin-top: 20px;">
                        <a href="#" id="excel" data-action="export_excel" class="btn bg-primary waves-effect pull-left"><i
                                    class="material-icons">file_download</i> Export To Excel</a>
                    </div>
                    <div style="display: none;">
                        <input type="hidden" name="form_action" value="" id="form_action"/>
                        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
                    </div>
                    <?= form_close() ?>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Jquery DataTable Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<script src="<?= base_url() ?>public/plugins/momentjs/moment.js"></script>
<script src="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="<?= base_url() ?>public/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
    //---------------------------------------------------
    var table = $('#na_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "aLengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100,500]],
        "bFilter": false,
        "ajax": "<?=base_url('admin/exam_registration/datatable_submission_search_json/?v=1' . $v)?>",
        "order": [[2, 'asc'],[3, 'asc']],
        "columnDefs": [
            {
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'defaultContent': '',
                'className': 'select-checkbox',
                'checkboxes': {
                    'selectRow': true
                },
                'render': function (data, type, full, meta) {
                    if(data){
                        return '<input type="checkbox" class="chk-col-pink" name="id[]" value="'
                            + $('<div/>').text(data).html() + '"/>';
                    }

                }
            },

            {"targets": 1, "name": "ci_exam_submission_details.ref_no", 'searchable': true, 'orderable': false},
            {"targets": 2, "name": "ci_exam_submission_details.first_name", 'searchable': true, 'orderable': false},
            {"targets": 3, "name": "ci_exam_submission_details.last_name", 'searchable': true, 'orderable': false},
            {"targets": 4, "name": "ci_user_exam_details.dob", 'searchable': true, 'orderable': false},
            {"targets": 5, "name": "ci_user_exam_details.gender", 'searchable': true, 'orderable': false},
            {"targets": 6, "name": "ci_exam_submission_details.exam_suite", 'searchable': true, 'orderable': false},
            {"targets": 7, "name": "ci_exam_submission_details.instrument", 'searchable': true, 'orderable': false}
        ],
        'select': {
            'style': 'os',
            'selector': 'td:first-child'
        }
    });
</script>

<script type="text/javascript" charset="utf-8">
    $("#exam_submission_search").addClass('active');
    $(document).ready(function () {
        var current_exam_types = $('#exam_type').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/exam_registration/get_type_types'); ?>",
            data: {exam_type: current_exam_types},
            dataType: "json",//return type expected as json
            success: function (states) {
                $("#type").empty();
                $("#type").append('<option value="">-- Please Select Grade--</option>');
                $.each(states, function (index, key) {
                    var type = "<?php echo $type_id ?>";
                    var selection_status = ((type === key.name) ? 'selected' : '');
                    $("#type").append('<option ' + selection_status + ' value=' + key.name + '>' + key.name + '</option>');

                });
                $("#type").selectpicker('refresh');
            },
        });
        $('#exam_type').change(function () {
            var exam_types = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/exam_registration/get_type_types'); ?>",
                data: {exam_type: exam_types},
                dataType: "json",//return type expected as json
                success: function (states) {
                    $("#type").empty();
                    $("#type").append('<option value="">-- Please Select Grade--</option>');
                    $.each(states, function (index, key) {
                        $("#type").append('<option value=' + key.name + '>' + key.name + '</option>');

                    });
                    $("#type").selectpicker('refresh');
                },
            });
        });
        $('#check_all').click(function (e) {
            var table = $(e.target).closest('table');
            $('td input:checkbox', table).prop('checked', this.checked);
        });

        $('#excel').click(function (e) {
            var str = 0;
            $(".chk-col-pink:checked").each(function () {
                str += 1;
            });
            if (str == 0) {
                toastr.error('No data selected for export.', 'Error');
                return false;
            }
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });
    });
</script>



