<table>
	<thead>
<?php
echo $this->Html->tableHeaders(array('Username', 'Created', 'Options'));
?>
	</thead>
	<tbody>

<?php

foreach($users AS $user)
{
	echo '<tr>';
	echo '<td>' . $user['User']['username'] . '</td>';
	echo '<td>' . $this->Time->timeAgoInWords($user['User']['created']) . '</td>';
	echo '<td>' . $html->link('Edit', '/admin/users/edit/' . $user['User']['user_id']) . '</td>';
	echo '</tr>';
}

?>
	</tbody>
</table>
