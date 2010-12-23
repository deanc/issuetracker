<?php

class User extends AppModel
{
	var $useTable = 'user';
	var $primaryKey = 'user_id';

	var $validate = array(
		'username' => array(
			'rule1' => array('rule' => 'notEmpty', 'message' => 'Please enter a username', 'last' => true)
			,'rule2' => array('rule' => '/^[a-z0-9]+$/i', 'message' => 'Usernames can only contain letters and numbers', 'last' => true)
			,'rule3' => array('rule' => array('between', 3, 15), 'message' => 'Usernames must be between 3 and 15 characters long')
			,'rule4' => array('rule' => 'isUnique', 'message' => 'This username is already taken')
		)
		,'password' => 'notEmpty'
		,'email' => array(
			'rule1' => array('rule' => 'email', 'message' => 'Invalid email address', 'last' => true)
			,'rule2' => array('rule' => 'notEmpty', 'message' => 'Please enter an email address', 'last' => true)
			,'rule3' => array('rule' => 'isUnique', 'message' => 'This email address is already in use')
		)
	);

	private function generateSalt()
	{
		$salt = '';
		for($i=0; $i<6; $i++) { 
	    	$d=rand(1,30)%2; 
		    $salt .= $d ? chr(rand(65,90)) : chr(rand(48,57)); 
		} 
		return $salt;
	}

	function beforeSave()
	{
		if(isset($this->data['User']['password']))
		{
			// if it's an existing user, pull salt from the db
			if(isset($this->data['User'][$this->primaryKey]))
			{
				$user = $this->findByuser_id($this->data['User'][$this->primaryKey]);
				$salt = $user['User']['salt'];
			}
			else // otherwise generate it
			{
				$salt = $this->generateSalt();
			}
			$this->data['User']['password'] = md5($this->data['User']['password'] . $salt);
		}

		return true;
	}
	
}

?>
