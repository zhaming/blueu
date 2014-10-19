<?php

/*
 * 默认控制器
 */

/**
 * 2014-5-19 11:39:05 UTF-8
 * @package application.modeules.api.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * SiteController.php hugb
 *
 */
class SiteController extends IController {

    public function actionError() {
        $this->error_code = self::ERROR_INTERNAL_SERVER_ERROR;
        $error = Yii::app()->errorHandler->getError();
        if ($error != null) {
            $this->message = implode('\n', $error);
        }
    }

}