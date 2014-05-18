<?php

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