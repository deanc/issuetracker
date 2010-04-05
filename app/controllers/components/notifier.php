<?php

class NotifierComponent extends Object 
{
    var $components = array('Email');
    
    private $recipients = array();
    
    public function addRecipients($multiple)
    {
    	foreach($multiple AS $email => $name)
    	{
    		$this->addRecipient($name, $email);
    	}
    }
    
    public function addRecipient($name, $email)
    {
    	$this->recipients["$email"] = $name;
    }
    
    private function clearRecipients()
    {
    	$this->recipients = array();
    }
    
	public function send($subject, $template, $variables = array()) 
    {
    	if(sizeof($this->recipients) > 0)
    	{
	    	if(sizeof($variables) > 0)    	
	    	{
	    		foreach($variables AS $key => $val)
	    		{
	    			$this->Email->Controller->set($key, $val);
	    		}
	    	}
	    	
	    	$config = Configure::read('Notifications');
	    	
	    	$this->Email->from = $config['from'];
	    	
	    	foreach($this->recipients AS $email => $name)
	    	{
	    		$to[] = trim($name . ' <' . $email . '>');
	    	}
	    	$this->Email->to = implode(',', $to);
	    	
	    	$this->Email->subject = $subject;
	    	$this->Email->template = $template;
	    	
			if(!empty($config['smtp']['host']))
			{
				$this->Email->smtpOptions = $config['smtp'];
				$this->Email->delivery = 'smtp';
			}
			
			$this->Email->send();
			
			$this->clearRecipients();
    	}
    }
    
    public function getErrors()
    {
    	return $this->Email->smtpError;
    }
}

?>