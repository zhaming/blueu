<?php

/*
 * 活动管理
 */

/**
 * 2014-5-12 16:29:07 UTF-8
 * @package application.modules.admin.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * ActivityController.php hugb
 *
 */
class ActivityController extends BController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionTemplate() {
        $this->render('template');
    }

}