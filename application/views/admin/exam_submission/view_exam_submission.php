<div class="container-fluid">
    <?php if (!empty($records) ) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Submission Details (<?=$records[0]->ref_no ?>)</h2>
                        <a href="<?= base_url('admin/exam_registration/exam_submission_list');?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> List Submission</a>

                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                              <b> Submitted By : <?=$records[0]->firstname.' '.$records[0]->lastname?></b>
                            </div>
                            <div class="col-sm-4">
                                <b>Submission Date: <?=$records[0]->created_date?></b>
                            </div>
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
                                            <th>Fees</th>
                                            <th>Action</th>
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
                                                <td><?= $exam_detail->fees ?></td>
                                                <td><a title="View" class="update btn btn-sm btn-info" href="<?php echo base_url('admin/exam_registration/update_submission/' .md5($exam_detail->id)) ?>"> <i class="material-icons">visibility</i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tbody>
                                        <?php if(!empty($records[0]->penalty_fee)){ ?>
                                        <tr style="background-color: #9db5b0">
                                            <td colspan="8" style="text-align: right"><b>Penalty Fee :</b></td>
                                            <td><b><?= ($total_fees +$records[0]->penalty_fee)?></b></td>
                                            <td></td>
                                        </tr>
                                        <?php } ?>
                                        <tr style="background-color: #9db5b0">
                                            <td colspan="8" style="text-align: right"><b>Total :</b></td>
                                            <td><b><?= $total_fees ?></b></td>
                                            <td></td>
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