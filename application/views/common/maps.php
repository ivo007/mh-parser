        <div class="span9">
          <div class="hero-unit">
            <h2><?php if($title) echo strtoupper($title); else echo 'TREASURE MAP MICE LOCATOR'; ?></h2>
            <p>Order Treasure Map Mice by Location</p>
            <p>
            <?php if(isset($count) && $count > 0) { ?>
            	<div id="num_msg" class="alert alert-success">Number of remaining mice: <b><span id="count"><?php echo $count; ?></span></b></div>
            <?php } ?>
            <?php if(isset($error_msg)) { ?>
            	<div id="error_msg" class="alert alert-danger"><?php echo $error_msg; ?></div>
            <?php } ?>
            </p>
          </div>
          
          <div class="row-fluid">
			
			<div class="span3">
				<?php 
				if(isset($left)) {
					echo '<div class="alert alert-info"><b>'.$left_name.'</b></div>';
					foreach($left as $area => $mice) {
						echo '<div class="area_div">';
						echo "<b>$area</b>".BR;
						
						foreach($mice as $mouse) {
							echo '<div class="mouse" data-id="'.$mouse.'"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$mouse.'</div>';
						}
						echo BR;
						echo '</div>';
					}
				}
				?>
			</div>
			
			<?php if(isset($middle)) { ?>
			<div class="span3">
			<?php 	
				echo '<div class="alert alert-warning"><b>'.$middle_name.'</b></div>';
				foreach($middle as $area => $mice) {
					echo '<div class="area_div">';
					echo "<b>$area</b>".BR;
					
					foreach($mice as $mouse) {
						echo '<div class="mouse" data-id="'.$mouse.'"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$mouse.'</div>';
					}
					echo BR;
					echo '</div>';
				}
			?>
			</div>
			<?php } ?>
			
			<div class="span3">
				<?php 
				if(isset($right)) {
					echo '<div class="alert alert-danger"><b>'.$right_name.'</b></div>';
					foreach($right as $area => $mice) {
						echo '<div class="area_div">';
						echo "<b>$area</b>".BR;
						
						foreach($mice as $mouse) {
							echo '<div class="mouse" data-id="'.$mouse.'"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$mouse.'</div>';
						}
						echo BR;
						echo '</div>';
					}
				}
				?>
			</div>
			
          </div><!--/row-->
          
        <?php if(isset($msg)): ?>
		<div class="row-fluid">
			<hr>
			<div class="span9"><p><i><small><?php echo $msg; ?></small></i></p></div>
        </div>
        <?php endif; ?>
        
         <?php if(isset($supported_maps)): ?>
		<div class="row-fluid">
			<hr>
			<div class="span9">
				Currently supported Treasure Maps:
				<ul>
					<?php foreach ($supported_maps as $mapName): ?>
					<li><?php echo $mapName; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
        </div>
        <?php endif; ?>
        
          <?php if(isset($special_msg)) { ?>
           <div class="row-fluid">
           	<hr />
           	<div class="span9"><p><?php echo $special_msg; ?></p></div>
           </div>
           <?php } ?>
          
        </div><!--/span-->
