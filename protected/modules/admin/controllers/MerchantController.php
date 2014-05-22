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
        $this->accountBehavior = new AccountBehavior();
        $this->merchantBehavior = new MerchantBehavior();
    }

    public function actionIndex() {
        $filter = array();
        $name = Yii::app()->request->getQuery('name');
        if (!empty($name)) {
            $filter['search'] = array('t.name' => $name);
        }
        $viewData = $this->merchantBehavior->getlist($filter);
        $viewData['name'] = $name;
        $this->render('index', $viewData);
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
        if (!$merchantCreateForm->validate()) {
            $viewData['message'] = $merchantCreateForm->getFirstError();
            $viewData['merchant'] = $merchantCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        if (!$this->merchantBehavior->register($merchantCreateForm->getAttributes())) {
            $viewData['message'] = $this->merchantBehavior->getError();
            $viewData['merchant'] = $merchantCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $this->redirect($this->createUrl('index'));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
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

    public function actionEdit() {
        $viewData = array();
        $userId = Yii::app()->request->getQuery('id');
        $viewData['user'] = $this->merchantBehavior->detail($userId);
        $this->render('edit', $viewData);
    }

    public function actionActivity() {
        $this->render('activity');
    }

    public function actionStations() {
        $this->render('stations');
    }

    public function actionMember() {
        $this->render('member');
    }

    public function actionAdd() {
        $id = '';
        $name = '';
        $describ = '';
        $pic = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id');
            $name = Yii::app()->request->getPost('name');
            $describ = Yii::app()->request->getPost('describ');
            // $pic = Yii::app()->request->getPost('pic');
            $blueid = Yii::app()->request->getPost('blueid');
            if (!empty($id) && !empty($name) && !empty($describ) && !empty($blueid)) {
                $criteria = new CDbCriteria;
                $criteria->addColumnCondition(array('id' => $id));
                if (Merchant::model()->exists($criteria)) {
                    $this->showError('商户编号已存在, 请重新指定');
                } else {
                    $model = new Merchant;
                    $model->id = $id;
                    $model->name = $name;
                    $model->describ = $describ;
                    $model->blueid = $blueid;
                    $file_cpt = new FilesComponent;
                    $upload_ret = $file_cpt->upload('pic');
                    if ($upload_ret) {
                        $model->pic = $upload_ret['hash'];
                    }
                    if ($model->save()) {
                        $this->showSuccess('保存成功', $this->createUrl('edit?id=' . $id));
                    } else {
                        $this->showError('保存失败');
                    }
                }
            } else {
                $this->showError('请填写完整信息');
            }
        }
        $blueid = Yii::app()->request->getQuery('blueid');
        $rc_station = BlueStation::model()->findAll();
        $this->render('add', compact('id', 'name', 'describ', 'pic', 'blueid', 'rc_station'));
    }

}
