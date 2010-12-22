<?php  
class BreadcrumbHelper extends Helper { 

    var $helpers    = array('Html'); 
    var $sHome      = 'Home'; 
    var $sAdmin     = 'Admin'; 

    public function display($aBreadcrumbs) { 

        if (is_array($aBreadcrumbs)) { 

        $sBreadcrumbsID = isset($this->params['admin']) ? 'breadcrumb' : 'breadcrumb-admin'; 
        $returnHTML = '<ul id="' . $sBreadcrumbsID . '">'; 

        # Build the first breadcrumb dependent on if admin area is active or the front end   
        $this->aFirstBreadcrumb = isset($this->params['admin']) ? array('title' => $this->sAdmin, 'slug' => 'admin/') : array('title' => $this->sHome, 'slug' => ''); 
        $returnHTML .= '<li>' . $this->Html->link($this->aFirstBreadcrumb['title'], "/" . $this->aFirstBreadcrumb['slug']) . '</li>'; 

        foreach($aBreadcrumbs as $key => $value) { 
            if(isset($value['slug']))
			{
				$returnHTML .= '<li>' . $this->Html->link($value['title'], "/" . $value['slug']) . '</li>'; 
        	}
			else
			{
				$returnHTML .= '<li>' . $value['title'] . '</li>';
			}
		}

        $returnHTML .= '</ul>'; 
        return $returnHTML; 
        } 

    } 

} 
?>
