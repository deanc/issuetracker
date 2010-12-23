<?php
/**
 * Created by IntelliJ IDEA.
 * User: DC
 * Date: 08-May-2010
 * Time: 21:44:07
 * To change this template use File | Settings | File Templates.
 */

class ProjectUser extends AppModel {

    var $useTable = 'project_user';
	var $primaryKey = false;

	function getUsers($id, $list = false)
	{
		$this->bindModel(array(
			'belongsTo' => array('User' => array('className' => 'User'))
		));
		$users =  $this->find('all', array(
			'conditions' => array(
				'ProjectUser.project_id' => $id
			)
		));

		if($list)
		{	
			$options = array();
			foreach($users as $user)
			{	
				$options[$user['ProjectUser']['user_id']] = $user['User']['username'];
			}
			return $options;
		}
		return $users;
	}

	function updateUsers($id, $users)
	{
		$this->query("
			DELETE FROM project_user WHERE project_id = '" . intval($id) . "'
		");
		
		foreach($users AS $user_id)
		{
			$this->save(array(
				'ProjectUser' => array(
					'project_id' => $id
					,'user_id' => $user_id
				)
			));
		}
	}
}
