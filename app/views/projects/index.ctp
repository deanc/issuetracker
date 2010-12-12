<h2>Projects</h2>

<ul class="projects">
<?php

foreach($projects AS $project)
{
  $new = '';
  	if(strtotime($user['User']['lastactivity'])-600 < strtotime($project['Project']['lastactivity']))
	{
		$new = '<span class="new">New!</span>';
	}

    echo '<li><span style="float: right">(' . $project['Project']['total_issues'] . ')</span> ' . $html->link($project['Project']['name'], '/projects/' . $project['Project']['project_id'] . '/issues') . $new . '</li>';
}
?>
</ul>
