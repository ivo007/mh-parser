        <div class="span9">
          <div class="hero-unit">
            <h2><?php echo 'LIVING GARDEN AREA MICE LOCATOR'; // $title; ?></h2>
            <p>Order LG Treasure Map Mice by Location</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            <?php if($count > 0) { ?>
            	<div id="num_msg" class="alert alert-success">Number of remaining mice: <b><span id="count"><?php echo $count; ?></span></b></div>
            <?php } ?>
            </p>
          </div>
          <div class="row-fluid">
			<div class="span3">
				<?php
				echo $this->formbuilder->open( 'main/lgmaps', TRUE );
				echo $this->formbuilder->textarea( 'data', 'Copy and paste ', null, array('rows' => 20) );
				echo BR;
				echo $this->formbuilder->submit( 'submit', 'Go!' );
				echo $this->formbuilder->close();
				echo BR;
				?>
			</div>
			
			<div class="span3">
				<?php 
				if(isset($normal)) {
					echo '<div class="alert alert-info"><b>NORMAL WORLD</b></div>';
					foreach($normal as $area => $mice) {
						echo '<div class="area_div">';
						echo "<b>$area</b>".BR;
						foreach($mice as $mouse) {
							echo '<div class="mouse"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$mouse.'</div>';
						}
						echo BR.BR;
						echo '</div>';
					}
				}
				?>
			</div>
			
			<div class="span3">
				<?php 
				if(isset($twisted)) {
					echo '<div class="alert"><b>TWISTED WORLD</b></div>';
					foreach($twisted as $area => $mice) {
						echo '<div class="area_div">';
						echo "<b>$area</b>".BR;
						foreach($mice as $mouse) {
							echo '<div class="mouse"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$mouse.'</div>';
						}
						echo BR.BR;
						echo '</div>';
					}
				}
				?>
			</div>
          </div><!--/row-->
          
          <div class="row-fluid">
          	<div class="span9">
          		<img src="<?php echo images_url() . 'lg-summary.png'; ?>" class="img-polaroid" />
          		<a href="http://mousehuntgameguide.com/the-living-garden-walkthrough/" target="_blank">Image &copy; The Ultimate Guide to Mousehunt</a> 
          	</div>
          </div>
          
        </div><!--/span-->
