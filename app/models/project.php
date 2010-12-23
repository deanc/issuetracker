<?php
/**
 * Created by IntelliJ IDEA.
 * User: DC
 * Date: 08-May-2010
 * Time: 21:44:07
 * To change this template use File | Settings | File Templates.
 */

class Project extends AppModel {

    var $useTable = 'project';
    var $primaryKey = 'project_id';

	var $hasAndBelongsToMany = array(
		'User' => array('with' => 'ProjectUser')
	);

/*
     var $hasAndBelongsToMany = array(
            'User' =>
                array(
                    'className'              => 'User',
                    'joinTable'              => 'project_user',
                    'foreignKey'             => 'project_id',
                    'associationForeignKey'  => 'user_id',
                    'unique'                 => true,
                    'conditions'             => '',
                    'fields'                 => '',
                    'order'                  => '',
                    'limit'                  => '',
                    'offset'                 => '',
                    'finderQuery'            => '',
                    'deleteQuery'            => '',
                    'insertQuery'            => ''
                )
        );
		*/
}
