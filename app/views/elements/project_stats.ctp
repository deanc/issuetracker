<div class="block">
<div id="project-stats">
	<h2>Project Stats</h2>
	<?php
	if(sizeof($stats) == 0) {
	?><p>No issues</p><?php
	}
	else
	{
		echo '<ul>';
		foreach($stats as $status)
		{
			echo '<li>' . $html->link($status['IssueStatus']['status'], '/issues/search?keywords=' . urlencode('status:"' . $status['IssueStatus']['status'] . '" project:' . $projectID)) . ' (' . $status[0]['total'] . ')</li>';
		}
		echo '</ul>';
	}
	?>
</div>
</div>
