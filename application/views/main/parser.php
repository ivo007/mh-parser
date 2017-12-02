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
			<button id="run" class="btn btn-warning" type="button">Run parser!</button>
			<label for="save_start" id="the_label" style="display:inline-block;">
				<input type="checkbox" id="save_start" name="save_start" value="save" class="input_inline" />
				Save as start data
			</label>
            
			<div id="loading_display_holder">
				<div id="loading_display"></div>
			</div>
            
          </div><!--/row-->
        </div><!--/span-->
        

