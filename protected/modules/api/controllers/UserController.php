<?php

/*
 * 用户API
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.modeules.api.controllers
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

    public function init() {
        parent::init();
    }

    public function actionRegister() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'username' . Yii::t('api', ' is not set');
            return;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'password' . Yii::t('api', ' is not set');
            return;
        }
        if (!isset($data['name'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'name' . Yii::t('api', ' is not set');
            return;
        }
        if (!$this->userBehavior->regsiter($data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    public function actionLogin() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'username' . Yii::t('api', ' is not set');
            return;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'password' . Yii::t('api', ' is not set');
            return;
        }
        $user = $this->userBehavior->apiLogin($data);
        if (!$user) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
            return;
        }
        $tokenId = $this->tokenBehavior->save($user);
        if (!$tokenId) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->tokenBehavior->getError();
            return;
        }
        $this->data = array('token_id' => $tokenId);
    }

    public function actionResetpwd() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['password'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'password' . Yii::t('api', ' is not set');
            return;
        }
        if (!isset($data['newpassword'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'newpassword' . Yii::t('api', ' is not set');
            return;
        }
        $userData = $this->checkToken();
        if (!$userData) {
            return;
        }
        $data['username'] = $userData['username'];
        if (!$this->userBehavior->resetpwd($data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    public function actionLogout() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'username' . Yii::t('api', ' is not set');
            return;
        }
        $userData = $this->checkToken();
        if (!$userData) {
            return;
        }
        if (!isset($userData['token_id'])) {
            return;
        }
        $data['token_id'] = $userData['token_id'];
        if (!$this->userBehavior->apiLogout($data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    public function actionEdit() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        $userData = $this->checkToken();
        if (!$userData) {
            return;
        }
        if (!$this->userBehavior->edit($userData['id'], $data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    public function actionPush() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST method');
            return false;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['enable'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'enable' . Yii::t('api', ' is not set');
            return;
        }
        $enable = null;
        if (in_array($data['enable'], array(0, '0', 'false', 'False', 'off', 'Off'))) {
            $enable = 0;
        }
        if (in_array($data['enable'], array(1, '1', 'true', 'True', 'on', 'On'))) {
            $enable = 1;
        }
        if ($enable == null) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'enable' . Yii::t('api', ' is not correct');
            return;
        }
        $userData = $this->checkToken();
        if (!$userData) {
            return;
        }
        if (!$this->userBehavior->push($userData['id'], $enable)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    public function actionLike() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::REQUEST_METHOD_ERROR;
            $this->message = Yii::t('api', 'Please use POST method');
            return false;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['source'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'source' . Yii::t('api', ' is not set');
            return;
        }
        if (!isset($data['sid'])) {
            $this->error_code = self::REQUEST_PARAMS_ERROR;
            $this->message = 'sid' . Yii::t('api', ' is not set');
            return;
        }
        $userData = $this->checkToken();
        if (!$userData) {
            return;
        }
        $data['userid'] = $userData['id'];
        if (!$this->userBehavior->like($data)) {
            $this->error_code = self::REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    public function actionShare() {
        
    }

    public function actionWelfare() {
        
    }

    public function actionCoupon() {
        
    }

    public function actionStamp() {
        
    }

    public function actionNotice() {
        
    }

}