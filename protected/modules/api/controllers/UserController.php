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
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method to submit data. to submit data.');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'username' . Yii::t('api', ' is not set.');
            return;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'password' . Yii::t('api', ' is not set.');
            return;
        }
        if ($this->accountBehavior->isExist($data['username'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = $data['username'] . Yii::t('api', ' is already taken.');
            return;
        }
        $user = $this->userBehavior->register($data);
        if (empty($user)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
            return;
        }
        $account = $this->accountBehavior->login($data, true);
        if (empty($account)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->accountBehavior->getError();
            return;
        }
        $this->data = array(
            'id' => $account['id'],
            'name' => $user['name'],
            'avatar' => HelpTemplate::getAvatarUrl($user['avatar']),
            'sex' => $user['sex'],
            'century' => $user['century'],
            'token' => $account['token']
        );
    }

    public function actionLogin() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method to submit data.');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'username' . Yii::t('api', ' is not set.');
            return;
        }
        if (!isset($data['password'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'password' . Yii::t('api', ' is not set.');
            return;
        }
        $account = $this->accountBehavior->login($data, true);
        if (empty($account)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->accountBehavior->getError();
            return;
        }
        $this->data = array(
            'id' => $account['id'],
            'token' => $account['token']
        );
        // 绑定设备信息
        $pushBehavoir = new PushBehavior();
        $pushBehavoir->bindDeviceInfo($account['id'], $data);
    }

    public function actionList() {
        if (Yii::app()->request->getRequestType() != 'GET') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use GET method to get data.');
            return;
        }
        $page = Yii::app()->request->getQuery('page', 1);
        $pagesize = Yii::app()->request->getQuery('pagesize', 10);
        $users = $this->userBehavior->apiGetList($page, $pagesize);
        if (empty($users)) {
            $this->error_code = self::ERROR_NO_DATA;
            $this->message = Yii::t('admin', 'No data.');
            return;
        }
        $this->data = array();
        foreach ($users as $user) {
            $this->data[] = array(
                'id' => $user['id'],
                'name' => $user['name'],
                'avatar' => HelpTemplate::getAvatarUrl($user['avatar']),
                'sex' => $user['sex'],
                'century' => $user['century']
            );
        }
    }

    public function actionDetail() {
        if (Yii::app()->request->getRequestType() != 'GET') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use GET method to get data.');
            return;
        }
        $userId = Yii::app()->request->getQuery('id');
        if (empty($userId)) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'userid' . Yii::t('api', ' is not set.');
            return;
        }
        $account = $this->checkToken();
        if (!$account) {
            return;
        }
        $user = $this->userBehavior->detail($userId);
        if (empty($user)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
            return;
        }
        $this->data = array(
            'id' => $user['id'],
            'name' => $user['name'],
            'avatar' => HelpTemplate::getAvatarUrl($user['avatar']),
            'sex' => $user['sex'],
            'century' => $user['century']
        );
    }

    public function actionResetpwd() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method to submit data.');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['password'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'password' . Yii::t('api', ' is not set.');
            return;
        }
        if (!isset($data['newpassword'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'newpassword' . Yii::t('api', ' is not set.');
            return;
        }
        $account = $this->checkToken();
        if (!$account) {
            return;
        }
        $data['id'] = $account['id'];
        if (!$this->accountBehavior->resetpwd($data)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->accountBehavior->getError();
        }
    }

    public function actionLogout() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method to submit data.');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['username'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'username' . Yii::t('api', ' is not set.');
            return;
        }
        $account = $this->checkToken();
        if (empty($account)) {
            return;
        }
        if (!$this->accountBehavior->logout($account['id'])) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->accountBehavior->getError();
        }
    }

    public function actionEdit() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method to submit data.');
            return;
        }
        $userId = Yii::app()->request->getQuery('id');
        if ($userId == null) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'userid' . Yii::t('api', ' is not set.');
            return;
        }
        $data = $this->getJsonFormData();
        $account = $this->checkToken();
        if (empty($account)) {
            return;
        }
        if ($userId != $account['id']) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = Yii::t('api', 'Illegal request.');
            return;
        }
        $data['id'] = $account[id];
        if (!$this->userBehavior->edit($data)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    public function actionPush() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method to submit data.');
            return false;
        }
        $userId = Yii::app()->request->getQuery('id');
        if ($userId == null) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'userid' . Yii::t('api', ' is not set.');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['enable'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'enable' . Yii::t('api', ' is not set.');
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
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'enable' . Yii::t('api', ' is not correct');
            return;
        }
        $account = $this->checkToken();
        if (empty($account)) {
            return;
        }
        if ($userId != $account['id']) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = Yii::t('api', 'Illegal request');
            return;
        }
        if (!$this->userBehavior->push($account['id'], $enable)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
        }
    }

    /**
     * 关注
     * @return boolean
     */
    public function actionLike() {
        if (Yii::app()->request->getIsPostRequest()) {
            $data = $this->getJsonFormData();
            if (!isset($data['source'])) {
                $this->error_code = self::ERROR_REQUEST_PARAMS;
                $this->message = 'source' . Yii::t('api', ' is not set.');
                return;
            }
            if (!isset($data['sid'])) {
                $this->error_code = self::ERROR_REQUEST_PARAMS;
                $this->message = 'sid' . Yii::t('api', ' is not set.');
                return;
            }
            $account = $this->checkToken();
            if (empty($account)) {
                return;
            }
            $data['userid'] = $account['id'];
            if (!$this->userBehavior->like($data)) {
                $this->error_code = self::ERROR_REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
            }
        }
        if (Yii::app()->request->getRequestType() == 'GET') {
            $account = $this->checkToken();
            if (empty($account)) {
                return;
            }
            $likes = $this->userBehavior->getLikesByUserId($account['id']);
            if (empty($likes)) {
                $this->error_code = self::ERROR_REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
                return;
            }
            $this->data = array();
            foreach ($likes as $like) {
                $this->data[] = array(
                    'id' => $like['id'],
                    'source' => $like['source'],
                    'sid' => $like['sid'],
                    'shopid' => $like['shopid'],
                    'created' => $like['created']
                );
            }
        }
    }

    public function actionShare() {
        if (Yii::app()->request->getIsPostRequest()) {
            $data = $this->getJsonFormData();
            if (!isset($data['source'])) {
                $this->error_code = self::ERROR_REQUEST_PARAMS;
                $this->message = 'source' . Yii::t('api', ' is not set.');
                return;
            }
            if (!isset($data['sid'])) {
                $this->error_code = self::ERROR_REQUEST_PARAMS;
                $this->message = 'sid' . Yii::t('api', ' is not set.');
                return;
            }
            $account = $this->checkToken();
            if (empty($account)) {
                return;
            }
            $data['userid'] = $account['id'];
            if (!$this->userBehavior->share($data)) {
                $this->error_code = self::ERROR_REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
            }
        }
        if (Yii::app()->request->getRequestType() == 'GET') {
            $account = $this->checkToken();
            if (empty($account)) {
                return;
            }
            $shares = $this->userBehavior->getSharesByUserId($account['id']);
            if (empty($shares)) {
                $this->error_code = self::ERROR_REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
                return;
            }
            $this->data = array();
            foreach ($shares as $share) {
                $this->data[] = array(
                    'id' => $share['id'],
                    'source' => $share['source'],
                    'sid' => $share['sid'],
                    'created' => $share['created']
                );
            }
        }
    }

    public function actionGrab() {
        if (Yii::app()->request->getIsPostRequest()) {
            $data = $this->getJsonFormData();
            if (!isset($data['source'])) {
                $this->error_code = self::ERROR_REQUEST_PARAMS;
                $this->message = 'source' . Yii::t('api', ' is not set.');
                return;
            }
            if (!isset($data['sid'])) {
                $this->error_code = self::ERROR_REQUEST_PARAMS;
                $this->message = 'sid' . Yii::t('api', ' is not set.');
                return;
            }
            $account = $this->checkToken();
            if (empty($account)) {
                return;
            }
            $data['userid'] = $account['id'];
            if (!$this->userBehavior->share($data)) {
                $this->error_code = self::ERROR_REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
            }
        }
        if (Yii::app()->request->getRequestType() == 'GET') {
            $account = $this->checkToken();
            if (empty($account)) {
                return;
            }
            $shares = $this->userBehavior->getSharesByUserId($account['id']);
            if (empty($shares)) {
                $this->error_code = self::ERROR_REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
                return;
            }
            $this->data = array();
            foreach ($shares as $share) {
                $this->data[] = array(
                    'id' => $share['id'],
                    'source' => $share['source'],
                    'sid' => $share['sid'],
                    'created' => $share['created']
                );
            }
        }
    }

    public function actionCoupon() {
        
    }

    public function actionStamp() {
        
    }

    public function actionNotice() {
        
    }

}
