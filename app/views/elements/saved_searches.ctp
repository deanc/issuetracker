<div class="block">
<div id="saved-searches">
	<h2>Saved Searches</h2>
	<?php
	if(sizeof($searches) == 0) {
		?><p>No saved searches</p><?php
	}
	else
	{
		echo '<ul>';
		foreach($searches AS $keywords => $title)
		{
			echo '<li>' . $html->link($title, '/issues/search?keywords=' . urlencode($keywords)) . '</li>';
		}
		echo '</ul>';
	}
?>
	
</div>
</div>
