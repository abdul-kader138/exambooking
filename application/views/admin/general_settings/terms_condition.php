<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                   Terms & Condition
                </h2>
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

                    <?php echo form_open(base_url('admin/general_settings/terms_add'), 'class="form-horizontal"'); ?>
                    <div class="row clearfix">
                         <textarea id="terms" name="terms">
                             <?php echo $terms['terms']; ?>
                       </textarea>
                    </div>
                    <div class="row clearfix">
                            <input type="submit" name="submit" value="SAVE" class="btn btn-primary m-t-15 waves-effect">
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ckeditor -->
<script src="<?= base_url()?>public/plugins/ckeditor/ckeditor.js"></script>
<!-- Custom Js -->
<script type="text/javascript">
    //CKEditor
    CKEDITOR.replace('terms');
    CKEDITOR.config.height = 200;
</script>>

