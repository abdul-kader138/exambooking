<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    ADD Date & Venue
                </h2>
                <a href="<?= base_url('admin/time_venue/'); ?>" class="btn bg-deep-orange waves-effect pull-right">List
                    Date & Venue</a>
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

                    <?php echo form_open(base_url('admin/time_venue/time_venue_add'), 'class="form-horizontal"'); ?>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Date & Venue</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="time_venue" name="time_venue" required class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-5 col-sm-5 col-xs-5 form-control-label">

                        </div>
                        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-7">
                            <div class="form-check form-check-inline">
                                <input type="radio" checked value="1" class="form-check-input" id="music"
                                       name="exam_type">
                                <label class="form-check-label" style="font-size: 14px;" for="music">Music</label>
                                <input type="radio" value="2" class="form-check-input" id="drama"
                                       name="exam_type">
                                <label class="form-check-label" style="font-size: 14px;" for="drama">Drama</label>
                                <input type="radio" value="3" class="form-check-input" id="language"
                                       name="exam_type">
                                <label class="form-check-label" style="font-size: 14px;" for="language">Language</label>

                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <input type="submit" name="submit" value="ADD"
                                   class="btn btn-primary m-t-15 waves-effect">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

