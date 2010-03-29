<?php

class Tag extends AppModel
{
	var $useTable = 'tag';
	var $primaryKey = 'tag_id';
	var $hasAndBelongsToMany = array(
		'Issue' => array(
			'className'=>'Issue'
			, 'foreignKey' => 'tag_id'
			,'associationForeignKey'  => 'tag_id'
			,'joinTable' => 'issue_tag'
		)
	);
}

?>