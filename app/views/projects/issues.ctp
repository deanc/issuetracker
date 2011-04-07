<div class="clearfix">
<div id="leftcol">

<h2>Viewing all issues for "<?php echo $project['Project']['name']; ?>" (<?php echo sizeof($issues); ?>)</h2>

<?php

		$this->Paginator->options(array(
		    'update' => '#center',
		    'evalScripts' => true			
		));
		
		if(sizeof($issues) > 0) {
	
?>

<p class="pagenav">Page 
<!-- Shows the page numbers -->
<?php echo $paginator->numbers(); ?>
<!-- Shows the next and previous links -->
<?php
	echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
	echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
?> 
<!-- prints X of Y, where X is current page and Y is number of pages -->
<?php //echo $paginator->counter(); ?>
</p>

	<table id="issues-list">
		<thead>
	<tr> 
		<th class="title"><?php echo $paginator->sort('Title', 'title'); ?></th> 
		<th class="user">Author</th>
		<th class="priority"><?php echo $paginator->sort('Priority', 'IssuePriority.priority'); ?></th>
		<th class="comments"><?php echo $paginator->sort('Comments', 'Issue.comments'); ?></th>
		<th class="updated"><?php echo $paginator->sort('Last Updated', 'updated'); ?></th>	 
	</tr>
		</thead>
		<tbody>
		
		<?php
foreach($issues as $issue)		
{
	if(strlen($issue['Issue']['title']) > 40)
	{
		$issue['Issue']['title'] = substr($issue['Issue']['title'],0, 40) . '...';
	}

	$new = $this->element('isnew', array('issue' => $issue['Issue']));
	echo '<tr class="' . strtolower($issue['IssueStatus']['status']) . '">';
	echo '<td class="title">' . $html->link($issue['Issue']['title'], '/projects/' . $issue['Issue']['project_id'] . '/issue/' . $issue['Issue']['issue_id']) . $new . '</td>';
	echo '<td class="user">' . $issue['User']['username'] . '</td>';
	echo '<td class="priority">' . $this->element('priorityhighlight', array('hex' => $issue['IssuePriority']['hex'], 'priority' => $issue['IssuePriority']['priority'])) . '</td>';
	echo '<td class="comments">' . $issue['Issue']['comments'] . '</td>';
	echo '<td class="updated">' . $time->niceShort($issue['Issue']['updated']) . '</td>';
	echo '</td>';
}
		?>
			
		</tbody>
	</table>

<p class="pagenav">Page 
<!-- Shows the page numbers -->
<?php echo $paginator->numbers(); ?>
<!-- Shows the next and previous links -->
<?php
	echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
	echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
?> 
<!-- prints X of Y, where X is current page and Y is number of pages -->
<?php //echo $paginator->counter(); ?>
</p>
	<?php echo $this->Js->writeBuffer(); ?>
<?php } else { ?>
	<p>There are no issues here</p>
<?php } ?>

</div>
<div id="rightcol">
	<?php echo $this->element('saved_searches', array('searches' => $savedSearches)); ?>
	<?php echo $this->element('project_users', array('users' => $projectUsers)); ?>
</div>
