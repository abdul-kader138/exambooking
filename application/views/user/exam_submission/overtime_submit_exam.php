
<div class="container-fluid">
    <?php echo form_open(base_url('user/exam_submission/save_submit_exam'), 'class="form-horizontal"'); ?>
    <?php if (!empty($exam_details) ) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>My Submission</h2>
                        <input type="hidden" id="submission_code" name="submission_code" value="<?php echo $overtime_time['code']; ?>">
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="table-responsive" style="overflow-x:auto;">
                                    <table id="na_datatable"
                                           class="table table-bordered table-striped table-hover dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>First Name</th>
                                            <th>Second Name</th>
                                            <th>Exam Type</th>
                                            <th>Instrument/Product/Category</th>
                                            <th>Fees</th>
                                        </tr>
                                        </thead>
                                        <?php
                                        $i = 0;
                                        $total_fees = 0;
                                        foreach ($exam_details as $exam_detail):
                                            $i++;
                                            $total_fees += $exam_detail->fees;
                                            ?>
                                            <tr>
                                                <td><?= $i ?><input type="hidden" name="val[]" value="<?= $exam_detail->id ?>"></td>
                                                <td><?= $exam_detail->first_name ?></td>
                                                <td><?= $exam_detail->last_name ?></td>
                                                <td><?= $exam_detail->type_type ?></td>
                                                <td><?= $exam_detail->instrument_name ?></td>
                                                <td><?= $exam_detail->fees ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tbody>
                                        <?php if(!empty($overtime_time)){
                                            $total_fees +=$overtime_time['fee'];
                                            ?>
                                        <tr>
                                            <td colspan="5" style="text-align: right"><b>Penalty Fee:</b></td>
                                            <td><b><?= $overtime_time['fee'] ?></b></td>
                                        </tr>
                                        <?php } ?>
                                        <tr style="background-color: #9db5b0">
                                            <td colspan="5" style="text-align: right"><b>Total :</b></td>
                                            <td><b><?= $total_fees ?></b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12" style="text-align: center">
                                <label for="">Terms & Conditions</label>
                                <textarea class="form-control" readonly name="" id="" cols="15" rows="5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</textarea>
                            </div>
                        </div>
                        <a href="<?= base_url('user/exam_registration'); ?>" class="btn bg-grey waves-effect pull-left">
                            Not
                            Agree</a>
                        &nbsp;&nbsp;&nbsp;<button id="submit" name="submit" value="submit" class="btn btn-primary waves-effect" type="submit">
                            Agree
                            & Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Exam Submission</h2>
                        <a href="<?= base_url('user/exam_registration'); ?>"
                           class="btn bg-deep-orange waves-effect pull-right"><i
                                    class="material-icons">view_list</i> Candidates</a>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <b>There is no information available for submission.</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php echo form_close(); ?>
</div>
<div class="container-fluid">
