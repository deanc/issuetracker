<h2><?= (isset($this->data['Project']['project_id']) ? 'Edit' : 'Create'); ?> Project</h2>

<?php

echo $html->css('/css/fcbkcomplete.css');
echo $javascript->link('/js/jquery.fcbkcomplete.js', false);
echo $javascript->link('/js/projects.js', false);

echo $form->create('Project');
echo $form->hidden('Project.project_id');
echo $form->input('Project.name');
echo $form->input('Project.public');


echo '<div class="text input">';
echo $form->label('Project Users');
echo '<select id="ProjectUsers" name="data[Users][]">';
foreach($users AS $id => $name)
{
	echo '<option value="' . $id . '" class="selected">' . $name . '</option>';
}
echo '</select>';
echo '</div>';

echo $form->end('Save');

?>
