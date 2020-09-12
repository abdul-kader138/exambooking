<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    EDIT Overtime Code
                </h2>
                <a href="<?= base_url('admin/overtime_submission/'); ?>"
                   class="btn bg-deep-orange waves-effect pull-right">List Overtime Code</a>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <?php if (isset($msg) || validation_errors() !== ''): ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                            <?= validation_errors(); ?>
                            <?= isset($msg) ? $msg : ''; ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open(base_url('admin/overtime_submission/overtime_submission_edit/' . md5($voucher['id'])), 'class="form-horizontal"') ?>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Overtime Code</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="code" value="<?= $voucher['code'] ?>" name="code"
                                               required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="button" name="random_num" id="random_num" value="Generate Code"
                                               class="btn btn-primary waves-effect form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Fee Charge(RM)</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="fee" name="fee" value="<?= $voucher['fee'] ?>" required
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <input type="submit" name="submit" value="UPDATE"
                                   class="btn btn-primary m-t-15 waves-effect">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#random_num').click(function(){
        $('#code').val(generateCardNo(8));
    });

    function generateCardNo(x) {
        if(!x) { x = 16; }
        chars = "1234567890";
        no = "";
        for (var i=0; i<x; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            no += chars.substring(rnum,rnum+1);
        }
        return no;
    }
</script>

