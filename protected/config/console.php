<?php
/**
 *	控制台配置入口
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

return array_merge_recursive(array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name' => 'Ming',
    
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.behaviors.*',
		'application.extensions.*',
        'application.extensions.baidupush.*',
	),

	'components' => array(
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error,warning,trace',
				),
				array(
					'class' => 'CWebLogRoute',
                    'levels' => 'error,warning',
					'showInFireBug' => true,
					'ignoreAjaxInFireBug' => true,
				),
			),
		),
	),
	'params'=>require('params.php'),
), require('db.php'));