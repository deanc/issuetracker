<?php
class AppController extends Controller 
{
	var $cookieKey = 'adsfadsf1231232asxdfjkljlkjjk';
	var $uses = array('IssueStatus', 'User');
	var $components = array('Cookie', 'Session');
	
	function beforeFilter()
	{
		$logged_in = $this->isLoggedIn();
		//debug(var_export($logged_in, true));
		$this->set('is_logged_in', $logged_in);
		if($logged_in)
		{
			$this->set('userinfo', $this->Session->read('userinfo'));
			$this->User->id = $this->Cookie->read('user_id');
			$this->User->saveField('lastactivity', date('Y-m-d H:i:s'));

			if(!$this->Session->check('viewed'))
			{
				$this->Session->write('viewed', serialize(array()));
			}
		}

		//debug($this->Session->read('viewed'));
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
