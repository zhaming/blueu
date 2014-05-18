<?php

/* 
 * 统计管理
 */

/**
 * 2014-5-12 16:42:28 UTF-8
 * @package application.modules.admin.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * StatisticsController.php hugb
 *
 */
class StatisticsController extends BController {

    public function actionIndex() {
        $this->render('index');
    }

}