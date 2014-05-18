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

    public function actionLogin() {
        $this->layout = '';
        if (Yii::app()->request->isPostRequest) {
            $username = Yii::app()->request->getPost("username");
            $password = Yii::app()->request->getPost("password");
            $rememberme = Yii::app()->request->getPost("rememberme");
            $identity = new AllUserIdentity($username, $password);
            if ($identity->authenticate()) {
                if (empty($rememberme)) {
                    $duration = 0;
                } else {
                    $duration = 3600 * 24 * 1;
                }
                Yii::app()->user->login($identity, $duration);
                $this->redirect('/admin');
            } else {
                $this->showError($identity->errorMessage, '/admin/manager/login');
            }
        } else {
            if (Yii::app()->user->isGuest) {
                $this->layout = "null";
                $this->render("login");
            } else {
                $this->redirect('/admin');
            }
        }
    }

    public function actionProfile() {
        $this->render('profile');
    }

    public function actionEdit() {
        $this->render('edit');
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
