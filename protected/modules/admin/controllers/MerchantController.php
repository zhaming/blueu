<?php

/*
 * 后台商户管理
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.modules.admin.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 *
 * MerchantController.php hugb
 *
 */
class MerchantController extends BController {

    protected $accountBehavior;
    protected $merchantBehavior;

    public function init() {
        parent::init();
        $this->setPageTitle(Yii::t('admin', 'Merchant manager'));
        $this->accountBehavior = new AccountBehavior();
        $this->merchantBehavior = new MerchantBehavior();
    }

    public function accessRules() {
        parent::accessRules();
        return array(
            array(
                'allow',
                'actions' => array('register', 'resetpwd'),
                'users' => array('*')
            ),
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
        $this->render('index', $this->merchantBehavior->getlist($filter));
    }

    public function actionDetail() {
        $viewData = array();
        $merchantId = Yii::app()->request->getQuery('id');
        $viewData['merchant'] = $this->merchantBehavior->detail($merchantId);
        $this->render('detail', $viewData);
    }

    public function actionEdit() {
        $viewData = array();
        if (!Yii::app()->request->isPostRequest) {
            $merchantId = Yii::app()->request->getQuery('id');
            $viewData['merchant'] = $this->merchantBehavior->detail($merchantId);
            return $this->render('edit', $viewData);
        }
        $merchantEditForm = new MerchantEditForm();
        $merchantEditForm->setAttributes(Yii::app()->request->getPost('merchant'));
        if (!$merchantEditForm->validate()) {
            $viewData['message'] = $merchantEditForm->getFirstError();
            $viewData['merchant'] = $merchantEditForm->getAttributes();
            return $this->render('edit', $viewData);
        }
        if (!$this->merchantBehavior->edit($merchantEditForm->getAttributes())) {
            $viewData['message'] = Yii::t('admin', 'Save failure.');
            $viewData['merchant'] = $merchantEditForm->getAttributes();
            return $this->render('edit', $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'Save success.'), $this->createUrl('detail?id=' . $merchantEditForm->id));
    }

    public function actionResetpwd() {
        $viewData = array();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['id'] = Yii::app()->request->getQuery('id');
            return $this->render('resetpwd', $viewData);
        }
        $resetPwdForm = new ResetPwdForm();
        $resetPwdForm->setAttributes(Yii::app()->request->getPost('merchant'));
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

    public function actionRegister() {
        $viewData = array();
        $this->layout = 'simple';
        $merchantCreateForm = new MerchantCreateForm();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['merchant'] = $merchantCreateForm->getAttributes();
            return $this->render("register", $viewData);
        }
        $merchantCreateForm->setAttributes(Yii::app()->request->getPost('merchant'));
        if (!$merchantCreateForm->validate()) {
            $viewData['message'] = $merchantCreateForm->getFirstError();
            $viewData['merchant'] = $merchantCreateForm->getAttributes();
            return $this->render("register", $viewData);
        }
        if (!$this->merchantBehavior->register($merchantCreateForm->getAttributes())) {
            $viewData['message'] = $this->merchantBehavior->getError();
            $viewData['merchant'] = $merchantCreateForm->getAttributes();
            return $this->render("register", $viewData);
        }
        $this->redirect('/admin/manager/login');
    }

    public function actionCreate() {
        $categoryBehavior = new CategoryBehavior();
        $viewData = array('categories' => $categoryBehavior->getAll());
        $merchantCreateForm = new MerchantCreateForm();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['merchant'] = $merchantCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $merchantCreateForm->setAttributes(Yii::app()->request->getPost('merchant'));
        if (!$merchantCreateForm->execute()) {
            $viewData['message'] = $merchantCreateForm->getFirstError();
            $viewData['merchant'] = $merchantCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $this->showSuccess(Yii::t("admin", "Create success."), $this->createUrl('index'));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            if ($this->accountBehavior->delete($id)) {
                $this->showSuccess(Yii::t('admin', 'Delete success.'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Delete failure.'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request.'), $this->createUrl('index'));
    }

    public function actionDisable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->accountBehavior->disable($id)) {
                $this->showSuccess(Yii::t('admin', 'Disable success.'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Disable failure.'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request.'), $this->createUrl('index'));
    }

    public function actionEnable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->accountBehavior->enable($id)) {
                $this->showSuccess(Yii::t('admin', 'Restore success.'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Restore failure.'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request.'), $this->createUrl('index'));
    }

}
