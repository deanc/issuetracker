<?php

class ProjectsController extends AppController
{
    var $uses = array('Project', 'Issue', 'User');
	var $helpers = array('Javascript', 'Paginator', 'Time', 'Text');
	var $components = array('RequestHandler');

    function beforeFilter()
    {
        parent::beforeFilter();
        if($this->params['action'] == 'issues')
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


		$this->set('projects', $this->Project->find('all', array(
                'fields' => array('Project.*'),
                'conditions'=>$conditions
        ))); 
	}

    function issues($project_id, $status = 0)
    {
        $this->set('project', $this->Project->findByproject_id($project_id));

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
			$this->paginate = array_merge($this->paginate, array('conditions' => array('Issue.status_id' => $status_id, 'Issue.project_id' => (int)$project_id)));
		}

    	$issues = $this->paginate('Issue');

    	$this->set(compact('issues'));
    }

}

?>