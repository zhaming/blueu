<?php
/**
 *	数据库参数
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

return array(
    'components' => array(
        'db' => array(
            'class' => 'MSDbConnection',
            'emulatePrepare' => true,
            'enableParamLogging' => true,//false for production
            
            'connectionString' => 'mysql:host=localhost;port=3306;dbname=blueu2',
            'username' => 'root',
            'password' => 'mysql',
            'tablePrefix' => '',
            'charset' => 'utf8',
        ),
    ),
);
