<?php

if((!in_array($issue['issue_id'], array_keys($viewed)) AND $issue['updated'] > $lastvisit) OR (isset($viewed[$issue['issue_id']]) AND $viewed[$issue['issue_id']] < $issue['updated']))
{
	echo '<span class="new">New!</span>';
}

?>
