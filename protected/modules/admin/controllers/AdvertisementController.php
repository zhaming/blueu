<?php

/*
 * 广告
 */

/**
 * 2014-5-27 23:10:11 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AdvertisementController.php hugb
 *
 */
class AdvertisementController extends BController {

    protected $advertisementBehavior;

    public function init() {
        parent::init();
        $this->setPageTitle(Yii::t('admin', 'Advertisement manager'));
        $this->advertisementBehavior = new AdvertisementBehavior();
    }

    public function actionIndex() {
        Yii::log('get ad list', 'info', 'savetodb');
        $filter = array();
        $this->render('index', $this->advertisementBehavior->getList1($filter));
    }

    public function actionCreate() {
        $viewData = array();
        $adCreateForm = new AdCreateForm();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['advertisement'] = $adCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $adCreateForm->setAttributes(Yii::app()->request->getPost('advertisement'));
        if (!$adCreateForm->validate()) {
            $viewData['message'] = $adCreateForm->getFirstError();
            $viewData['advertisement'] = $adCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        if (!$this->advertisementBehavior->create($adCreateForm->getAttributes())) {
            $viewData['message'] = $this->advertisementBehavior->getError();
            $viewData['user'] = $adCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $this->redirect('/admin/advertisement/index');
    }

    public function actionDetail() {
        $viewData = array();
        $id = Yii::app()->request->getQuery('id');
        $viewData['ad'] = $this->advertisementBehavior->detailById($id);
        $this->render('detail', $viewData);
    }

    public function actionEdit() {
        $viewData = array();
        if (!Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getQuery('id');
            $viewData['ad'] = $this->advertisementBehavior->detailById($id);
            return $this->render('edit', $viewData);
        }
        $adEditForm = new AdEditForm();
        $adEditForm->setAttributes(Yii::app()->request->getPost('ad'));
        if (!$adEditForm->validate()) {
            $viewData['message'] = $adEditForm->getFirstError();
            $viewData['ad'] = $adEditForm->getAttributes();
            return $this->render('edit', $viewData);
        }
        if (!$this->advertisementBehavior->edit($adEditForm->getAttributes())) {
            $viewData['message'] = $this->advertisementBehavior->getError();
            $viewData['user'] = $adEditForm->getAttributes();
            return $this->render('edit', $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'Save success.'), $this->createUrl('index'));
    }

    public function actionDisable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->advertisementBehavior->disable($id)) {
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
            if ($this->advertisementBehavior->enable($id)) {
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
            if ($this->advertisementBehavior->delete($id)) {
                $this->showSuccess(Yii::t('admin', 'Delete Success'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Delete Failure'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('index'));
    }

}
