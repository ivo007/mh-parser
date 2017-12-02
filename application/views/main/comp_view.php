        <div class="span12">
          <div class="hero-unit">
            <h2><?php echo 'BAMA PARSER'; // $title; ?></h2>
            <p>20 vs 20 turnir</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            </p>
            
          </div>
          <div class="row-fluid" id="parser_container">
          	
          	<div class="span6">
          		<p style="text-align:center;"><a class="btn btn-primary btn-large" href="<?php echo site_url() . 'comp/horns'; ?>" target="_blank">Horn Calls</a></p>
          		<?php /* ?><p style="text-align:center;"><button class="btn btn-primary btn-large" id="horn_calls">Horn Calls</button></p><?php */ ?>
          		<div id="horns_output"></div>
          	</div>
          	
          	<div class="span6">
          		<p style="text-align:center;"><a class="btn btn-primary btn-large" href="<?php echo site_url() . 'comp/mice'; ?>" target="_blank">Mice Parser</a></p>
          	</div>
          	          	            
          </div><!--/row-->
        </div><!--/span-->
        