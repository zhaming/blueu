<?php

return array_merge_recursive(array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'language' => 'zh_cn',
    'sourceLanguage' => 'en_us',
    'name' => '',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.behaviors.*',
        'application.widgets.*',
        'application.extensions.*',
        'application.extensions.helpers.*',
    ),
    'modules' => array(
        'admin' => array(
            'class' => 'application.modules.admin.AdminModule'
        ), // uncomment the following to enable the Gii tool
        'api' => array(
            'class' => 'application.modules.api.ApiModule'
        ), // uncomment the following to enable the Gii tool
    ),
    // application components
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                'images/<name>' => 'files/image',
                'download/<name>' => 'files/index',
                'search/<keyword>' => 'search/index',
                // reset api
                array('api/user/edit', 'pattern' => 'api/user/<id:\d+>/edit', 'verb' => 'POST'),
                array('api/user/push', 'pattern' => 'api/user/<id:\d+>/push', 'verb' => 'POST'),
                // get user list
                'api/users' => 'api/user/list',
                // get user detail
                array('api/user/detail', 'pattern' => 'api/user/<id:\d+>'),
                // get merchant list
                'api/merchants' => 'api/merchant/list',
                // get merchant detail
                array('api/merchant/detail', 'pattern' => 'api/merchant/<id:\d+>'),
                // get ad detail
                array('api/advertisement/detail', 'pattern' => 'api/ad/<id:\d+>'),
            //array('api/update', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'PUT'),
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
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
                    'categories' => 'system.db.*',
                    'showInFireBug' => true,
                    'ignoreAjaxInFireBug' => true,
                ),
                array(
                    'class' => 'CDbLogRoute',
                    'connectionID' => 'db',
                    'levels' => 'info, warning, error, profile, debug',
                    'logTableName' => 'syslog',
                    'categories' => 'savetodb'
                ),
            ),
        ),
    ),
    'params' => require('params.php'),
        ), require('db.php'));
