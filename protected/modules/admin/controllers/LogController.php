<?php

/*
 * 日志管理
 */

/**
 * 2014-5-22 23:03:24 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * LogController.php hugb
 *
 */
class LogController extends BController {

    public function init() {
        parent::init();
        $this->setPageTitle(Yii::t('admin', 'Log manager'));
    }

    public function actionIndex() {
        $this->render('index');
    }

}
