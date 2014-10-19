<?php

/*
 * 地图
 */

/**
 * 2014-6-1 15:36:05 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MapController.php hugb
 *
 */
class MapController extends BController {

    protected $mapBehavior;

    public function init() {
        parent::init();
        $this->setPageTitle(Yii::t('admin', 'Map'));
        $this->mapBehavior = new MapBehavior();
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
        $this->render('index', $this->mapBehavior->getList());
    }

    public function actionDisable() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            if ($this->mapBehavior->disable($id)) {
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
            if ($this->mapBehavior->enable($id)) {
                $this->showSuccess(Yii::t('admin', 'Restore success.'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Restore failure.'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request.'), $this->createUrl('index'));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            if ($this->mapBehavior->delete($id)) {
                $this->showSuccess(Yii::t('admin', 'Delete success.'), $this->createUrl('index'));
            } else {
                $this->showError(Yii::t('admin', 'Delete failure.'), $this->createUrl('index'));
            }
        }
        $this->showError(Yii::t('admin', 'Illegal request.'), $this->createUrl('index'));
    }

    public function actionUpload() {
        $viewData = array();
        $mapUploadForm = new MapUploadForm();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['map'] = $mapUploadForm->getAttributes();
            return $this->render("upload", $viewData);
        }
        $mapUploadForm->setAttributes(Yii::app()->request->getPost('map'));
        if (!$mapUploadForm->validate()) {
            $viewData['message'] = $mapUploadForm->getFirstError();
            $viewData['map'] = $mapUploadForm->getAttributes();
            return $this->render("upload", $viewData);
        }
        if (!$this->mapBehavior->upload($mapUploadForm->getAttributes())) {
            $viewData['message'] = $this->mapBehavior->getError();
            $viewData['map'] = $mapUploadForm->getAttributes();
            return $this->render("upload", $viewData);
        }
        $this->redirect('/admin/map/index');
    }

}
