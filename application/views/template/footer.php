	
	      </div><!--/row-->
      <hr>
      
    <div id="footer">
      <div class="container">
        <p class="muted credit" align="center">
			<?php echo "version ".SOFT_VER; ?><br />&copy; Tirova 2015
		</p>
      </div>
    </div>

    </div><!--/.fluid-container-->

    <!-- Javascript placed at the end of the document so the pages load faster -->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?php echo js_url()?>bootstrap.min.js"></script>
	
	<script type="text/javascript">
		var site_url = "<?php echo site_url(); ?>";
		var img_url = "<?php echo images_url(); ?>";
	</script>
	
	<?php $this->jquery_ext->output(); ?>
	
	<?php if(logged_in()) { ?>
	<script src="<?php echo js_url() . 'parser.js?'.SOFT_VER; ?>"></script>
	<?php } ?>
	
		<?php if($page == 'common/haunted' || $page == 'common/winter') { ?>
	<script src="<?php echo js_url() . 'haunted.js?'.SOFT_VER; ?>"></script>
	<?php } ?>
	
	<script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-786437-7']);
	  _gaq.push(['_setDomainName', 'tirova.net']);
	  _gaq.push(['_setAllowLinker', true]);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>

  </body>
</html>