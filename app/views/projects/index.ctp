<h2>Viewing all projects</h2>

<ul class="projects">
<?php

foreach($projects AS $project)
{
	$new = $this->element('isnew', array('project' => $project['Project']));
    echo '<li><span style="float: right">(Open: <span style="color: #458B00; font-weight: bold">' . $project['Project']['total_issues'] . ')</span></span> ' . $html->link($project['Project']['name'] . $new, '/projects/' . $project['Project']['project_id'] . '/issues', array('escape' => false)) .  '</li>';
}
?>
</ul>
