<div class="block">
<div id="project-users">
	<h2>Project Users</h2>
	<?php
	if(sizeof($users) == 0) {
	?><p>No users on this project</p><?php
	}
	else
	{
		echo '<ul>';
		foreach($users as $user)
		{
			echo '<li>' . $html->link($user['User']['username'], '/user/' . $user['User']['username']) . '</li>';
		}
		echo '</ul>';
	}
	?>
</div>
</div>
