        <div class="span9">
          <div class="hero-unit">
            <h2><?php echo 'HUNTERS DATA UPLOADER'; // $title; ?></h2>
            <p>Uploading of hunter names and links.</p>
            <p>
            </p>
            
          </div>
          <div class="row-fluid">
          
			<?php 
			if(!empty($msg['text'])) echo '<div class="alert alert-'.$msg['type'].'">'. $msg['text'] . '</div>';
			
			$fileOpts = array('size' => 80);
			echo $this->formbuilder->open( 'main/upload', TRUE, array('id' => 'uploadForm', 'class'=>'tourneyForm') );
			echo $this->formbuilder->file( 'hunters', lang('upload_text'), null, $fileOpts );
			echo BR;
			echo $this->formbuilder->submit( 'submit', lang('upload'), array('id' => 'submitUpload', 'class' => 'btn') );
			echo $this->formbuilder->close();
			echo BR;
			?>
            
          </div><!--/row-->
        </div><!--/span-->
        