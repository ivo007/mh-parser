        <div class="span12">
          <div class="hero-unit">
            <h2><?php echo 'BAMA PARSER'; // $title; ?></h2>
            <p>Main parsing area. Click the title top left to return to home page.</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            </p>
            
          </div>
          
          <div class="row-fluid" id="parser_container">
          
			<div class="text-error"><?php if(isset($error)) echo $error; ?></div>

			<?php echo $pagination . $table. $pagination; ?>

			<div id="snuids" style="visibility:hidden"><?php echo $snuids; ?></div>
			<button id="run" class="btn btn-warning" type="button" onclick="window.location.reload()">RELOAD!</button>
            
			<div id="loading_display_holder">
				<div id="loading_display"></div>
			</div>
			
          </div><!--/row-->
          
          <div class="row-fluid">
	      	<div class="span4"><b>Parsing time: <?php echo $this->benchmark->elapsed_time();?> seconds</b></div>
    	  </div>
        </div><!--/span-->
        

