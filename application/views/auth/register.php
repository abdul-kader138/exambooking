    <div class="login-box">
        <?php if(isset($msg) || validation_errors() !== ''): ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa-warning"></i> Alert!</h4>
                <?= validation_errors();?>
                <?= isset($msg)? $msg: ''; ?>
            </div>
        <?php endif; ?> 
        <div class="card regPage">
            <div class="body">
                <?php echo form_open(base_url('auth/register'), 'class="login-form" '); ?>
                    <div class="msg">Create a Account</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="firstname" placeholder="First Name" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="lastname" placeholder="Last Name" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="email" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                        </div>
                    </div>
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">view_module</i>
                        </span>
                    <div class="form-line">
                        <select class="form-control show-tick" id="branch" name="branch" required>
                            <option value="">-- Please select Branch--</option>
                            <?php foreach($branches as $branch): ?>
                                <option value="<?= $branch['id']; ?>"><?= $branch['branch_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                    <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                        <label for="terms">I read and agree to the <a href="/exambooking/auth/terms_conditions" target="_blank">Terms & Conditions</a>.</label>
                    </div>
                    <?php if($this->recaptcha->_status): ?>
                    <div class="form-group">
                        <?= $this->recaptcha->getWidget(); ?>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="submit" name="submit" id="submit" class="btn btn-block btn-success waves-effect" value="Register">
                        </div>
                    </div>
                    <div class="m-t-25 align-center">
                        <a href="<?= base_url('auth/login'); ?>">You already have a account?</a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>