<?php
class AppController extends Controller 
{
	var $cookieKey = 'adsfadsf1231232asxdfjkljlkjjk';
	var $uses = array('IssueStatus');
	var $components = array('Cookie', 'Session');
	
	function beforeFilter()
	{
		
//		$statuses = Cache::read('statuses');
//		debug($statuses);
//		if(sizeof($statuses) == 0 OR 1==1)
//		{
		$statuses = $this->IssueStatus->query("
			SELECT
				IssueStatus.*
				,sq.total
			FROM
				issue_status as IssueStatus
			LEFT JOIN
				(
					SELECT COUNT(*) AS total, status_id FROM issue GROUP BY status_id
				) as sq ON (sq.status_id = IssueStatus.status_id)
		");
//			Cache::write('statuses', $statuses);
//		}
		$this->set('_statuses', $statuses);
		$logged_in = $this->isLoggedIn();
		//debug(var_export($logged_in, true));
		$this->set('is_logged_in', $logged_in);
		if($logged_in)
		{
			$this->set('userinfo', $this->Session->read('userinfo'));
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