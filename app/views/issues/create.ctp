<h2>Create Issue</h2>
<fieldset>

<?php
echo $html->css('/css/fcbkcomplete.css');
echo $javascript->link('/js/jquery.fcbkcomplete.js', false);
echo $javascript->link('/js/issues.js', false);


echo $form->create('Issue', array('url' => '/issues/create/' . $project_id)); 
echo $form->hidden('Issue.issue_id');
echo $form->input('Issue.title'); 
echo $form->input('Issue.content');
echo $form->hidden('user_id', array('value' => $user_id));
echo $form->hidden('project_id', array('value' => $project_id));
echo $form->input('Issue.status_id');
echo $form->input('Issue.priority_id');
echo $form->label('Assigned to:');
echo '<div class="select input">';
echo '<select id="IssueUsers" name="data[Users][Users][]">';
foreach($project_users AS $k => $v)
{
     echo '<option value="' . $k . '" class="selected">' . $v . '</option>';
}
echo '</select>';
echo '</div>';

echo $form->end('Save');
?>
</fieldset>
