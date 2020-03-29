        <div class="login-box">

        <?php if($this->session->flashdata('success')): ?>
              <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <?=$this->session->flashdata('success')?>
              </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('warning')): ?>
             <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <?=$this->session->flashdata('warning')?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
             <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <?=$this->session->flashdata('error')?>
            </div>
        <?php endif; ?>
        <?php if( validation_errors() !== ''): ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <?= validation_errors();?>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="body">
                <?php echo form_open(base_url('auth/forgot-password'), 'class="login-form" '); ?>
                    <div class="msg">Enter your email and we will send you instructions on how to reset your password</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="email" required autofocus>
                        </div>
                    </div>
                    
                     <?php if($this->recaptcha->_status): ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <?= $this->recaptcha->getWidget(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="submit" name="submit" id="submit" class="btn btn-block btn-success waves-effect" value="Recover Password">
                        </div>
                    </div>
                    <div class="m-t-25 align-center">
                        <a href="<?= base_url('auth/login'); ?>">You remember Password? Sign In </a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>