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

    public $userBehavior;

    public function init() {
        parent::init();
        $this->userBehavior = new UserBehavior();
    }

    public function actionRegister() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = '请使用POST';
            return false;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'username未设置';
            return false;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'password未设置';
            return false;
        }
        if (!isset($data['name'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'name未设置';
            return false;
        }
        if (!$this->userBehavior->regsiter($data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = '保存信息失败';
            return false;
        }
        return true;
    }

    public function actionLogin() {
        if (!(isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']))) {
            return false;
        }
        //$username = $_SERVER['PHP_AUTH_USER'];
        //$password = $_SERVER['PHP_AUTH_PW'];
    }

    public function actionEdit() {
        
    }

    public function actionResetpwd() {
        
    }

    public function actionLogout() {
        
    }

    public function actionFllow() {
        
    }

    public function actionShare() {
        
    }

    public function actionWelfare() {
        
    }

    public function actionCoupon() {
        
    }

    public function actionPrinting() {
        
    }

    public function actionNotice() {
        
    }

    public function actionPush() {
        
    }

}