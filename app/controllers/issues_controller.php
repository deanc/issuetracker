<?php

class IssuesController extends AppController
{
	var $helpers = array('Javascript', 'Paginator', 'Time', 'Text');
	var $components = array('RequestHandler');
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