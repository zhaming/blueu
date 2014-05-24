<?php

/*
 * 管理员
 */

/**
 * 2014-5-13 11:31:46 UTF-8
 * @package application.modules.admin.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * ManagerController.php hugb
 *
 */
class ManagerController extends BController {

    protected $accountBehavior;

    public function init() {
        parent::init();
        $this->accountBehavior = new AccountBehavior();
    }

    public function actionIndex() {
        $allAdminUsers = $this->accountBehavior->getAllAdmin();
        $this->render('index', array('data' => $allAdminUsers));
    }

    public function actionLogin() {
        $viewData = array();
        $this->layout = 'simple';
        $loginForm = new LoginForm();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['user'] = $loginForm->getAttributes();
            return $this->render("login", $viewData);
        }
        $loginForm->setAttributes(Yii::app()->request->getPost('user'));
        if (!$loginForm->validate()) {
            $viewData['message'] = $loginForm->getFirstError();
            $viewData['user'] = $loginForm->getAttributes();
            return $this->render("login", $viewData);
        }
        $identity = new AllUserIdentity($loginForm->username, $loginForm->password);
        if (!$identity->authenticate()) {
            $loginForm->unsetAttributes();
            $viewData['message'] = $identity->errorMessage;
            $viewData['user'] = $loginForm->getAttributes();
            return $this->render("login", $viewData);
        }
        $duration = $loginForm->rememberme == '1' ? 0 : 3600 * 24 * 1;
        Yii::app()->user->login($identity, $duration);
        $this->redirect('/admin');
    }

    public function actionFindpwd() {
        $this->layout = 'simple';
        if (!Yii::app()->request->isPostRequest) {
            return $this->render("findpwd");
        }
        $findPwdForm = new FindPwdForm();
        $findPwdForm->username = Yii::app()->request->getPost('username');
        if (!$findPwdForm->validate()) {
            return $this->render("findpwd", array('message' => $findPwdForm->getFirstError()));
        }
        if ($this->accountBehavior->sendResetPwdMail($findPwdForm->username)) {
            return $this->render("findpwd", array('message' => Yii::t('admin', 'Email send success.')));
        } else {
            return $this->render("findpwd", array('message' => Yii::t('admin', 'Email send failure.')));
        }
    }

    public function actionResetpwd() {
        $id = Yii::app()->request->getPost('id');
        $viewData = array('userid' => $id);
        if (!Yii::app()->request->isPostRequest) {
            return $this->render("resetpwd", $viewData);
        }
        $resetPwd = new ResetPwdForm();
        $resetPwd->id = $id;
        $resetPwd->newpassword = Yii::app()->request->getPost('newpassword');
        $resetPwd->repassword = Yii::app()->request->getPost('repassword');
        if (!$resetPwd->validate()) {
            $viewData['message'] = $resetPwd->getFirstError();
            return $this->render('resetpwd', $viewData);
        }
        if (!$this->accountBehavior->resetPwd($resetPwd->getAttributes())) {
            $viewData['message'] = $this->accountBehavior->getError();
            return $this->render('resetpwd', $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'Reset password success.'), $this->createUrl('index'));
    }

    public function actionProfile() {
        $viewData = array('error' => false);
        $userId = Yii::app()->user->getId();
        $viewData['account'] = $this->accountBehavior->getAccount($userId);
        if (!Yii::app()->request->isPostRequest) {
            return $this->render('profile', $viewData);
        }
        $resetPwd = new ResetPwdForm();
        $resetPwd->id = $userId;
        $resetPwd->password = Yii::app()->request->getPost('password');
        $resetPwd->newpassword = Yii::app()->request->getPost('newpassword');
        $resetPwd->repassword = Yii::app()->request->getPost('repassword');
        if (!$resetPwd->validate()) {
            $viewData['error'] = true;
            $viewData['message'] = $resetPwd->getFirstError();
            return $this->render('profile', $viewData);
        }
        if (!$this->accountBehavior->resetPwd($resetPwd->getAttributes())) {
            $viewData['error'] = true;
            $viewData['message'] = $this->accountBehavior->getError();
            return $this->render('profile', $viewData);
        }
        $viewData['message'] = Yii::t('admin', 'Reset password success.');
        $this->render('profile', $viewData);
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('/admin/manager/login');
    }

    public function actionCreate() {
        $viewData = array();
        $adminCreateForm = new AdminCreateForm();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['user'] = $adminCreateForm->getAttributes();
            return $this->render('create', $viewData);
        }
        $adminCreateForm->setAttributes(Yii::app()->request->getPost('user'));
        if (!$adminCreateForm->validate()) {
            $viewData['message'] = $adminCreateForm->getFirstError();
            $viewData['user'] = $adminCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        if (!$this->accountBehavior->addAdmin($adminCreateForm->getAttributes())) {
            $viewData['message'] = $this->accountBehavior->getError();
            $viewData['user'] = $adminCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $this->redirect('/admin/manager/index');
    }

    public function actionDisable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->accountBehavior->disable($id)) {
                $this->showSuccess(Yii::t('admin', 'Disable success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Disable failure'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('index'));
    }

    public function actionEnable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->accountBehavior->enable($id)) {
                $this->showSuccess(Yii::t('admin', 'Restore success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Restore failure'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('index'));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            if ($this->accountBehavior->delete($id)) {
                $this->showSuccess(Yii::t('admin', 'Delete Success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Delete Failure'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('index'));
    }

}
