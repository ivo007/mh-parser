<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>B.A.M.A. MouseHunt Parser</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo css_url()?>bootstrap.min.css" rel="stylesheet">
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
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo site_url(); ?>">B.A.M.A. MouseHunt Parser</a>
          <div class="nav-collapse collapse">
          	
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
   	<div class="container-fluid">
      <div class="row-fluid">
      
        <div class="span12">
          <div class="hero-unit">
            <h2><?php echo $heading; ?></h2>
            <p><?php echo $message; ?></p>
            
          </div>
      	</div><!--/span-->
	
	  </div><!--/row-->
      
      
    <div id="footer">
      <div class="container">
        <p class="muted credit" align="center">&copy; <a href="#">B.A.M.A.</a> 2012</p>
      </div>
    </div>

    </div><!--/.fluid-container-->


	
  </body>
</html>