<?php

class GitParserComponent extends Object
{
	function parse($string)
	{
		$string = urldecode($string);
		preg_match_all('/\[#(\d+)(:[a-z])?\]/i', $string, $matches);
		
		$ret = array();
		foreach($matches[0] AS $k => $match)
		{
			$change = array(
				'issue_id' => $matches[1]["$k"]
			);
			if(!empty($matches[2]["$k"]))
			{
				$change['status'] = $matches[2]["$k"];
			}
			$ret[] = $change;
		}
		return $ret;
	}
}

?>
