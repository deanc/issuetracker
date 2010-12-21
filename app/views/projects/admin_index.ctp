<table>
	<thead>
<?php
echo $this->Html->tableHeaders(array('Name', 'Public?', 'Users', 'Options'));
?>
	</thead>
	<tbody>
<?php
foreach($projects AS $project)
{
	echo '<tr>';
	echo '<td>' . $project['Project']['name'] . '</td>';
	echo '<td>' . ($project['Project']['public'] ? 'Yes' : 'No') . '</td>';
	echo '<td>' . sizeof($project['User']) . '</td>';
	echo '<td>' . $html->link('Edit', '/admin/projects/edit/' . $project['Project']['project_id']) . '</td>';
	echo '</tr>';
}
?>
	</tbody>
</table>
