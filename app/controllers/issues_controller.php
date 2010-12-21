<?php

class IssuesController extends AppController
{
	var $helpers = array('Javascript', 'Paginator', 'Time', 'Text');
	var $components = array('RequestHandler', 'Notifier', 'Session','SearchFilter');
	var $behaviours = array('Containable');
	var $uses = array('Issue', 'Comment', 'User', 'IssueUser', 'Project', 'SavedSearch');
	
	function beforeFilter()
	{
		parent::beforefilter();

		if(in_array($this->action, array('search')))
		{
			$this->set('savedSearches', $this->SavedSearch->listAll(1));
		}

		// logged in actions
		if(in_array($this->action, array('edit','comment','delete')) AND $this->loggedIn === false)
		{
			$this->redirect('/');
		}
	}

	function index()
	{
		$this->redirect('/');
	}
	
	function status($status = null)
	{
	
	}
	
	function view($id)
	{
		$issue = $this->Issue->findByissue_id($id);

		if(empty($issue))
		{
			$this->redirect('/');
		}
		$this->set('issue', $issue);
		
		if($this->Session->check('viewed'))
		{
			$viewed = unserialize($this->Session->read('viewed'));
			if(!in_array($id, array_keys($viewed))) 
			{
				$viewed += array($id => date("Y-m-d H:i:s"));
				$this->Session->write('viewed', serialize($viewed));
			}
			else
			{
				$viewed[$id] = date("Y-m-d H:i:s");
				$this->Session->write('viewed', serialize($viewed));
			}
		}


		// comments
		$this->set('comments', $this->Comment->find('all', array('conditions' => "Comment.issue_id = $id", 'order' => 'Comment.created DESC')));

        	// statuses for comment form
	        $this->set('statuses', $this->Issue->IssueStatus->find('list' ,array('fields' => array('IssueStatus.status'))));
	
		// priorities for comment form
		$this->set('priorities', $this->Issue->IssuePriority->find('list', array('fields' => array('IssuePriority.priority'))));
	}
	
	function edit($id)
	{
		
		$this->set('statuses', $this->Issue->IssueStatus->find('list' ,array('fields' => array('IssueStatus.status'))));
		$this->set('priorities', $this->Issue->IssuePriority->find('list', array('fields' => array('IssuePriority.priority'))));

		$issue = $this->Issue->findByissue_id($id);
		
		$users = array();
		foreach($issue['Users'] AS $user)
		{
			$users[$user['user_id']] = $user['username'];
		}
		$this->set('project_users', $users);
		$this->set('_project_id', $issue['Issue']['project_id']);
		//debug($issue['Issue']['project_id']);
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
			
				if(isset($this->data['Users']))
				{
					$this->Issue->updateUsers($issue['Issue']['issue_id'], $this->data['Users']);
				}
				
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
					
					$status = $this->IssueStatus->findBystatus_id($this->data['Issue']['status_id']);
					foreach($emails AS $email)
					{
						$this->Notifier->addRecipient(null, $email);
					}
					$this->Notifier->send('[Status:' . $status['IssueStatus']['status'] . '] ' . $this->data['Issue']['title'], 'issuestatuschanged', array(
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
	
	function create($project_id)
	{
		$this->set('_project_id', $project_id);

		if($this->Session->check('userinfo'))
		{
			$userinfo = $this->Session->read('userinfo');
			$this->set('statuses', $this->Issue->IssueStatus->find('list' ,array('fields' => array('IssueStatus.status'))));
			$this->set('priorities', $this->Issue->IssuePriority->find('list', array('fields' => array('IssuePriority.priority'))));
			$this->set('user_id', $userinfo['User']['user_id']);
            $this->set('project_id', (int)$project_id);
			if(!empty($this->data))
			{
				if($this->Issue->validates($this->data))
				{
					$this->Issue->save($this->data);
					
					//$this->Issue->updateUsers($issue['Issue']['issue_id'], $this->data['Users']);

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
			if(empty($this->data['Comment']['content']))
			{
				$this->flash('Please enter a comment if changing the status', '/issues/view/' . $id);
				return;
			}

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

            if($this->data['Issue']['status_id'] > 0)
            {
                $this->Issue->id = $id;
                $this->Issue->save(
                    array('Issue' => array('status_id' => $this->data['Issue']['status_id']))
                );
            }

		if(isset($this->data['Issue']['priority_id']) AND $this->data['Issue']['priority_id'] > 0)
		{
			$this->Issue->id = $id;
			$this->Issue->save(
				array('Issue' => array('priority_id' => $this->data['Issue']['priority_id']))
			);
		}
			
			// ##### notifications for people active on the issue #####
			$emails = $this->Issue->getParticipants($id);

			$issue = $this->Issue->findByissue_id($id);
			if($user_id = $issue['Issue']['user_id'])
			{
				foreach($emails AS $key => $email)
				{
					if($email == $userinfo['User']['email'])
					{
						unset($emails["$key"]);
					}
				}
			}
			
			foreach($emails AS $email)
			{
				$this->Notifier->addRecipient(null, $email);
			}
			$this->Notifier->send('[New:comment] ' . $issue['Issue']['title'], 'newcomment', array(
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

	function delete($id)
	{
		$issue = $this->Issue->findByissue_id($id);
		if(!empty($issue))
		{
			if(!empty($this->data))
			{
				$this->Issue->delete($this->data['Issue']['issue_id']);
				$this->flash('This issue has been deleted', '/projects/'. $this->data['Issue']['project_id'] . '/issues');
			}
			else
			{
				$this->data = $issue;
			}
		}
		else
		{
			$this->flash('Invalid issue', '/issues/view/' . $id);
		}
	}	

	function search()
	{
         //$this->set('project', $this->Project->findByproject_id($project_id));
            $this->paginate = array(
                 'contain' => array('User', 'IssueStatus', 'IssuePriority')
	              , 'limit' => 20
	               ,'order' => 'Issue.updated DESC'
	            );
	    
			$conditions = array();
			$keywords = $this->params['url']['keywords'];

			$filter = $this->SearchFilter->parse($this->params['url']['keywords']);
			if(sizeof($filter['conditions']) > 0)
			{
				$keywords = $filter['keywords'];
				$conditions += $filter['conditions'];
			}

			if(strlen($keywords) > 0)
			{
		    	// look for url params
		    	$conditions += array(
					'OR' => array(
						'Issue.title LIKE ' => '%' . $keywords . '%'
						,'Issue.content LIKE ' => '%' . $keywords . '%'
					)
				);
			}

		    $this->paginate = array_merge($this->paginate, array('conditions' => $conditions));
				
			$this->set('keywords', $this->params['url']['keywords']);	
		    $issues = $this->paginate('Issue');
		    $this->set(compact('issues'));
	}
}

?>
