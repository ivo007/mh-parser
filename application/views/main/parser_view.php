        <div class="span12">
          <div class="hero-unit">
            <h2><?php echo 'BAMA PARSER'; // $title; ?></h2>
            <p>20 vs 20 turnir</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            </p>
            
          </div>
          <div class="row-fluid" id="parser_container">
          	
          	<?php echo $table; ?>
          	          	            
          </div><!--/row-->
          
          <div class="row">
          	<div class="span3">&nbsp;</div>
          	<div class="span3">Parsing time: <?php echo $this->benchmark->elapsed_time();?> seconds</div>
          	<div class="span3">Current time: <?php echo date('r'); ?></div>
          </div>
          
        </div><!--/span-->
        