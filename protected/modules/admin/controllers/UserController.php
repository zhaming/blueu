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
            if ($this->userBehavior->disable($id)) {
                $this->showSuccess(Yii::t('admin', 'Disable Success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Disable Failure'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('index'));
    }

    public function actionEnable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->userBehavior->enable($id)) {
                $this->showSuccess(Yii::t('admin', 'Restore Success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Restore Failure'), $this->createUrl('index'));
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
    
    public function actionEdit(){
        $this->render('edit');
    }

}
