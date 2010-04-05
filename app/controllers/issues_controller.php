<?php

class IssuesController extends AppController
{
	var $helpers = array('Javascript', 'Paginator', 'Time', 'Text');
	var $components = array('RequestHandler', 'Notifier');
	var $behaviours = array('Containable');
	var $uses = array('Issue', 'Comment', 'User');
	
	function index()
	{
		$this->redirect('/');
	}
	
	function status($status = null)
	{
		$this->paginate = array(
			'contain' => array('User', 'IssueStatus')
			, 'limit' => 20
			,'order' => 'Issue.updated DESC'
		);		
		
		// look for url params
		$status_id = $this->IssueStatus->findBystatus($status);

		if($status_id > 0)
		{
			$this->set('status', $status_id['IssueStatus']['status']);
			$status_id = $status_id['IssueStatus']['status_id'];
			$this->paginate = array_merge($this->paginate, array('conditions' => array("Issue.status_id = $status_id")));		
		}
	
    	$issues = $this->paginate();
    	
    	$this->set(compact('issues'));		
	}
	
	function view($id)
	{
		$issue = $this->Issue->findByissue_id($id);
		if(empty($issue))
		{
			$this->redirect('/');
		}
		$this->set('issue', $issue);
		
		// comments
		$this->set('comments', $this->Comment->find('all', array('conditions' => "Comment.issue_id = $id", 'order' => 'Comment.created DESC')));
	}
	
	function edit($id)
	{
		
		$this->set('statuses', $this->Issue->IssueStatus->find('list' ,array('fields' => array('IssueStatus.status'))));
		
		$issue = $this->Issue->findByissue_id($id);
		if(empty($issue))
		{
			$this->redirect('/');
		}

		if(!empty($this->data))
		{
			if($this->Issue->validates($this->data))
			{
				$this->Issue->save($this->data);
				$this->flash('This issue has been updated', '/issues/view/' . $this->Issue->id);
				
				// ##### if status has changed, let participants know about it #####
				if($this->data['Issue']['status_id'] != $issue['Issue']['status_id'])
				{
					$userinfo = $this->Session->read('userinfo');
					$emails = $this->Issue->getParticipants($id);
		
					if($this->data['Issue']['issue_id'] == $issue['Issue']['user_id'])
					{
						foreach($emails AS $key => $email)
						{
							if($email == $issue['User']['email'])
							{
								unset($emails["$key"]);
							}
						}
					}
					
		
					foreach($emails AS $email)
					{
						$this->Notifier->addRecipient(null, $email);
					}
					$this->Notifier->send('Status changed on Issue #' . $id, 'issuestatuschanged', array(
						'username' => $userinfo['User']['username']
						,'issueurl' => Configure::read('appurl') . '/issues/view/' . $id
					));				
				}
			}
		}
		else
		{
			$this->data = $issue;
		}
	}
	
	function create()
	{
		if($this->Session->check('userinfo'))
		{
			$userinfo = $this->Session->read('userinfo');
			$this->set('statuses', $this->Issue->IssueStatus->find('list' ,array('fields' => array('IssueStatus.status'))));
			$this->set('user_id', $userinfo['User']['user_id']);
			if(!empty($this->data))
			{
				if($this->Issue->validates($this->data))
				{
					$this->Issue->save($this->data);
					
					// notify the assignee
					
					
					
					$this->flash('This issue has been created', '/issues/view/' . $this->Issue->id);
				}
			}
		}
		else
		{
			$this->redirect('/users/login');
		}
	}
	
	function comment($id)
	{
		if(!empty($this->data) AND $this->Session->check('userinfo'))
		{
			$userinfo = $this->Session->read('userinfo');
			$user_id = $userinfo['User']['user_id'];
			$this->Comment->save(
				array('Comment' =>
					array(
						'user_id' => $user_id
						,'issue_id' => $id
						,'content' => $this->data['Comment']['content']
					)
				)
			);
			
			// ##### notifications for people active on the issue #####
			$emails = $this->Issue->getParticipants($id);

			$issue = $this->Issue->findByissue_id($id);
			if($user_id = $issue['Issue']['user_id'])
			{
				foreach($emails AS $key => $email)
				{
					if($email == $issue['User']['email'])
					{
						unset($emails["$key"]);
					}
				}
			}
			

			foreach($emails AS $email)
			{
				$this->Notifier->addRecipient(null, $email);
			}
			$this->Notifier->send('New comment on Issue #' . $id, 'newcomment', array(
				'username' => $userinfo['User']['username']
				,'issueurl' => Configure::read('appurl') . '/issues/view/' . $id
			));
			
			// update comment count
			$this->Issue->id = $id;
			$this->Issue->set('comments', $this->Comment->find('count', array('conditions' => "Comment.issue_id = $id")));
			$this->Issue->save();
			
			$this->flash('This comment has been posted.', '/issues/view/' . $id);
		}
		else
		{
			$this->redirect('/issues/view/' . $id);
		}
	}	
}

?>