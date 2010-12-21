<?php

class SavedSearch extends AppModel
{
	var $useTable = 'saved_search';
	var $primaryKey = 'search_id';


	function listAll($userid)
	{
		return $this->find('list', array(
			'fields' => array('SavedSearch.keywords', 'SavedSearch.title')
			,'conditions' => array('SavedSearch.user_id' => $userid)
		));
	}
}

?>
