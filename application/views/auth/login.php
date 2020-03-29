    <!--begin home section -->
    <section class="home-section" id="home_wrapper">

		<!--begin container -->
		<div class="container">

	        <!--begin row -->
	        <div class="row">
	          
	            <!--begin col-md-7-->
	            <div class="col-md-6">

	          		    <div class="login-box">
                            <?php if(isset($msg) || validation_errors() !== ''): ?>
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                                    <?= validation_errors();?>
                                    <?= isset($msg)? $msg: ''; ?>
                                </div>
                            <?php endif; ?>
                            <?php if($this->session->flashdata('warning')): ?>
                                 <div class="alert alert-warning">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                  <?=$this->session->flashdata('warning')?>
                                </div>
                            <?php endif; ?>
                            <?php if($this->session->flashdata('success')): ?>
                                  <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                    <?=$this->session->flashdata('success')?>
                                  </div>
                            <?php endif; ?>
                            <div class="card">
                                <div class="body">
                                    <?php echo form_open(base_url('auth/login'), 'class="login-form" '); ?>
                                        <div class="msg">Login here for our online services for exams</div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
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
                                        <div class="row">
                                            <div class="col-xs-7">
                                                <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                                                <label for="rememberme">Remember Me</label>
                                            </div>
                                            <div class="col-xs-5 text-right">
                                                <input type="submit" name="submit" id="submit" class="btn btn-block btn-success waves-effect" value="Login">
                                                
                                            </div>
                                        </div>

                                        <?php if($this->recaptcha->_status): ?>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?= $this->recaptcha->getWidget(); ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <div class="row" style="padding-top:30px">
                                            <div class="col-xs-12">
                                                <a  href="<?= base_url('auth/forgot_password'); ?>">Forgot password?</a>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

	            </div>
	            <!--end col-md-6-->
	       
				<!--begin col-md-6-->
	            <div class="col-md-6">

	          		<!--begin register-form-wrapper-->
	          		<div class="register-form-wrapper">

		          		<h3>Register Now!</h3>

	                    <!--begin form-->
	                    <div>
	                         
	                        <!--begin success message -->
	                        <p>Not a member yet! Register here to book exams.</p>
	                        <!--end success message -->
	                        
	                        <!--begin register button -->
                            <a class="btnReg" href="<?= base_url() ?>auth/register" role="button">Click Here</a>
	                        <!--end register button -->
	                        
	                    </div>
	                    <!--end form-->

                    </div>
                    <!--end register-form-wrapper-->

	            </div>
	            <!--end col-md-5-->

	        </div>
	        <!--end row -->

		</div>
		<!--end container -->

    </section>
    <!--end home section -->