        <div class="span9">
          <div class="hero-unit">
            <h2><?php echo 'Welcome to B.A.M.A. statistics page!'; // $title; ?></h2>
            <p>This is an advanced data mining page for popular Facebook game called Mousehunt. It is being developed by B.A.M.A. Facebook group. If your group's statistic page is not set to public by group admins, please contact them for correct credentials. For any additional information or contact please read our FAQ page.</p>
            <p>
            <?php if(isset($msg)) echo $msg; ?>
            </p>
            
          </div>
          <div class="row-fluid">
          
          <?php if(isset($data)) dump($data); else { /* ?>
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            
            <?php */ } ?>
            
          </div><!--/row-->
        </div><!--/span-->
        