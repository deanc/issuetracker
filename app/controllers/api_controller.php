<?php

class ApiController extends AppController
{
	var $uses = array('Comment');
	var $components = array('GitParser');

	function commit()
	{
		$this->autoRender = false;

		$config = Configure::read('API');
		if(isset($config['key']) AND $config['key'] != null)
		{
			if(isset($this->params['url']['key']) AND isset($this->params['url']['msg']))
			{
				if($this->params['url']['key'] == $config['key'])
				{
					$parsed = $this->GitParser->parse($this->params['url']['msg']);
					$msg = sprintf(
						'New commit to branch %s:' . "\r\n%s"
						, $this->params['url']['branch']
						, $this->params['url']['msg']
					);
					foreach($parsed AS $change)
					{
						$this->Comment->set(array(
							'Comment' => array(
								'issue_id' => $change['issue_id']
								,'content' => $msg
								,'user_id' => $config['user_id']
							)
						));//
						$this->Comment->save();
					}
				}
			}
		}
	}
}

?>
