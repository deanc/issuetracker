<?php

class Issue extends AppModel
{
	var $name = 'Issue';
	var $useTable = 'issue';
	var $primaryKey = 'issue_id';
	
	var $actsAs = array('Containable');
	
	var $_schema = array(
	  'title' => array('type' => 'string', 'length' => 30)
	  ,'content' => array('type' => 'text')
	  ,'status_id' => array('type' => 'integer')
	  ,'user_id' => array('type' => 'integer')
	  ,'priority_id' => array('type' => 'integer')
	);	
	
	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className'=>'Tag'
			, 'foreignKey' => 'issue_id'
			,'associationForeignKey'  => 'tag_id'
			,'joinTable' => 'issue_tag'
		),
	 
       		 'Users' =>
                array(
                    'className'              => 'User',
                    'joinTable'              => 'issue_user',
                    'foreignKey'             => 'issue_id',
                    'associationForeignKey'  => 'user_id',
                    'unique'                 => true,
                    'conditions'             => '',
                    'fields'                 => '',
                    'order'                  => '',
                    'limit'                  => '',
                    'offset'                 => '',
                    'finderQuery'            => '',
                    'deleteQuery'            => '',
                    'insertQuery'            => '',
		   // 'with'		     => 'IssueUser'
                )
        );

	var $belongsTo = array(
		'User' => array('foreignKey' => 'user_id')
		,'IssueStatus' => array('foreignKey' => 'status_id')
		,'IssuePriority' => array('foreignKey' => 'priority_id')
		,'Project' => array('foreignKey' => 'project_id')
	);

	var $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
			,'message' => 'Please supply a title for this issue.'
		),
		'content' => array(
			'rule' => 'notEmpty'
			,'message' => 'Please supply some details about this issue.'
		)				
	); 	
	
	function getParticipants($id)
	{
		$emails = array();
		
		// author?
		$issue = $this->findByissue_id($id);
		$emails[] = $issue['User']['email'];
		
		// commenters
		App::import('Model', 'Comment');
		$comment = new Comment;
		$commenters = $comment->find('all', array(
			'conditions' => "Comment.issue_id = $id"
			,'fields' => 'DISTINCT User.email'
		));	
		foreach($commenters as $key => $commenter)
		{
			$emails[] = $commenter['User']['email'];
		}
		
		return array_unique($emails);		
	}

	function updateUsers($issueID, $users)
	{
		App::import('model', 'IssueUser');
		$issueuser = new IssueUser;
		$issue = $this->findByissue_id($issueID);
	        if(isset($users) AND sizeof($users) > 0)
                {
                	$issueuser->del(array(
                        	'conditions' => array(
                                	'issue_id' => $issueID
                              )
                        ));
 
                        foreach($users AS $userid)
                        {
                        	$issueuser->save(array(
                                	'IssueUser' => array(
                                        	'issue_id' => $issueID
                                                ,'user_id' => $userid
                                        )
                                ));
                        }
                }
	}

	function afterSave($created)
	{
		$issue = $this->findByissue_id($this->id);	
		if(isset($issue['Issue']['project_id']))
		{
			App::import('model', 'Project');
			$project = new Project;
			$project->id = $issue['Issue']['project_id'];
			$project->saveField('lastactivity', date("Y-m-d H:i:s"));
		}
	}
	
}

?>
