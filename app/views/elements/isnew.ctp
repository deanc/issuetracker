<?php

if($loggedIn)
{
	$new = '<span class="new">New!</span>';
	// if the issue key is set, we know we're dealing with an issue
	if(isset($issue))
	{
		// if it's been viewed, check it hasn't been updated since
		if(is_array($viewedIssues) AND in_array($issue['issue_id'], array_keys($viewedIssues)))
		{
			if($viewedIssues[$issue['issue_id']] > $issue['updated'])
			{
				$new = '';
			}
		}
		else // if it's not been viewed, see if it's new!
		{
			if($issue['updated'] < $lastVisit)
			{
				$new = '';
			}
		}
	}
	else if(isset($project))
	{
		if($project['lastactivity'] < $lastVisit)
		{
			$new = '';
		}
	}
}


?>
