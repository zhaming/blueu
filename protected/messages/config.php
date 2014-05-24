<?php

/*
 * 国际化配置
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.messages
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * config.php hugb
 *
 */
return array(
    'sourcePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'messagePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
    'languages' => array('zh_cn', 'zh_tw'),
    'fileTypes' => array('php'),
    'overwrite' => true,
    'exclude' => array(
        '.svn',
        '.gitignore',
        'yiilite.php',
        'yiit.php',
        '/i18n/data',
        '/messages',
        '/vendors',
        '/web/js',
    ),
);
