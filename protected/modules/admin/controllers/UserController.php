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

    public function init() {
        parent::init();
        $this->userBehavior = new UserBehavior();
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
        $message = '';
        $userCreateForm = new UserCreateForm();
        if (Yii::app()->request->isPostRequest) {
            $userCreateForm->attributes = Yii::app()->request->getPost('user');
            if ($userCreateForm->save()) {
                $this->redirect('/admin/user/index');
            } else {
                $message = $userCreateForm->getError();
            }
        }
        $this->render('create', array('message' => $message, 'user' => $userCreateForm->getAttributes()));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->userBehavior->delete($id)) {
                $this->showSuccess('删除成功', $this->createUrl('index'));
            } else {
                $this->showError('删除失败', $this->createUrl('index'));
            }
        }
        $this->showError('非法请求', $this->createUrl('index'));
    }

    public function actionDisable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->userBehavior->disable($id)) {
                $this->showSuccess('禁用成功', $this->createUrl('index'));
            } else {
                $this->showError('禁用失败', $this->createUrl('index'));
            }
        }
        $this->showError('非法请求', $this->createUrl('index'));
    }

    public function actionEnable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->userBehavior->enable($id)) {
                $this->showSuccess('恢复成功', $this->createUrl('index'));
            } else {
                $this->showError('恢复失败', $this->createUrl('index'));
            }
        }
        $this->showError('非法请求', $this->createUrl('index'));
    }
    
    public function actionProfile() {
        $this->render('profile');
    }

    public function actionLogin() {
        
    }

    public function actionLogout() {
        
    }

}
