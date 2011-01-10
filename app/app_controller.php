<?php
class AppController extends Controller 
{
	var $cookieKey = 'adsfadsf1231232asxdfjkljlkjjk';
	var $uses = array('IssueStatus', 'User');
	var $components = array('Cookie', 'Session', 'Breadcrumb');
	var $helpers = array('Crumb', 'Html', 'Time', 'Breadcrumb', 'Form');

	var $loggedIn = null;
	var $userinfo = null;
	var $lastVisit = null;
	var $viewedIssues = array();

	function beforeFilter()
	{
		$this->userinfo = $this->Session->read('userinfo');
		$this->loggedIn = $this->isLoggedIn();

		if($this->loggedIn)
		{
			$this->User->id = $this->Cookie->read('user_id');
			$this->User->saveField('lastactivity', date('Y-m-d H:i:s'));

			if(!$this->Session->check('viewed'))
			{
				$this->Session->write('viewed', serialize(array()));
			}

        	$viewed = $this->Session->read('viewed');
            if($viewed != null) { $this->viewedIssues = unserialize($viewed); }

			$this->lastVisit = $this->Session->read('lastvisit');
         }

		// Admin check
		if(isset($this->prefix) AND $this->prefix === 'admin' AND $this->userinfo != null AND $this->userinfo['User']['admin'] != 1)
		{
			$this->redirect('/');
		}

		//debug($this->Session->read('viewed'));
	}

	function beforeRender()
	{
		$this->set('loggedIn', $this->loggedIn);
		$this->set('userinfo', $this->userinfo);
		$this->set('viewedIssues', $this->viewedIssues);
		$this->set('lastVisit', $this->lastVisit);

		if(is_object($this->Breadcrumb)) {
			$this->set('breadcrumbs', $this->Breadcrumb->getBreadcrumbs());
		}
	}

	public function isLoggedIn()
	{
		
		$userid = $this->Cookie->read('user_id');
		$hash = $this->Cookie->read('hash');
		if(!empty($userid) AND !empty($hash))
		{
			if($hash == $this->generateHash($userid))
			{
				$this->getUserInfo($userid);
				return true;
			}
			else
			{
				//debug($userid);
				//debug($hash);
				//debug($this->generateHash($userid));
				//$this->logoutUser();
			}
		}
		return false;
	}

	protected function getUserInfo($userid)
	{
		if(!$this->Session->check('userinfo'))
		{
			$userinfo = $this->User->findByuser_id($userid);
			$this->Session->write('userinfo', $this->User->findByuser_id($userid));
		}
		else
		{
			$userinfo = $this->Session->read('userinfo');
		}
		$this->userinfo = $userinfo;
		return $userinfo;
	}

	protected function generateHash($userid)
	{
		return md5($userid . $this->cookieKey . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
	}	
}
?>
