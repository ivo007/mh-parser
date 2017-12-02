<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?php echo images_url(); ?>favicon.ico" type="image/x-icon">
    
	<!-- For third-generation iPad with high-resolution Retina display: -->
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo images_url(); ?>apple-touch-icon-144x144.png">
	<!-- For iPhone with high-resolution Retina display running iOS ? 7: -->
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo images_url(); ?>apple-touch-icon-120x120.png">
	<!-- For non-Retina iPhone and iPod Touch: -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo images_url(); ?>apple-touch-icon-57x57.png">
	<!-- For first- and second-generation iPad: -->
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo images_url(); ?>apple-touch-icon-72x72.png">
	<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
	<link rel="apple-touch-icon" href="<?php echo images_url(); ?>apple-touch-icon.png">
    
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo css_url()?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo css_url().'style.css'; ?>" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="<?php echo css_url()?>bootstrap-responsive.min.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
  
      <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
        
            <p class="navbar-text pull-right">
            	 <?php if( logged_in() ) { ?>
              <a href="<?php echo site_url() . 'main/logout'; ?>" title="<?php echo lang('logout'); ?>" class="navbar-link"><?php echo lang('logout') . ' ' . $this->session->userdata('user'); ?></a>
              	<?php } else { ?>
              <a href="<?php echo site_url() . 'main/login'; ?>" title="<?php echo lang('login'); ?>" class="navbar-link"><?php echo lang('login') ?></a>
              	<?php } ?>
            </p>
        
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo site_url(); ?>">B.A.M.A. MouseHunt Parser</a>
        </div>
      </div>
    </div>
    
   	<div class="container-fluid">
      <div class="row-fluid">