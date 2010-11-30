<h2>Projects</h2>

<ul class="projects">
<?php

foreach($projects AS $project)
{
    echo '<li>' . $html->link($project['Project']['name'], '/projects/' . $project['Project']['project_id'] . '/issues') . '</li>';
}
?>
</ul>
