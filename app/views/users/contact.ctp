	  
		<p>We welcome all enquries from our visitors. From this form you can contact us about anything you like. We are always available to listen to your feedback on the site and ways we can improve it.</p>
		<p><strong>All fields are required</strong></p>


		<fieldset>
<form action="<?php echo $html->url('/contact'); ?>" method="post">
	<div>
		<label for="username">Your name</label> <?php echo $form->text('Contact/name'); ?>
	</div>
	<div>
		<label for="username">Email address</label> <?php echo $form->text('Contact/email'); ?>
	</div>
	<div>
		<label for="password">Message</label> <?php echo $form->textarea('Contact/details',array('rows' => 8, 'cols' => 70)); ?>
	</div>
	<div>
		<?php echo $form->submit('Send!'); ?>
	</div>
</form>
</fieldset>