        <div class="span9">
          <div class="hero-unit">
            <h2><?php if(isset($title)) echo $title; // $title; ?></h2>
            <p>The list of haunted mice by sublocation and best charm</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            <?php if($count > 0 && $post) { ?>
            	<div id="num_msg" class="alert alert-success">Number of remaining mice: <b><span id="count"><?php echo $count; ?></span></b></div>
            <?php } ?>
            </p>
          </div>
          <div class="row-fluid">
          	<div class="span12">
			
				<div class="alert alert-info">Please see bottom of the page for Legend.</div>
          		
          		<hr />
          		
          		<table class="table table-striped">
          			<thead>
          				<tr>
          					<th>Mouse</th>
          					<th>Corn Maze</th>
          					<th>Haunted Manor</th>
          					<th>Pumpkin Patch</th>
          					<th>Cheese</th>
          				</tr>
          			</thead>
          			<tbody>
          		
	          		<?php
	          		$other = '<img src="'.images_url() . 'charms/ancient_small.gif' . '" title="any other charm" />';
	          		$extra = '<img src="'.images_url() . 'charms/extra_small.gif' . '" title="extra spooky charm" />';
	          		$spooky = '<img src="'.images_url() . 'charms/spooky_small.gif' . '" title="spooky charm" />';
	          		$candy = '<img src="'.images_url() . 'charms/candy_small.gif' . '" title="candy charm" />';
	          		$shortcut = '<img src="'.images_url() . 'charms/shortcut_small.gif' . '" title="shortcut charm" />';
	          		
	          		$any = '<img src="'.images_url() . 'cheese/gouda_small.gif' . '" title="standard cheese" />';
	          		$ccc = '<img src="'.images_url() . 'cheese/ccc_small.gif' . '" title="Cand Corn" />';
	          		$ggc = '<img src="'.images_url() . 'cheese/ggc_small.gif' . '" title="Ghoulgonzola" />';
	          		
	          		$exclamation = '<img src="'.images_url() . 'exclamation.png' . '" title="__TITLE__" />';
	          		
	          		foreach($haunted as $key => $data) {
	          			echo '<tr class="trcount">'.BN;
	          			
	          			//mouse
	          			echo '<td>'.$key.'</td>'.BN;
	          			
	          			
	          			//corn maze
	          			$cm = explode('|', $data[0]); $html = '';
	          			foreach($cm as $charm)
	          			{
	          				switch($charm) {
	          					case "other": $html .= $other; break;
	          					case "extra": $html .= $extra; break;
	          					case "candy": $html .= $candy; break;
	          					case "spooky": $html .= $spooky; break;
	          					case "shortcut": $html .= $shortcut; break;
	          					
	          					case "extra(S)":
	          					case "spooky(S)": $html .= str_replace("__TITLE__", "Only Standard Cheese with Spooky & Extra Charms!", $exclamation) ; break;
	          				}
	          			} 
	          			echo '<td>'.$html.'</td>'.BN;
	          			
	          			
	          			//haunted manor
	          			$cm = explode('|', $data[1]); $html = '';
	          			foreach($cm as $charm)
	          			{
	          				switch($charm) {
	          					case "other": $html .= $other; break;
	          					case "extra": $html .= $extra; break;
	          					case "candy": $html .= $candy; break;
	          					case "spooky": $html .= $spooky; break;
	          					case "shortcut": $html .= $shortcut; break;

	          					case "extra(S)":
	          					case "spooky(S)": $html .= str_replace("__TITLE__", "Only Standard Cheese with Spooky & Extra Charms!", $exclamation) ; break;
	          				}
	          			} 
	          			echo '<td>'.$html.'</td>'.BN;
	          			
	          			
	          			//pumpkin patch
	          			$cm = explode('|', $data[2]); $html = '';
	          			foreach($cm as $charm)
	          			{
	          				switch($charm) {
	          					case "other": $html .= $other; break;
	          					case "extra": $html .= $extra; break;
	          					case "candy": $html .= $candy; break;
	          					case "spooky": $html .= $spooky; break;
	          					case "shortcut": $html .= $shortcut; break;

	          					case "extra(S)":
	          					case "spooky(S)": $html .= str_replace("__TITLE__", "Only Standard Cheese with Spooky & Extra Charms!", $exclamation) ; break;
	          				}
	          			} 
	          			echo '<td>'.$html.'</td>'.BN;
	          			
	          			
	          			//cheese
	          			$cm = explode('|', $data[3]); $html = '';
	          			foreach($cm as $cheese)
	          			{
	          				switch($cheese) {
	          					case "ccc": $html .= $ccc; break;
	          					case "any": $html .= $any . $ccc . $ggc; break;
	          					case "ggc": $html .= $ggc; break;
	          				}
	          			}
	          			echo '<td><button type="button" class="close" data-dismiss="alert" title="remove after catch" >&times;</button>'.$html.'</td>'.BN;
	          			
	          			
	          			echo '</tr>'.BN;
	          			
	          		}
	
	          		?>
	          			
          			</tbody>
          		</table>
  
		 	 <hr />

          		<div class="row"><div class="span6"><h4>Charms</h4></div></div>
          		<div class="row">
          			<div class="span4">
          				<img src="<?php echo images_url() . 'charms/extra.gif'; ?>" />extra spooky charm
          			</div>
          			<div class="span4">
          				<img src="<?php echo images_url() . 'charms/spooky.gif'; ?>" />spooky charm
          			</div>
          			<div class="span4">
          				<img src="<?php echo images_url() . 'charms/ancient.gif'; ?>" />any other charm
          			</div>
          			<div class="span4">
          				<img src="<?php echo images_url() . 'charms/candy.gif'; ?>" />candy charm
          			</div>
          			<div class="span4">
          				<img src="<?php echo images_url() . 'charms/shortcut.gif'; ?>" />shortcut charm
          			</div>
          		</div>
          		
          		<hr />
          		
          		<div class="row"><div class="span6"><h4>Cheeses</h4></div></div>
          		<div class="row">
          			<div class="span4">
          				<img src="<?php echo images_url() . 'cheese/any.gif'; ?>" />Any standard cheese
          			</div>
          			<div class="span4">
          				<img src="<?php echo images_url() . 'cheese/ccc.gif'; ?>" />Cand Corn
          			</div>
          			<div class="span4">
          				<img src="<?php echo images_url() . 'cheese/ggc.gif'; ?>" />Ghoulgonzola
          			</div>
          		</div>
          		
          		<hr />
          		
          		<div class="row">
          			<div class="span12">
          				<ul>
          					<li>3 mice are not on the list: Trick, Treat and Bonbon Gummy Goblin</li>
          					<li>Data based on <?php echo anchor('http://mhwiki.hitgrab.com/wiki/index.php/Haunted_Terrortories', 'MH Wiki', array('target' => '_blank') ); ?> and <?php echo anchor('https://docs.google.com/spreadsheets/d/1RyL5Q4UGpa-PdwVXDR0jXLHXCiT_eF5XYuB0XWzPcPc/edit#gid=0', 'this sheet', array('target' => '_blank')); ?></li>
          					<li><img src="<?php echo images_url() . 'exclamation.png'; ?>" />Only standard cheese with spooky & extra charms</li>
          				</ul>
          			</div>
          		</div>
          		

		  
          	</div><?php //span12 ?>
          </div><?php //row-fluid ?>
          
        </div><?php //right content: span9 ?>
