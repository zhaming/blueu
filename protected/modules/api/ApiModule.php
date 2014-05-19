<?php

/*
 * API module
 */

/**
 * 2014-5-19 22:53:49 UTF-8
 * @package application.modules.api
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * ApiModule.php hugb
 *
 */
class ApiModule extends CWebModule {

    public $defaultController = 'site';
    public $layout = '';

    public function init() {
        parent::init();
        $this->setImport(array(
            'api.components.*'
        ));

        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => 'api/site/error',
            )
        ));
    }

}
