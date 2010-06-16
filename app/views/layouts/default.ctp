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
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link(__('Issue Tracker', true), '/'); ?></h1>
		</div>

		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<div id="left">
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
                <?php
                if(isset($_statuses) AND isset($project))
                {
                ?>
				<p><?php echo '<input type="submit" name="create" value="Create Issue" onclick="window.location=\'' . $html->url('/issues/create/' . $project['Project']['project_id']) . '\'" />'; ?>
				<ul id="issue-status-list">
					<?php
						echo '<li>' . $html->link('All', '/projects/' . $project['Project']['project_id'] . '/issues') . '</li>';
						foreach($_statuses AS $status)
						{
							echo '<li>' . $html->link($status['IssueStatus']['status'] . ' (' . ($status['sq']['total'] != null ? $status['sq']['total'] : 0) . ')', '/projects/' . $project['Project']['project_id'] . '/issues/' . urlencode(strtolower($status['IssueStatus']['status']))) . '</li>';
						}
					?>
				</ul>
                <?php
                }
                ?>
			</div>

			<div id="center">
				<?php echo $content_for_layout; ?>
			</div>

		</div>
		<div id="footer">
			
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
