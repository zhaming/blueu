<?php

/*
 * 推送管理
 */

/**
 * 2014-5-12 16:37:57 UTF-8
 * @package application.modules.admin.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * PushController.php hugb
 *
 */
class PushController extends BController {

    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionList() {
        $this->render('index');
    }

    public function actionActive() {
        $this->render('index');
    }
}