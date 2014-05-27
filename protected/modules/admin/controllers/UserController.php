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

    public function actionIndex() {
        $filter = array();
        $name = Yii::app()->request->getQuery('name');
        if (!empty($name)) {
            $filter['search'] = array('t.name' => $name);
        }
        $this->render('index', $this->userBehavior->getList($filter));
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

    public function actionProfile() {
        $this->render('profile');
    }

    public function actionLogin() {
        
    }

    public function actionLogout() {
        
    }

    public function actionEdit() {
        $viewData = array();
        $userId = Yii::app()->request->getQuery('id');
        $viewData['user'] = $this->userBehavior->detail($userId);
        $viewData['account'] = $this->accountBehavior->getAccount($userId);
        $this->render('edit', $viewData);
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
