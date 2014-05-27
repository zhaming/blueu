<?php

/*
 * 系统管理
 */

/**
 * 2014-5-12 16:40:28 UTF-8
 * @package application.modules.admin.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * SysController.php hugb
 *
 */
class SysController extends BController {

    public function init() {
        parent::init();
    }

    public function actionIndex() {
        $this->render('index');
    }

}