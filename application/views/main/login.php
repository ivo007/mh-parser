<div class="span9">
	<div class="text-error"><?php if(isset($error)) echo $error; ?></div>
	<br />
	<?php
	echo $this->formbuilder->open( 'main/login', FALSE, array('id' => 'loginForm', 'class'=>'tourneyForm') );
	echo $this->formbuilder->text( 'user_name', lang('name'), array('class' => 'login_label') );
	echo $this->formbuilder->password( 'user_pass', lang('password'), array('class' => 'login_label') );
	echo BR;
	echo $this->formbuilder->submit( 'submit', lang('login'), array('id' => 'submitLogin', 'class' => 'btn') );
	echo $this->formbuilder->close();
	echo BR;
	?>
</div>
