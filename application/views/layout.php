<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
    	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<title><?=isset($title)?$title.' -'.$this->general_settings['application_name']: $this->general_settings['application_name'] ?></title>
		<!-- Favicon-->
	    <link rel="icon" href="<?= base_url($this->general_settings['favicon'])?>" type="image/x-icon">
	    <!-- Google Fonts -->
	    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
		<!-- Bootstrap Core Css -->
    	<link href="<?= base_url() ?>public/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
		<!-- Waves Effect Css -->
    	<link href="<?= base_url() ?>public/plugins/node-waves/waves.css" rel="stylesheet" />
		<!-- Animation Css -->
    	<link href="<?= base_url() ?>public/plugins/animate-css/animate.css" rel="stylesheet" />
	    <!-- Morris Chart Css-->
    	<link href="<?= base_url() ?>public/plugins/morrisjs/morris.css" rel="stylesheet" />
	    <!-- Custom Css -->
	    <link href="<?= base_url() ?>public/css/style.css" rel="stylesheet">
	    <!-- Materialize Css -->
	    <link href="<?= base_url() ?>public/css/materialize.css" rel="stylesheet">
	    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
	    <link href="<?= base_url() ?>public/css/themes/all-themes.css" rel="stylesheet" />
        <!-- Google reCaptcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	    <!-- Jquery Core Js -->
    	<script src="<?= base_url() ?>public/plugins/jquery/jquery.min.js"></script>
	</head>

	<body class="theme-red">
 
    <!-- #END# Page Loader -->
	
	<!-- top navbar -->
	<?php include('include/navbar.php'); ?>	
	<!-- end top navbar -->
	
	<section>
		<!--left sidebar start-->
		<?php if($this->session->userdata('is_admin_login')): ?>
			<?php include('include/sidebar.php'); ?>
		<?php else: ?>
			<?php include('include/user_sidebar.php'); ?>
		<?php endif; ?>
		<!--left sidebar end-->

		<!--right sidebar start-->
		<?php include('include/right_sidebar.php'); ?>
		<!--right sidebar end-->
	</section>
	
	<!--main content-->
	<section class="content">
		<?php if($this->session->flashdata('msg') != ''): ?>
		    <div class="alert alert-success flash-msg alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		      <h4> Success!</h4>
		      <?= $this->session->flashdata('msg'); ?> 
		    </div>
		<?php endif; ?> 

		<?php if($this->session->flashdata('error') != ''): ?>
		    <div class="alert alert-danger alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		      <h4> Error!</h4>
		      <?= $this->session->flashdata('error'); ?> 
		    </div>
		<?php endif; ?> 
		<!-- main content start-->
		<?php $this->load->view($view);?>
		<!-- end-->		
	</section>
	<!--end main content-->
    
    <!-- Bootstrap Core Js -->
    <script src="<?= base_url()?>public/plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Select Plugin Js -->
    <script src="<?= base_url()?>public/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?= base_url()?>public/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?= base_url()?>public/plugins/node-waves/waves.js"></script>
    <!-- Custom Js -->
    <script src="<?= base_url()?>public/js/admin.js"></script>
    <!-- Demo Js -->
    <script src="<?= base_url()?>public/js/demo.js"></script>
	<!-- page script -->
	<script type="text/javascript">
	  $(".flash-msg").fadeTo(2000, 500).slideUp(500, function(){
	    $(".flash-msg").slideUp(500);
	});
	</script>
</body>
</html>