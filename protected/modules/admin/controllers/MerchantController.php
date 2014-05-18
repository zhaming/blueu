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

    protected $merchantBehavior;

    public function init() {
        parent::init();
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

    public function actionCreate() {
        $message = '';
        $categoryBehavior = new CategoryBehavior();
        $merchantCreateForm = new MerchantCreateForm();
        if (Yii::app()->request->isPostRequest) {
            $merchantCreateForm->attributes = Yii::app()->request->getPost('merchant');
            if ($merchantCreateForm->save()) {
                $this->redirect('/admin/merchant/index');
            } else {
                $message = $merchantCreateForm->getError();
            }
        }
        $viewData = array(
            'message' => $message,
            'categories' => $categoryBehavior->getAll(),
            'merchant' => $merchantCreateForm->getAttributes()
        );
        $this->render('create', $viewData);
    }

    public function actionRegister() {
        $message = '';
        $this->layout = false;
        $merchantCreateForm = new MerchantCreateForm();
        if (Yii::app()->request->isPostRequest) {
            $merchantCreateForm->attributes = Yii::app()->request->getPost('merchant');
            if ($merchantCreateForm->save()) {
                $this->redirect('/admin/manager/login');
            } else {
                $message = $merchantCreateForm->getError();
            }
        }
        $viewData = array(
            'message' => $message,
            'merchant' => $merchantCreateForm->getAttributes()
        );
        $this->render('register', $viewData);
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

    public function actionEdit() {
        $id = '';
        $name = '';
        $describ = '';
        $pic = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getQuery('id');
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id' => $id));
            $model = Merchant::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作', $this->createUrl('index'));
            } else {
                $name = Yii::app()->request->getPost('name');
                $describ = Yii::app()->request->getPost('describ');
                $blueid = Yii::app()->request->getPost('blueid');
                if (!empty($name) && !empty($describ)) {
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
                } else {
                    $this->showError('请填写完整信息');
                }
            }
        } else {
            $criteria = new CDbCriteria;
            $id = Yii::app()->request->getQuery('id');
            $criteria->addColumnCondition(array('id' => $id));
            $model = Merchant::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作', $this->createUrl('index'));
            } else {
                $id = $model->id;
                $name = $model->name;
                $describ = $model->describ;
                $pic = $model->pic;
                $blueid = $model->blueid;
            }
        }
        $rc_station = BlueStation::model()->findAll();
        $this->render('edit', compact('id', 'name', 'describ', 'pic', 'blueid', 'rc_station'));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id' => $id));
            $model = Merchant::model()->find($criteria);
            if (!is_null($model)) {
                if ($model->delete()) {
                    $this->showSuccess('删除成功', $this->createUrl('index'));
                } else {
                    $this->showError('删除失败', $this->createUrl('index'));
                }
            }
        }
        $this->showError('非法操作', $this->createUrl('index'));
    }

}

?>
