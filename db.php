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
        'db1' => array(
            'emulatePrepare' => true,
            'enableParamLogging' => true,//false for production
<<<<<<< HEAD:db.php
            
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=blueu2',
=======
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=blueu',
>>>>>>> 65f9cbef2e1d0b1884389437eca0a310b5fdd0ee:protected/config/db.php
            'username' => 'root',
            'password' => 'mysql',
            'tablePrefix' => '',
            'charset' => 'utf8',
        ),
        'db' => array(
            'emulatePrepare' => true,
            'enableParamLogging' => true,//false for production
            'connectionString' => 'mysql:host=10.0.0.140;port=3306;dbname=blueu2',
            'username' => 'blueu2',
            'password' => 'blueu2',
            'tablePrefix' => '',
            'charset' => 'utf8',
        ),
    ),
);
