<?php

class SearchFilterComponent extends Object
{
	function parse($string)
	{
		$returnFormat = array(
			'conditions' => array()
			,'keywords' => $string
		);
		preg_match_all('/\b[a-z]+:([a-z0-9-]+|".*?")/i', $string, $matches);
		if(sizeof($matches) > 0)
		{
			foreach($matches[0] AS $key => $match)
			{
				$match = trim($match);
				$bits = explode(':', $match);
				
				if(substr($bits[1], 0, 1) == '"' AND substr($bits[1], -1) == '"')
				{
					$bits[1] = substr($bits[1], 1, -1);
				}

				// Valid search bits
				switch($bits[0])
				{
					case 'status':
						
						App::import('Model', 'IssueStatus');
						$is = new IssueStatus;
						$status = $is->findBystatus($bits[1]);
						if(!empty($status))
						{
							$returnFormat['conditions'][] = array(
								'Issue.status_id' => $status['IssueStatus']['status_id']
							);
							$string = str_replace($match, '', $string);
						}

					break;

					case 'author':
						App::import('Model', 'User');
						$u = new User;
						$user = $u->findByusername($bits[1]);
						if(!empty($user))
						{
							$returnFormat['conditions'][] = array(
								'Issue.user_id' => $user['User']['user_id']
							);
							$string = str_replace($match, '', $string);
						}
					break;
				}
			}
			$string = preg_replace('/\s+/i', ' ', $string);
			$returnFormat['keywords'] = $string;
		}
		return $returnFormat;
	}
}

?>
