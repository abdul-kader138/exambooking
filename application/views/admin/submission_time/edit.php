<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    EDIT Submission Time
                </h2>
                <a href="<?= base_url('admin/submission_time/'); ?>"
                   class="btn bg-deep-orange waves-effect pull-right">List Submission Time</a>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <?php if (isset($msg) || validation_errors() !== ''): ?>
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                                <?= validation_errors(); ?>
                                <?= isset($msg) ? $msg : ''; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php echo form_open(base_url('admin/submission_time/submission_time_edit/'. md5($submission_time['id'])), 'class="form-horizontal"'); ?>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">From</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                    </span>
                                        <div class="form-line">
                                            <input type="date" class="datepicker form-control" required id="start_date"
                                                   value="<?=$submission_time['start_date']?>"  name="start_date" data-value="2015-08-01" placeholder="From">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">To</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                    </span>
                                        <div class="form-line">
                                            <input type="date" class="datepicker form-control" required id="end_date"
                                               value="<?=$submission_time['end_date']?>"    name="end_date" data-value="2015-08-01" placeholder="To">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Status</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="status" required>
                                            <option value="">-- Please select --</option>
                                            <option <?= ($submission_time['status'] == 1) ? 'selected' : '' ?> value="1">Active</option>
                                            <option <?= ($submission_time['status'] == 0) ? 'selected' : '' ?> value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <input type="submit" name="submit" value="ADD" class="btn btn-primary m-t-15 waves-effect">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

