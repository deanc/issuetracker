<?php

class Issue extends AppModel
{
	var $name = 'Issue';
	var $useTable = 'issue';
	var $primaryKey = 'issue_id';
	
	var $actsAs = array('Containable');
	
	var $_schema = array(
	  'title' => array('type' => 'string', 'length' => 30)
	  ,'content' => array('type' => 'text')
	  ,'status_id' => array('type' => 'integer')
	  ,'user_id' => array('type' => 'integer')
	);	
	
	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className'=>'Tag'
			, 'foreignKey' => 'issue_id'
			,'associationForeignKey'  => 'tag_id'
			,'joinTable' => 'issue_tag'
		)
	); 
	
	var $belongsTo = array(
		'User' => array('foreignKey' => 'user_id')
		,'IssueStatus' => array('foreignKey' => 'status_id')
	);

	var $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
			,'message' => 'Please supply a title for this issue.'
		),
		'content' => array(
			'rule' => 'notEmpty'
			,'message' => 'Please supply some details about this issue.'
		)				
	); 	
	
}

?>