<?php

class UsersController extends AppController
{
	var $helpers = array('Html', 'Time');
	var $components = array('Email', 'Session');
	
	function profile($username)
	{
		$user = $this->User->findByusername($username);
		if(empty($user))
		{
			$this->flash('User does not exist', '/');
		}
		else
		{
			$this->set('user', $user);
		}
	}

	function searches()
	{
		App::import('model', 'SavedSearch');
		$ss = new SavedSearch;
		$searches = $ss->find('all', array(
			'conditions' => array('SavedSearch.user_id' => $this->userinfo['User']['user_id'])
		));
		$this->set('searches', $searches);
	}

	function login()
	{
		if(!$this->isLoggedIn())
		{
			if (!empty($this->data))
			{
				$salt = $this->User->findByemail($this->data['User']['email']);

				$user = $this->User->find('first', array('conditions' => array(
					'User.email' => $this->data['User']['email']
					,'User.password' => md5($this->data['User']['password'] . $salt['User']['salt'])
				)));

				if(!empty($user))
				{	
					$userid = $user['User']['user_id'];
					$this->Cookie->write('user_id', $userid, false);
					$this->Cookie->write('hash', $this->generateHash($userid), false);
					$this->getUserInfo($userid);					
					
					$this->Session->write('lastvisit', $user['User']['lastactivity']);
					
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

	function ajaxFind()
	{
		//$existing = explode(',', $_GET['id_list']);
		//$existing = array_unique($existing);

		$users = $this->User->find('all', array(
			'fields' => array('User.user_id', 'User.username')
			,'conditions' => array('User.username LIKE \'%' . preg_replace('/[^a-z0-9]+/i', '', $_GET['tag']) . '%\'')
		));

		$json =  array();
		foreach($users AS $u)
		{
			$json[] = array(
				'value' => $u['User']['user_id']
				,'key' => $u['User']['username']
			);
		}
		echo json_encode($json);die;
	}

	function admin_index()
	{
		$this->set('users', $this->User->find('all'));
	}

	function admin_edit($id = null)
	{
		$this->Breadcrumb->addBreadcrumb(array('title' => 'Admin CP', 'slug' => '/admincp'));
		$this->Breadcrumb->addBreadcrumb(array('title' => 'Users', 'slug' => '/admin/users'));
		
		if(empty($this->data))
		{
			$this->data = $this->User->findByuser_id($id);
		}
		else
		{
			$this->User->set($this->data);
			if($this->User->validates())
			{
				//debug('wat');
				$this->User->save();
				$this->flash('User saved', '/admin/users');
			}
		}
	}
}

?>
