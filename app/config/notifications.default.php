<?php

/**
 * If you wish to use standard PHP mailing then leave the smtp values as they are
 * and just set the 'from' value.
 */
$config['Notifications'] = array(
	'from' => 'example@example.com'
	,'smtp' => array(
		'port' => '25'
		,'timeout' => '30'
		,'host' => ''
		,'username' => ''
		,'password' => ''
		,'client' => ''
	)
);

?>
