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
        $duration = $loginForm->rememberme == 'on' ? 0 : 3600 * 24 * 1;
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

    public function actionProfile() {
        $viewData = array();
        $viewData['account'] = $this->accountBehavior->getAccount(Yii::app()->user->getId());
        $this->render('profile', $viewData);
    }

    public function actionEdit() {
        $viewData = array('message' => '');
        if (!Yii::app()->request->isPostRequest) {
            return $this->render('edit', $viewData);
        }
        $password = Yii::app()->request->getPost('password');
        $newPassword = Yii::app()->request->getPost('newpassword');
        $rePassword = Yii::app()->request->getPost('repassword');
        if (!empty($password) && !empty($newPassword) && !empty($rePassword)) {
            $resetPwd = new ResetPwdForm();
            $resetPwd->password = $password;
            $resetPwd->newpassword = $newPassword;
            $resetPwd->repassword = $rePassword;
            if (!$resetPwd->validate()) {
                $viewData['message'] = $resetPwd->getFirstError();
                return $this->render('edit', $viewData);
            }
            $resetPwd->id = Yii::app()->user->getId();
            if (!$this->accountBehavior->resetPwd($resetPwd->getAttributes())) {
                $viewData['message'] = $this->accountBehavior->getError();
                return $this->render('edit', $viewData);
            }
        }
        $this->redirect('/admin/manager/profile');
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('/admin/manager/login');
    }

    public function actionMypass() {
        if (!Yii::app()->request->isPostRequest) {
            $this->setPageTitle('修改我的密码');
            return $this->render('password');
        }
        $oldPwd = Yii::app()->request->getPost('oldpwd');
        $newPwd = Yii::app()->request->getPost('newpwd');
        $rePwd = Yii::app()->request->getPost('repwd');
        if (empty($newPwd) || empty($oldPwd) || empty($rePwd)) {
            $this->setPageTitle('修改我的密码');
            return $this->render('password');
        }
        if ($newPwd != $rePwd) {
            $this->showError("密码和确认密码不相同");
            return $this->render('password');
        }
        $id = Yii::app()->user->getId();
        if (Account::model()->changePass($id, $oldPwd, $newPwd)) {
            $this->showSuccess("修改成功");
            $this->actionLogout();
        } else {
            $this->showError("修改失败");
            $this->render('password');
        }
    }

    public function actionAddmanager() {
        if (Yii::app()->request->isPostRequest) {
            $manager = Yii::app()->request->getPost('manager');
            $status = Manager::model()->addManager($manager);
            if ($status > 0) {
                $this->showSuccess('添加成功');
            } else {
                $this->showError('添加失败');
            }
            $this->redirect(array('/admin/manager/list'));
        } else {
            $roles = Role::model()->roles();
            $this->render('add', array('roles' => $roles));
        }
    }

    public function actionDisable() {
        $id = Yii::app()->request->getQuery('id');
        $status = Manager::model()->changeStatus($id, 'disable');
        if ($status > 0) {
            $this->showSuccess('禁用成功');
        } else {
            $this->showError('禁用失败');
        }
        $this->redirect('/admin/manager/list');
    }

    public function actionEnable() {
        $id = Yii::app()->request->getQuery('id');
        $status = Manager::model()->changeStatus($id, 'enable');
        if ($status > 0) {
            $this->showSuccess('启用成功');
        } else {
            $this->showError('启用失败');
        }
        $this->redirect('/admin/manager/list');
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        print_r($id);
        print_r(Yii::app()->session['manager_id']);
        if ($id == Yii::app()->session['manager_id']) {
            $this->showError('不能对自己进行该操作');
        } else {
            $status = Manager::model()->deleteById($id);
            if ($status) {
                $this->showSuccess('删除操作成功');
            } else {
                $this->showError('删除操作失败');
            }
        }
        $this->redirect('/admin/manager/list');
    }

    public function actionList() {
        $data = Account::model()->managers();
        $this->render('list', array('data' => $data));
    }

}
