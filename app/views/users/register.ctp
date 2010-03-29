<h2>Sign up to Hornii.com today!</h2>

<p><strong>Benefits of signing up for a FREE account on Hornii.com</strong></p>

<ul class="list1">
	<li>FREE - signing up doesn't cost you a penny</li>
	<li>You can comment on videos</li>
	<li>You can rate videos</li>
	<li>You can add videos to your favourites and come back and watch them at any time</li>
</ul>

<?php

if(sizeof($errors) > 0)
{
	echo '<p><strong>Errors</strong></p><ul class="list1">';
	foreach($errors as $error)
	{
		echo '<li>' . $error . '</li>';
	}
	echo '</ul>';
}

?>

<fieldset>
<form action="<?php echo $html->url('/users/register/'); ?>" method="post">
	<div>
		<label for="username">Username</label> <?php echo $form->text('User/username'); ?>
	</div>
	<div>
		<label for="username">Email</label> <?php echo $form->text('User/email'); ?>
	</div>
	<div>
		<label for="password">Password</label> <?php echo $form->password('User/password'); ?>
	</div>
	<div>
		<label for="password">Confirm Password</label> <?php echo $form->password('User/confirm_password'); ?>
	</div>
	<div>
		<?php echo $form->submit('Register!'); ?>
	</div>
</form>
</fieldset>