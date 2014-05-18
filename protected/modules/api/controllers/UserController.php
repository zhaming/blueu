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
            $this->message = Yii::t('api', 'Please use POST');
            return false;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Username no set');
            return false;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Password no set');
            return false;
        }
        if (!isset($data['name'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Name no set');
            return false;
        }
        if (!$this->userBehavior->regsiter($data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
            return false;
        }
        return true;
    }

    public function actionLogin() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST');
            return false;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Username no set');
            return false;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Password no set');
            return false;
        }
        $token = $this->userBehavior->apiLogin($data);
        if (!$token) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
            return false;
        }
        return true;
    }

    public function actionEdit() {
        
    }

    public function actionResetpwd() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST');
            return false;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Username no set');
            return false;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Password no set');
            return false;
        }
        if (!isset($data['newpassword'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = Yii::t('api', 'Newpassword no set');
            return false;
        }
        if (!$this->userBehavior->resetpwd($data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
            return false;
        }
        return true;
    }

    public function actionLogout() {
        
    }

    public function actionLike() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST');
            return false;
        }
        if (isset($_SERVER['TOKEN'])) {
            
        } else {
            if (!(isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']))) {
                return false;
            }
            //$username = $_SERVER['PHP_AUTH_USER'];
            //$password = $_SERVER['PHP_AUTH_PW'];
        }
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