<div class="comment">
	<div class="avatar">
		<?php
		$url = 'http://www.gravatar.com/avatar/' . md5($comment['User']['email']) . 'jpg';
		?>
		<img src="<?php echo $url; ?>" border="0" alt="" />
		</div>
		<div class="comment-content">
			<p class="comment-info">Posted by <?php echo $this->element('username', array('user' => $comment['User'])); ?> on <?php echo $time->niceShort($comment['Comment']['created']); ?></p>
		<p><?php echo $text->autoLink(nl2br($comment['Comment']['content'])); ?></p>
	</div>
</div>
