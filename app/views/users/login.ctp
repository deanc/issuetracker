<h2>Login</h2>

<fieldset>
<form action="<?php echo $html->url('/users/login/'); ?>" method="post">
	<div>
		<label for="username">Email</label> <?php echo $form->text('User.email'); ?>
	</div>
	<div>
		<label for="password">Password</label> <?php echo $form->password('User.password'); ?>
	</div>
	<div>
		<?php echo $form->submit('Login'); ?>
	</div>
</form>
</fieldset>