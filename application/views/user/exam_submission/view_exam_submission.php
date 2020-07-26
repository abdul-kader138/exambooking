<div class="container-fluid">
    <?php if (!empty($records) ) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Submission Details (<?=$records[0]->ref_no ?>)</h2>
                        <a href="<?= base_url('user/exam_submission/exam_submission_list');?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> My Submissions</a>

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
                                            <th>Venue</th>
                                            <th>Type</th>
                                            <th>Exam Type</th>
                                            <th>Instrument/Product/Category</th>
                                            <th>Grade</th>
                                            <th>Exam No</th>
                                            <th>Exam Date</th>
                                            <th>Status</th>
                                            <th>Voucher Code</th>
                                            <th>Fees</th>
                                        </tr>
                                        </thead>
                                        <?php
                                        $i = 0;
                                        $total_fees = 0;
                                        foreach ($records as $exam_detail):
                                            $i++;
                                            $total_fees += $exam_detail->fees;
                                            ?>
                                            <tr>
                                                <td><?= $i ?><input type="hidden" name="val[]" value="<?= $exam_detail->id ?>"></td>
                                                <td><?= $exam_detail->first_name ?></td>
                                                <td><?= $exam_detail->last_name ?></td>
                                                <td><?= $exam_detail->venue ?></td>
                                                <td><?= $exam_detail->exam_types ?></td>
                                                <td><?= $exam_detail->type_types ?></td>
                                                <td><?= $exam_detail->instrument ?></td>
                                                <td><?= $exam_detail->grade ?></td>
                                                <td><?= $exam_detail->exam_no ?></td>
                                                <td><?= (($exam_detail->exam_date)?substr($exam_detail->exam_date,0,16):'') ?></td>
                                                <td><?= $exam_detail->exam_status ?></td>
                                                <td><?= $exam_detail->voucher_code ?></td>
                                                <td><?= $exam_detail->fees ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tbody>
                                        <tr style="background-color: #9db5b0">
                                            <td colspan="12" style="text-align: right"><b>Total :</b></td>
                                            <td><b><?= $total_fees ?></b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>