<div class="clearfix">
	<div id="leftcol">
		<div id="profile">
			<div class="clearfix">
				<img src="<?= 'http://www.gravatar.com/avatar/' . md5($user['User']['email']) . 'jpg'; ?>" border="0" alt="avatar" class="avatar" />
				<div class="userinfo">
					<h2><?= $user['User']['username']; ?></h2>
					<p>
						<strong>Joined: </strong><?= $time->niceShort($user['User']['created']); ?><br />
						<strong>Last Activity: </strong><?= $time->niceShort($user['User']['lastactivity']); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div id="rightcol">
		<ul>
			<li><?= $html->link('Edit profile', '/profile/edit'); ?></li>
			<li><?= $html->link('Issues', '/issues/search?keywords=' . urlencode('author:' . $user['User']['username']));?></li>
		</ul>
	</div>
</div>
