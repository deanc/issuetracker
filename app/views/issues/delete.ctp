<h2>Delete Issue</h2>

<p>Are you sure you wish to delete this issue. The action is not reversible.</p>

<?php

echo $form->create('Issue');
echo $form->hidden('Issue.issue_id');
echo $form->hidden('Issue.project_id');
echo $form->end('Submit');

?>
