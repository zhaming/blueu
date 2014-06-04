<?php

/*
 * 后台用户管理
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
class UserController extends BController {

    protected $userBehavior;
    protected $accountBehavior;

    public function init() {
        parent::init();
        $this->setPageTitle(Yii::t('admin', 'Client user'));
        $this->userBehavior = new UserBehavior();
        $this->accountBehavior = new AccountBehavior();
    }

    public function accessRules() {
        parent::accessRules();
        return array(
            array(
                'allow',
                'users' => array('@'),
                'expression' => array($this, 'isAdmin'),
            ),
            array('deny',
                'users' => array('*')
            )
        );
    }

    public function actionIndex() {
        $filter = array('search' => array());
        $name = Yii::app()->request->getQuery('name');
        $username = Yii::app()->request->getQuery('username');
        if (!empty($name)) {
            $filter['search']['t.name'] = $name;
        }
        if (!empty($username)) {
            $filter['search']['account.username'] = $username;
        }
        $this->render('index', $this->userBehavior->getList($filter));
    }

    public function actionDetail() {
        $viewData = array();
        $userId = Yii::app()->request->getQuery('id');
        $viewData['user'] = $this->userBehavior->detail($userId);
        $this->render('detail', $viewData);
    }

    public function actionEdit() {
        $viewData = array();
        if (!Yii::app()->request->isPostRequest) {
            $userId = Yii::app()->request->getQuery('id');
            $user = $this->userBehavior->detail($userId);
            $viewData['user'] = array();
            $viewData['user']['id'] = $user->id;
            $viewData['user']['name'] = $user->name;
            $viewData['user']['status'] = $user->account->status;
            return $this->render('edit', $viewData);
        }
        $userEditForm = new UserEditForm();
        $userEditForm->setAttributes(Yii::app()->request->getPost('user'));
        if (!$userEditForm->validate()) {
            $viewData['message'] = $userEditForm->getFirstError();
            $viewData['user'] = $userEditForm->getAttributes();
            return $this->render('edit', $viewData);
        }
        $userData = array(
            'id' => $userEditForm->id,
            'name' => $userEditForm->name
        );
        if (!$this->userBehavior->edit($userData)) {
            $viewData['message'] = $this->userBehavior->getError();
            $viewData['user'] = $userEditForm->getAttributes();
            return $this->render('edit', $viewData);
        }
        $accountData = array(
            'id' => $userEditForm->id,
            'status' => $userEditForm->status
        );
        if (!$this->accountBehavior->edit($accountData)) {
            $viewData['message'] = $this->accountBehavior->getError();
            $viewData['user'] = $userEditForm->getAttributes();
            return $this->render('edit', $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'Save success.'), $this->createUrl('detail?id=' . $userEditForm->id));
    }

    public function actionResetpwd() {
        $viewData = array();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['id'] = Yii::app()->request->getQuery('id');
            return $this->render('resetpwd', $viewData);
        }
        $resetPwdForm = new ResetPwdForm();
        $resetPwdForm->setAttributes(Yii::app()->request->getPost('user'));
        $viewData['id'] = $resetPwdForm->id;
        if (!$resetPwdForm->validate()) {
            $viewData['message'] = $resetPwdForm->getFirstError();
            return $this->render('resetpwd', $viewData);
        }
        if (!$this->accountBehavior->resetPwd($resetPwdForm->getAttributes())) {
            $viewData['message'] = Yii::t('admin', 'Reset password failure.');
            return $this->render('resetpwd', $viewData);
        }
        $this->redirect($this->createUrl('detail?id=' . $resetPwdForm->id));
    }

    public function actionCreate() {
        $viewData = array('message' => null);
        $userCreateForm = new UserCreateForm();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['user'] = $userCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $userCreateForm->setAttributes(Yii::app()->request->getPost('user'));
        if (!$userCreateForm->validate()) {
            $viewData['message'] = $userCreateForm->getFirstError();
            $viewData['user'] = $userCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        if (!$this->userBehavior->register($userCreateForm->getAttributes())) {
            $viewData['message'] = $this->userBehavior->getError();
            $viewData['user'] = $userCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $this->redirect('/admin/user/index');
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

    public function actionEnablePush() {
        $userId = Yii::app()->request->getQuery('id');
        if (!empty($userId)) {
            if ($this->userBehavior->push($userId, 1)) {
                $this->showSuccess(Yii::t('admin', 'Enable push success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Enable push failure'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('index'));
    }

    public function actionDisablePush() {
        $userId = Yii::app()->request->getQuery('id');
        if (!empty($userId)) {
            if ($this->userBehavior->push($userId, 0)) {
                $this->showSuccess(Yii::t('admin', 'Disable push success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Disable push failure'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('index'));
    }

}
