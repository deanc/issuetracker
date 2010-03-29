<h2>Edit Issue</h2>
<fieldset>

<?php
echo $form->create('Issue'); 
echo $form->hidden('Issue.issue_id');
echo $form->input('Issue.title'); 
echo $form->input('Issue.content');
echo $form->hidden('user_id', array('value' => $user_id));
echo $form->input('Issue.status_id');
echo $form->end('Save');
?>
</fieldset>