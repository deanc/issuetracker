<?php

class UsersController extends AppController
{
	
	var $components = array('Email', 'Session');
	
	function login()
	{
		if(!$this->isLoggedIn())
		{
			if (!empty($this->data))
			{
				$user = $this->User->find('first', array('conditions' => array(
					'User.email' => $this->data['User']['email']
					,'User.password' => md5($this->data['User']['password'])
				)));

				if(!empty($user))
				{	
					$userid = $user['User']['user_id'];
					$this->Cookie->write('user_id', $userid, false);
					$this->Cookie->write('hash', $this->generateHash($userid), false);
					$this->getUserInfo($userid);					
					$this->flash('You have been successfully logged in', '/', 5);
				}
			}
		}
		else
		{
			$this->flash('You are already logged in', '/', 5);
		}
	}
	
	
	

	
	
	
	function register()
	{
		if($this->Session->check('userid'))
		{
			$this->redirect('/');
		}

		if(!empty($this->data))
		{
			if(empty($this->data['User']['username']) OR empty($this->data['User']['password']) OR empty($this->data['User']['email']) OR empty($this->data['User']['confirm_password']))
			{
				$errors[] = 'All fields are required';
			}

			$usernamecheck = $this->User->findByusername($this->data['User']['username']);
			if(!empty($usernamecheck))
			{

				$errors[] = 'This username is already in use';
			}

			if(strlen($this->data['User']['username']) > 15)
			{
				$errors[] = 'Your username must be at most 15 characters long';
			}

			if(preg_match('/[^A-Za-z0-9-_]+/i', $this->data['User']['username']))
			{
				$errors[] = 'Usernames can only contain the characters A-Z, 0-9, hyphens and underscores. It may NOT contain spaces';
			}

			$emailcheck = $this->User->findByemail($this->data['User']['email']);
			if(!empty($emailcheck))
			{

				$errors[] = 'This email is already in use';
			}

			if($this->data['User']['password'] != $this->data['User']['confirm_password'])
			{
				$errors[] = 'Your passwords do not match';
			}
			unset($this->data['User']['password_confirm']);

			if(sizeof($errors) == 0)
			{
				$this->User->save($this->data);
				$this->Session->write('userid', $usercheck['User']['userid']);
				$this->flash('You have successfully signed up', '/');
			}
			else
			{
				$this->set('errors', $errors);
			}
		}		
	}

	function logout()
	{
		$this->Cookie->delete('user_id');
		$this->Cookie->delete('hash');
		$this->Session->destroy('userinfo');
		$this->flash('You have been logged out', '/');
	}	
}

?>