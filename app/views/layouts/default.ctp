<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('CakePHP: the rapid development php framework:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->script('/js/jquery-1.4.2.min.js');
		echo $scripts_for_layout;
	?>
</head>
<body>
	
	<div id="topbar"><div id="topbar-container">
		<ul id="topnav">
			<li><?php echo $this->Html->link('Home', '/'); ?></li>
			<!-- <li><?php echo $this->Html->link('Projects', '/'); ?></li> -->
			<?php
			if(isset($project))
			{
				echo '<li>' . $this->Html->link('Create Issue', '/issues/create/' . $project['Project']['project_id']). '</li>';
			}
			?>
		</ul>
		<?php
		if($is_logged_in)
		{
			echo $this->element('welcomebox', array('userinfo' => $userinfo));
		}
		else
		{
			echo $this->element('loginbox');
		}
		?>
	</div></div>

	<div id="container">

		<div id="content">
			<div id="breadcrumb-nav">
				<ul id="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Ignore</a></li>
					<li><a href="#">This</a></li>
					<li><a href="#">For</a></li>
					<li><a href="#">Now</a></li>
				</ul>
				<?php echo $this->element('searchbox'); ?>
			</div>

			<?php echo $this->Session->flash(); ?>

			<!--

			<div id="left">
                <?php
                if(isset($_statuses) AND isset($project))
                {
			
                ?>
				<p><?php echo '<input type="submit" name="create" value="Create Issue" onclick="window.location=\'' . $html->url('/issues/create/' . $project['Project']['project_id']) . '\'" />'; ?>
				<ul id="issue-status-list">
					<?php /*
						echo '<li>' . $html->link('All', '/projects/' . $project['Project']['project_id'] . '/issues') . '</li>';
						foreach($_statuses AS $status)
						{
							echo '<li>' . $html->link($status['IssueStatus']['status'] . ' (' . ($status['sq']['total'] != null ? $status['sq']['total'] : 0) . ')', '/projects/' . $project['Project']['project_id'] . '/issues/' . urlencode(strtolower($status['IssueStatus']['status']))) . '</li>';
						}
					*/
					?>
				</ul>
                <?php

		echo '<p><strong>Filter:</strong></p>';
		echo $form->create(null, array('type' => 'get', 'url' => '/projects/' . $project['Project']['project_id'] . '/issues'));
		echo '<div class="input select">'.$form->select('status_id', $_statuses2, 0, array('empty' => 'By type...')) . '</div>';
		echo '<div class="input select">'.$form->select('priority_id', $priorities, null, array('empty' => 'By priority...')) . '</div>';
		echo $form->end('Filter');

              }  
		?>
			</div>

			-->

			<div id="center">
				<?php echo $content_for_layout; ?>
			</div>

		</div>
		<div id="footer">
			<?php
			if(isset($_project_id)) { 
				 echo '<span style="display: none" id="ajax-project-id">' . $_project_id . '</span>';
			}
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
