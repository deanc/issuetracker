<?php

if(empty($hex)) {
	$hex = '#ccc;';
}
$attributes = ' style="background:' . $hex . '; -moz-border-radius: 3px; border-radius: 3px"';

echo '<span class="priority"' . $attributes . '>' . $priority . '</span>';
?>
