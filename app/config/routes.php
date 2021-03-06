<?php
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'projects', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	Router::connect('/admincp', array('controller' => 'admin', 'action' => 'index'));

	Router::connect('/api', array('controller' => 'api', 'action' => 'commit'));

	Router::connect('/user/:username',
		array('controller' => 'users', 'action' => 'profile'),
		array(
			'pass' => array('username')
		)
	);

Router::connect(
        '/projects/:id/issues',
        array('controller' => 'projects', 'action' => 'issues'),
        array(
            'pass' => array('id'),
            'id' => '[0-9]+'
        )
    );

	Router::connect(
		'/projects/:id/users'
		,array('controller' => 'projects', 'action' => 'users')
		, array(
			'pass' => array('id')
			,'id' => '[0-9]+'
		)
	);

    Router::connect(
        '/projects/:id/issues/:status',
        array('controller' => 'projects', 'action' => 'issues', 'status' => null),
        array(
            'pass' => array('id', 'status'),
            'id' => '[0-9]+'
        )
    );

    Router::connect(
        '/projects/:pid/issue/:iid',
        array('controller' => 'issues', 'action' => 'view'),
        array(
            'pass' => array('iid'),
            'pid' => '[0-9]+',
            'iid' => '[0-9]+'
        )
    );

    //Router::connect('/projects/{[\d]+}', array('controller' => 'pages', 'action' => 'display'));
?>
