<div class="clearfix">
<div id="leftcol">

<h2>Searching for "<?php echo htmlspecialchars($keywords); ?>"</h2>

<?php

		$this->Paginator->options(array(
		    'update' => '#center',
		    'evalScripts' => true
			,'url' => array('controller' => 'issues', 'action' => 'search', '?' => 'keywords='.$this->params['url']['keywords'])
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

	<table>
		<thead>
	<tr> 
		<th><?php echo $paginator->sort('Title', 'title'); ?></th> 
		<th><?php echo $paginator->sort('Author', 'User.username'); ?></th> 
		<th><?php echo $paginator->sort('Status', 'IssueStatus.status'); ?></th>
		<th><?php echo $paginator->sort('Priority', 'IssuePriority.priority'); ?></th>
		<th><?php echo $paginator->sort('Comments', 'Issue.comments'); ?></th>
		<th><?php echo $paginator->sort('Last Updated', 'updated'); ?></th>	 
	</tr>
		</thead>
		<tbody>
		
		<?php
foreach($issues as $issue)		
{
	echo '<tr>';
	echo '<td>' . $html->link($issue['Issue']['title'], '/projects/' . $issue['Issue']['project_id'] . '/issue/' . $issue['Issue']['issue_id']) . '</td>';
	echo '<td>' . $issue['User']['username'] . '</td>';
	echo '<td>' . $issue['IssueStatus']['status'] . '</td>';
	echo '<td>' . $this->element('priorityhighlight', array('hex' => $issue['IssuePriority']['hex'], 'priority' => $issue['IssuePriority']['priority'])) . '</td>';
	echo '<td>' . $issue['Issue']['comments'] . '</td>';
	echo '<td>' . $time->niceShort($issue['Issue']['updated']) . '</td>';
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
</div>
</div>
