<h2>Viewing all projects</h2>

<ul class="projects">
<?php

foreach($projects AS $project)
{
	$new = $this->element('isnew', array('project' => $project['Project']));
    echo '<li><span style="float: right">(' . $project['Project']['total_issues'] . ')</span> ' . $html->link($project['Project']['name'] . $new, '/projects/' . $project['Project']['project_id'] . '/issues', array('escape' => false)) .  '</li>';
}
?>
</ul>
