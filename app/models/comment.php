<?php

class Comment extends AppModel
{
	var $useTable = 'comment';
	var $primaryKey = 'comment_id';
	var $belongsTo = array('User' => array('foreignKey' => 'user_id'));
	var $validate = array(
		'content' => array(
			'rule' => 'notEmpty'
			,'required' => true
			,'message' => 'Please supply text for this comment.'
		)		
	);

	function afterSave($created)
	{
		if(!empty($this->data) AND isset($this->data['Comment']['issue_id']))
		{
			$total = $this->find('count', array('conditions' => 
				array('Comment.issue_id' => $this->data['Comment']['issue_id'])
			));

			App::import('model', 'Issue');
			$issue = new Issue;
			$issue->id = $this->data['Comment']['issue_id'];
			$issue->saveField('comments', $total);
		}
	}
}

?>
