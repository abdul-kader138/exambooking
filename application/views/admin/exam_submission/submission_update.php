<div class="container-fluid">
    <style>
        hr
        {
            border:solid 1px #666666;
            width: 96%;
            color: ##666666;
            height: 1px;
        }
    </style>
    <link href="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
          rel="stylesheet"/>
    <?php if (!empty($exam_detail)) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Submission Details (<?= $exam_detail->ref_no ?>)</h2>
                        <a href="<?= base_url('admin/exam_registration/exam_submission_list'); ?>"
                           class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> List
                            Submission</a>

                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Candidate: <?= $exam_detail->first_name." ".$exam_detail->last_name ?></b>
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
                                                <input type="text" id="suite_name" name="suite_name" required class="form-control">
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
                                                <input type="date" class="datetimepicker form-control" required id="dob" name="dob"
                                                       data-value="2015-08-01" placeholder="Please Choose DOB">  </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pull-right" style="margin-right: 12px;">
                                    <div class="col-lg-6 col-md-5 col-sm-8 col-xs-7 form-control-label">
                                    <input type="submit" name="submit" value="ADD" class="btn btn-primary m-t-15 waves-effect">
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