<?php

class Comment extends AppModel
{
	var $useTable = 'comment';
	var $primaryKey = 'comment_id';
	var $belongsTo = array('User' => array('foreignKey' => 'user_id'));
	var $validate = array(
		'content' => array(
			'rule' => 'notEmpty'
			,'required' => true
			,'message' => 'Please supply text for this comment.'
		)		
	);	
}

?>