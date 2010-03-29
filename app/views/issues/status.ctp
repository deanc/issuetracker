<h2>Viewing all issues</h2>



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
<?php echo $paginator->counter(); ?>
</p>

	<table>
		<thead>
	<tr> 
		<th><?php echo $paginator->sort('Title', 'title'); ?></th> 
		<th><?php echo $paginator->sort('Author', 'User.username'); ?></th> 
		<th><?php echo $paginator->sort('Status', 'IssueStatus.status'); ?></th>
		<th><?php echo $paginator->sort('Comments', 'Issue.comments'); ?></th>
		<th><?php echo $paginator->sort('Last Updated', 'updated'); ?></th>	 
	</tr>
		</thead>
		<tbody>
		
		<?php
foreach($issues as $issue)		
{
	echo '<tr>';
	echo '<td>' . $html->link($issue['Issue']['title'], '/issues/view/' . $issue['Issue']['issue_id']) . '</td>';
	echo '<td>' . $issue['User']['username'] . '</td>';
	echo '<td>' . $issue['IssueStatus']['status'] . '</td>';
	echo '<td>' . $issue['Issue']['comments'] . '</td>';
	echo '<td>' . $issue['Issue']['updated'] . '</td>';
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
<?php echo $paginator->counter(); ?>
</p>
	<?php echo $this->Js->writeBuffer(); ?>
<?php } else { ?>
	<p>There are no issues with a status of '<?php echo $status; ?>'</p>
<?php } ?>