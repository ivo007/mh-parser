        <div class="span12">
          <div class="hero-unit">
            <h2><?php echo 'BAMA PARSER'; // $title; ?></h2>
            <p>UBOTS</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            </p>
            
          </div>
          <div class="row-fluid" id="parser_container">
          
          <div class="span6">
          	
	          	<table class="table table-stripped">
	          		<thead>
	          			<tr>
	          				<th>Name</th>
	          				<th>Horn Calls</th>
	          				<th>Mice Caught</th>
	          				<th>Title</th>
	          			</tr>
	          		</thead>
	          		
	          		<tbody>
	          	
	          	<?php if(isset($horns)) {
	          		foreach($horns as $h) {
	          			echo "<tr>";
	          			echo "<td>". $h['name'] ."</td><td>".$h['horn_calls']."</td><td>".$h['mice_caught']."</td><td>".$h['title']."</td>";
	          			echo "</tr>"; 
	          		} 
	          	}?>
	          		</tbody>
	          	</table>
          	
          	</div>
          	          	            
          </div><!--/row-->
        </div><!--/span-->
        