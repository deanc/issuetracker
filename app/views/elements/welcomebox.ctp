<div id="user-box">

<span class="toggle"><img style="vertical-align: middle" src="http://www.gravatar.com/avatar/<?php echo md5($userinfo['User']['email']);?>.jpg?size=20" border="0" alt="" /> <?php echo $userinfo['User']['username'] . ' <img src="' . $html->url('/img/arrow.png') . '" border="0" alt="" class="arrow" /></span>'; ?>

<div id="user-box-popup">
<ul>
	<li><?= $html->link('View Profile', '/user/' . $userinfo['User']['username']); ?></li>
	<li><?= $html->link('Logout', '/users/logout'); ?></li>
</div>

</div>
