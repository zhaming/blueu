<?php

/*
 * 用户API
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * UserController.php hugb
 *
 */
class UserController extends IController {

    public function actionRegister() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = '请使用POST';
            return;
        }
        $data = $this->getJsonFormData();
        $this->data = $data;
    }

    public function actionLogin() {
        if (!(isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']))) {
            return false;
        }
        //$username = $_SERVER['PHP_AUTH_USER'];
        //$password = $_SERVER['PHP_AUTH_PW'];
    }

    public function actionLogout() {
        
    }

}