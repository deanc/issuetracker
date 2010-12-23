<h2><?php echo $issue['Issue']['title'] ?> (<?php echo $issue['IssueStatus']['status'] . ' - ' . $issue['IssuePriority']['priority']; ?>)</h2>
<p class="issue-info">
Posted by: <?= $this->element('username', array('user' => $issue['User'])); ?> 
- Created: <?php echo $time->niceShort($issue['Issue']['created']) ?><span style="float: right;"><?php echo $html->link('Edit', '/issues/edit/' . $issue['Issue']['issue_id']) . ' | ' . $html->link('Delete', '/issues/delete/' . $issue['Issue']['issue_id']); ?></span><br />
</p>

<p><?php echo $text->autoLink(nl2br($issue['Issue']['content'])); ?></p>


<div id="issue-comments">
<h3>Comments</h3>
<?php

	if($loggedIn)
	{
	?>
        <fieldset>
		<form action="<?php echo $html->url('/issues/comment/' . $issue['Issue']['issue_id'] . '/') ?>" method="post" id="comments">
			<strong>Make a comment</strong><br />
			<textarea name="data[Comment][content]" rows="5" cols="60"></textarea><br />

            <?php echo $form->input('Issue.status_id', array('empty' => 'Select a status', 'options' => $statuses, 'div' => false, 'label' => 'Change status to:')); ?>
			<?php echo $form->submit('Post Comment'); ?>
		</form>
        </fieldset>
	<?php
	}

	if(sizeof($comments) > 0)
	{
		foreach($comments as $comment)
		{
			echo $this->element('commentbox', array('comment' => $comment));
		}
	}
	else
	{
		?>
		<p>There are no comments</p>
		<?php
	}
?>
</div>
