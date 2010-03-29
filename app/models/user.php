<?php

class User extends AppModel
{
	var $useTable = 'user';
	var $primaryKey = 'user_id';

	function beforeSave()
	{
		$this->data['User']['password'] = md5($this->data['User']['password']);		
		return true;
	}
	
}

?>