<?php
/**
 *	Web端入口
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	
 *
 *	$Id$
 */

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',4);

require_once dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';
Yii::createWebApplication($config)->run();
