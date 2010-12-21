<?php

class ProjectsController extends AppController
{
    var $uses = array('Project', 'Issue', 'User', 'IssuePriority', 'IssueStatus', 'ProjectUser', 'SavedSearch');
	var $helpers = array('Javascript', 'Paginator', 'Time', 'Text');
	var $components = array('RequestHandler', 'Session');

    function beforeFilter()
    {
        parent::beforeFilter();
        if($this->params['action'] == 'issues')
        {
			$this->set('savedSearches', $this->SavedSearch->listAll(1));
			$this->ProjectUser->bindModel(array(
				'belongsTo' => array('User' => array('primaryKey' => 'User.user_id'))
			));
			$this->set('projectUsers', $this->ProjectUser->find('all', array(
				'conditions' => array('ProjectUser.project_id' => $this->params['pass'][0])
				)
			));
		}
    }

	function index()
	{
        
		$userinfo = $this->Session->read('userinfo');
        $conditions = array('Project.public' => 1);
        if(!empty($userinfo))
        {
            $conditions = array('OR' => array('ProjectUser.user_id' => 1, 'Project.public = 1'));
        }

        $this->Project->bindModel(array(
            'hasOne' => array(
                'ProjectUser'
        )));
        $this->Project->recursive = 0;

        $projects = $this->Project->find('all', array(
                'fields' => array('Project.*'),
                'conditions'=>$conditions
        ));

        $ids = array();
        foreach($projects AS $key => $project)
        {
			$count = $this->Issue->find('count', array('conditions' => array('Issue.project_id' => $project['Project']['project_id'])));
			$projects["$key"]['Project']['total_issues'] = $count;
            if(in_array($project['Project']['project_id'], $ids))
            {
                unset($projects["$key"]);
            }
            else
            {
                $ids[] = $project['Project']['project_id'];
            }
        }
		$this->set('user', $this->User->findByuser_id($userinfo['User']['user_id']));
		$this->set('viewed', $this->Session->read('viewed'));
		$this->set('projects', $projects);
	}

    function issues($project_id, $status = 0, $priority = 0)
    {
        $this->set('project', $this->Project->findByproject_id($project_id));

 		$this->paginate = array(
			'contain' => array('User', 'IssueStatus', 'IssuePriority')
			, 'limit' => 20
			,'order' => 'Issue.updated DESC'
		);

		// look for url params
	$conditions = array('Issue.project_id' => (int)$project_id);
	if(isset($_GET['status_id']))
	{	
		$status_id = $this->IssueStatus->findBystatus_id(intval($_GET['status_id']));

		if($status_id > 0)
		{
			$this->set('status', $status_id['IssueStatus']['status']);
			$status_id = $status_id['IssueStatus']['status_id'];
			$this->paginate = array_merge($this->paginate, array('conditions' => array('Issue.status_id' => $status_id, 'Issue.project_id' => (int)$project_id)));
			$conditions['Issue.status_id'] = $status_id;
		}

		if(isset($_GET['priority_id']))
		{
			$priority = $this->IssuePriority->findBypriority_id(intval($_GET['priority_id']));

			if(!empty($priority))
			{
				$conditions['Issue.priority_id'] = $priority['IssuePriority']['priority_id'];
			}
		}
	}

	$this->paginate = array_merge($this->paginate, array('conditions' => $conditions));


    	$issues = $this->paginate('Issue');

    	$this->set(compact('issues'));
		$this->set('viewed', unserialize($this->Session->read('viewed')));
		$this->set('lastvisit', $this->Session->read('lastvisit'));
    }

    function users($project_id, $issue_id = 0)
	{
		$this->ProjectUser->primaryKey = 'user_id';
		$this->ProjectUser->bindModel(array(
			'hasOne' => array('User' => array('className' => 'User', 'foreignKey' => 'user_id'))
		));

		$conditions = array('ProjectUser.project_id' => $project_id);
		if(isset($_GET['tag']) AND !empty($_GET['tag']))
		{
			$conditions[] = 'User.username LIKE \'%' . preg_replace('/[^A-Z0-9]+/i', '', $_GET['tag']) . '%\'';
		}
		else
		{
			echo json_encode(array());
			die;
		}		

		$users = $this->ProjectUser->find('all', array('conditions' => $conditions));

	//	$users = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.project_id' => $project_id), 'contain' => array('User')));
		
		$existing = explode(',', $_GET['id_list']);
		$existing = array_unique($existing);

		$json = array();
		foreach($users as $u)
		{
			if(!in_array($u['ProjectUser']['user_id'], $existing)) {
				$json[] = array(
					'value' => $u['ProjectUser']['user_id']
					,'caption' => $u['User']['username']
				);
			}
		}
		echo json_encode($json);
		die;
	}

	function admin_index()
	{
		$this->set('projects', $this->Project->find('all'));
	}
}

?>
