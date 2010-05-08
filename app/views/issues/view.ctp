<h2><?php echo $issue['Issue']['title'] ?> (<?php echo $issue['IssueStatus']['status']; ?>)</h2>
<p class="issue-info">
Posted by: <?php echo $issue['User']['username'] ?> 
- Created: <?php echo $time->niceShort($issue['Issue']['created']) ?><span style="float: right;"><?php echo $html->link('Edit', '/issues/edit/' . $issue['Issue']['issue_id']); ?></span>
</p>
<p><?php echo $text->autoLink(nl2br($issue['Issue']['content'])); ?></p>


<div id="issue-comments">
<h3>Comments</h3>
<?php

	if($is_logged_in)
	{
	?>
		<form action="<?php echo $html->url('/issues/comment/' . $issue['Issue']['issue_id'] . '/') ?>" method="post" id="comments">
			<strong>Make a comment</strong><br />
			<textarea name="data[Comment][content]" rows="5" cols="60"></textarea><br />
			<?php echo $form->submit('Post Comment'); ?>
		</form>
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