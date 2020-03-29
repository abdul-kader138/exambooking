<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <title><?=isset($title)?$title:'Exam Booking' ?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?= base_url() ?>public/favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="<?= base_url() ?>public/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?= base_url() ?>public/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="<?= base_url() ?>public/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Materialize Css -->
    <link href="<?= base_url() ?>public/css/materialize.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?= base_url() ?>public/css/login-style.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/css/style.css" rel="stylesheet">
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> 
</head>

<body class="login-page <?=isset($bodyClass)?$bodyClass:'' ?>">

    <!--begin header -->
    <header class="header">

        <!--begin nav -->
        <nav class="navbar navbar-default navbar-fixed-top">
            
            <!--begin container -->
            <div class="container">
        
                <!--begin navbar -->
                <div class="navbar-header">

                    <button data-target="#navbar-collapse-02" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                        
                    <!--logo -->
                    <a href="/exambooking/" class="navbar-brand" id="logo"><img src="<?= base_url() ?>public/images/logo-trinity.jpg" width="155" height="47" alt=""/> Exam Booking</a>

                </div>
                        
                <div id="navbar-collapse-02" class="collapse navbar-collapse">

                    <ul class="nav navbar-nav navbar-right topRightBtn">
                        <?php if ($loginBtn=='yes') { ?>
                        <li><a href="<?= base_url() ?>auth/login" class="discover-btn2">Login</a></li>
                        <?php } else { ?>
                        <li><a href="<?= base_url() ?>auth/register" class="discover-btn">Register</a></li>
                        <?php } ?>
                    </ul>
                    <a href="https://www.mindyourapp.com.my/trinity/" class="backTo">&raquo;	Trinity Malaysia</a>
                </div>
                <!--end navbar -->
                                    
            </div>
    		<!--end container -->
            
        </nav>
    	<!--end nav -->
        
    </header>
    <!--end header -->
    
    <!--begin title -->
    <section class="section-dark">
        
        <!--begin container-->
        <div class="container">
    
            <!--begin row-->
            <div class="row">
            
                <!--begin col-md-10 -->
				<div class="col-md-12">

					<h2 class="section-title white"><?=isset($pageTitle)?$pageTitle:'' ?></h2>

					<p class="section-subtitle white"><?=isset($subTitle)?$subTitle:'' ?></p>
					
				</div>
				<!--end col-md-10 -->

            </div>
            <!--end row-->
            
      </div>
      <!--end container-->
            
    </section>
    <!--end title-->