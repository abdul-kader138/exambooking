<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          EDIT BRANCH
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <?php if(isset($msg) || validation_errors() !== ''): ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <?= validation_errors();?>
                <?= isset($msg)? $msg: ''; ?>
            </div>
          <?php endif; ?>
          <?php echo form_open(base_url('admin/branches/branch_edit/'.md5($branch['id'])), 'class="form-horizontal"')?>
            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                    <label for="firstname">Branch Name</label>
                </div>
                <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="branch_name" name="branch_name" required value="<?= $branch['branch_name']; ?>" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                    <input type="submit" name="submit" value="UPDATE" class="btn btn-primary m-t-15 waves-effect">
                </div>
            </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<!-- Custom Js -->
<!--<script src="--><?//= base_url() ?><!--public/js/pages/forms/basic-form-elements.js"></script>-->

