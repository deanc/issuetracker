<h2><?= (isset($this->data['User']['user_id']) ? 'Edit' : 'Create'); ?> User</h2>

<?php

echo $form->create('User');
echo $form->hidden('User.user_id');
echo $form->input('User.email');
echo $form->input('User.username');
echo $form->input('User.password', array('value' => ''));
echo $form->input('User.admin');
echo $form->end('Save');

?>
