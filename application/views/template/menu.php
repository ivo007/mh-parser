
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Site map</li>
              <li><a href="<?php echo site_url(); ?>faq">F.A.Q.</a></li>
              <li><a href="<?php echo site_url(); ?>maps">Treasure Maps</a></li>
              <li><a href="<?php echo site_url(); ?>winter">Great Winter Hunt 2014</a></li>
              <li><a href="<?php echo site_url(); ?>haunted">Haunted Terrortories 2015</a></li>

              <?php if(logged_in()) { ?>
              <li class="nav-header">PARSER</li>
              <li><a href="<?php echo site_url(); ?>main/upload">Upload Hunters</a></li>
              <li><a href="<?php echo site_url(); ?>main/parser">Parse Data</a></li>
              <li><a href="#">...</a></li>
              <?php } ?>
            </ul>
            
          </div><!--/.well -->
		  
		  <?php if($page === 'common/maps') { ?>
		  
				<?php
				$text = "<h4><span style='color:red;'>COPY AND PASTE</span><br />treasure map mice here:</h4>";
				echo $this->formbuilder->open( 'maps', TRUE );
				echo $this->formbuilder->textarea( 'data', $text, null, array('rows' => 10, 'style' => 'border:2px solid red') );
				echo BR;
				echo $this->formbuilder->submit('submit', 'Go!', array('class' => 'btn btn-primary btn-large') );
				echo $this->formbuilder->close();
				echo BR;
				?>

		  <?php } ?>
          
          <div class="well well-small">
			<div id="paypal" style="text-align:center; color:gray;">
			
				<p>Did you like the page? Help us pay the hosting.</p>
			
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
				">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form> 
			</div>   
		</div>
		
		
		
		<?php
		if($page == 'common/haunted') {
			echo '<div class="well well-small">'.BN;
			echo $this->formbuilder->open( 'haunted', TRUE );
			echo $this->formbuilder->textarea( 'data', 'Copy remaining haunted treasure map mice here:', null, array('rows' => 15) );
			echo BR;
			echo $this->formbuilder->submit( 'submit', 'Go!' );
			echo $this->formbuilder->close();
			echo BR;
			echo '</div>'.BN;
		}
		else if($page == 'common/winter') {
			echo '<div class="well well-small">'.BN;
			echo $this->formbuilder->open( 'main/winter', TRUE );
			echo $this->formbuilder->textarea( 'data', 'Copy remaining Nice / Naughty map mice here:', null, array('rows' => 15) );
			echo BR;
			echo $this->formbuilder->submit( 'submit', 'Go!' );
			echo $this->formbuilder->close();
			echo BR;
			echo '</div>'.BN;
		}
			
		?>
		
		
          
        </div><!--/span-->