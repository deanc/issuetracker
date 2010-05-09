<div class="comment">
	<div class="avatar">
		<img src="http://www.gravatar.com/avatar/<?php echo md5($comment['User']['email']); ?>.jpg" border="0" alt="" />
	</div>
	<div class="comment-content">
		<p class="comment-info">Posted by <?php echo $comment['User']['username']; ?> on <?php echo $time->niceShort($comment['Comment']['created']); ?></p>
		<p><?php echo $text->autoLink(nl2br($comment['Comment']['content'])); ?></p>
	</div>
</div>