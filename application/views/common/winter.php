        <div class="span9">
          <div class="hero-unit">
            <h2><?php if(isset($title)) echo $title; // $title; ?></h2>
            <p>The list of GWH mice sorted by cheese and charm</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            <?php if($count > 0 && $post) { ?>
            	<div id="num_msg" class="alert alert-success">Number of remaining mice: <b><span id="count"><?php echo $count; ?></span></b></div>
            <?php } ?>
            </p>
          </div>
          
          <div class="row-fluid">
          	<div class="span12">
			
				<div class="alert alert-info"><b>Note:</b> Please see bottom of the page for <a href="#legend"><b>Legend, Notes and Credits</b></a>.</div>
          		
          		<hr />
          		
          		<table class="table table-striped">
          			<thead>
          				<tr>
          					<th>Mouse</th>
          					<th style="text-align:center">Standard Cheese</th>
          					<th style="text-align:center">Gingerbread /<br />Seasoned Gouda</th>
          					<th style="text-align:center">Festive Feta /<br />Snowball Bocconcini</th>
          					<th style="text-align:center">Arctic Asiago</th>
          				</tr>
          			</thead>
          			<tbody>
          		
	          		<?php
	          		$other = '<img src="'.images_url() . 'charms/ancient_small.gif' . '" />';
	          		$tower = '<img src="'.images_url() . 'fort_tower_lvl1.png' . '" title="Requires Ice Tower" />';
	          		$sb = '<img src="'.images_url() . 'cheese/sb.gif' . '" title="SUPER|brie+ Only" width="30px" height="30px" />';
	          		$nocharm = '<img src="'.images_url() . 'nocharm.gif' . '" title="Avoids Charms" width="16px" height="16px" />';
	          		$hoarder = '<img src="'.images_url() . 'charms/hoarder.gif' . '" title="Requires Hoarder Charm" width="30px" height="30px" />';
	          		$winterImg = '<img src="'.images_url() . 'charms/winter.gif' . '" title="Requires Winter Charm" width="30px" height="30px" />';
	          		$warning = '<img src="'.images_url() . 'exclamation.png' . '" title="not present once the number of Tower Slabs required to build the Ice Tower has been reached" />';
	          		$ok = '<img src="'.images_url() . 'ok.png' . '" />';
	          		
	          		foreach($winter as $key => $data) {
	          			echo '<tr class="trcount">'.BN;
	          			
	          			//mouse
	          			echo '<td>'.$key.'</td>'.BN;
	          			
	          			//Standard Cheese
	          			$cm = explode('|', $data[0]); $html = '';
	          			foreach($cm as $charm)
	          			{
	          				switch($charm) {
	          					case "ok": $html .= $ok; break;
	          					case "sb": $html .= $sb; break;
	          					case "winter": $html .= $winterImg; break;
	          					case "hoarder": $html .= $hoarder; break;
	          					case "nocharm": $html .= $nocharm; break;
	          				}
	          			} 
	          			echo '<td style="text-align:center">'.$html.'</td>'.BN;
	          			
	          			//Gingerbread / Seasoned Gouda
	          			$cm = explode('|', $data[1]); $html = '';
	          			foreach($cm as $charm)
	          			{
	          				switch($charm) {
	          					case "ok": $html .= $ok; break;
	          					case "winter": $html .= $winterImg; break;
	          					case "hoarder": $html .= $hoarder; break;
	          					case "nocharm": $html .= $nocharm; break;
	          				}
	          			} 
	          			echo '<td style="text-align:center">'.$html.'</td>'.BN;
	          			
	          			//Festive Feta / Snowball Bocconcini
	          			$cm = explode('|', $data[2]); $html = '';
	          			foreach($cm as $charm)
	          			{
	          				switch($charm) {
	          					case "ok": $html .= $ok; break;
	          					case "winter": $html .= $winterImg; break;
	          					case "hoarder": $html .= $hoarder; break;
	          					case "nocharm": $html .= $nocharm; break;
	          				}
	          			}
	          			echo '<td style="text-align:center">'.$html.'</td>'.BN;
	          			
	          			//Arctic Asiago
	          			$cm = explode('|', $data[3]); $html = '';
	          			foreach($cm as $charm)
	          			{
	          				switch($charm) {
	          					case "ok": $html .= $ok; break;
	          					case "!": $html .= $warning; break;
	          					case "tower": $html .= $tower; break;
	          					case "winter": $html .= $winterImg; break;
	          					case "hoarder": $html .= $hoarder; break;
	          					case "nocharm": $html .= $nocharm; break;
	          				}
	          			}
	          			echo '<td style="text-align:center"><button type="button" class="close" data-dismiss="alert" title="remove after catch" >&times;</button>'.$html.'</td>'.BN;
	          			
	          			echo '</tr>'.BN;
	          			
	          		}
	
	          		?>
	          			
          			</tbody>
          		</table>
          	</div>
          </div><!--/row-->
		  
		  <hr />
		  
		  <div class="row-fluid">
			<div class="span12" id="legend">
			
          		<h3>Legend</h3>
          		
				<table class="table">
					<tr>
						<td width="50px"><img src="<?php echo images_url() . 'charms/hoarder.gif'; ?>" /></td>
						<td style="vertical-align:middle">hoarder charm</td>
					</tr>
					<tr>
						<td width="50px"><img src="<?php echo images_url() . 'charms/winter.gif'; ?>" /></td>
						<td style="vertical-align:middle">winter charm</td>
					</tr>
					<tr>
						<td width="50px"><img src="<?php echo images_url() . 'cheese/sb.gif'; ?>" /></td>
						<td style="vertical-align:middle">Can be caught only with SUPER|brie+</td>
					</tr>
					<tr>
						<td width="50px"><img src="<?php echo images_url() . 'fort_tower_lvl1_big.png'; ?>" /></td>
						<td style="vertical-align:middle">Requires Ice Tower</td>
					</tr>
					<tr>
						<td width="50px"><img src="<?php echo images_url() . 'exclamation.png'; ?>" /></td>
						<td style="vertical-align:middle">The Frigid Foreman Mouse is not present once the number of Tower Slabs required to build the Ice Tower has been reached.</td>
					</tr>
					<tr>
						<td width="50px"><img src="<?php echo images_url() . 'nocharm.gif'; ?>" /></td>
						<td style="vertical-align:middle">The Mice of Winter Past, Present, and Future avoid traps armed with Winter Hoarder or Winter charms.</td>
					</tr>
					
				</table>
          		
          		<br />
			
				<!-- 
          		<div>
				
				<p><b>Notes:</b></p>
				<ul>
					<li>
						the list is not 100% accurate. It is the visual helper for <a href="https://spreadsheets.google.com/spreadsheet/pub?key=0An8esHSXteUJdElKM1c4eWpmRjJYWnRKenBrT0l1UWc&gid=20" target="_blank">tehhowch's spreadsheet</a>.
					</li>
					<li>
					Three mice aren't on the list: Trick, Treat and Titanic Brain-Taker (this year's boss) because they only come at the end of the Pumpkin Patch.
					</li>
					<li><b>Charm icons are ordered by Catch Rate for each mouse</b>, so first charm is better.</li>
					<li>If some charm is not present it means that CR is very low according to HornTracker, but it still might be possible to catch the mouse.</li>
					<li>only CCC & GCC are taken into account. For detailed statistics please visit the spreadsheet mentioned above.</li>
				</ul>
          		</div>
          		-->
			
			</div>
		  </div>
          
        </div><!--/span-->
