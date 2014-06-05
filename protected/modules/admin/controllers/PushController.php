<?php
/**
 *	推送控制器
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class PushController extends BController {
    
    private $sourceMap = array();
    private $_push;
    
    protected function beforeAction($action) {
        parent::beforeAction($action);
        $this->_push = new PushBehavior();
        $this->sourceMap = array(
            1 => Yii::t('admin', 'Shop'),
            2 => Yii::t('admin', 'Product'),
            3 => Yii::t('admin', 'Coupon'),
            4 => Yii::t('admin', 'Stamp'),
        );
        return true;
    }

    public function actionList() {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->params->url_web.'js/html.js');
        
        $search = array(
            'to' => Yii::app()->request->getQuery('to'),
            'type' => Yii::app()->request->getQuery('type'),
            'start' => Yii::app()->request->getQuery('start'),
            'end' => Yii::app()->request->getQuery('end'),
        );
        $order = Yii::app()->request->getQuery('order');
        if(!empty($order)) $order = str_replace('order_', '', $order);
        $page = Yii::app()->request->getQuery('page');
        $result = $this->_push->listinfo($search, $order, $page);
        
        $this->setPageTitle(array(Yii::t('admin', 'VPushList')));
        $data = array(
            'types' => array_merge(array(""), Yii::app()->params->types['push']),
            'sourceMap' => $this->sourceMap,
            'list' => $result['list'],
            'pages' => $result['pages'],
        );
        $this->render('list', $data);
    }

    public function actionManual() {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->params->url_web.'js/html.js');
        
        $search = array(
            'source' => Yii::app()->request->getQuery('source'),
            'shopid' => Yii::app()->request->getQuery('shopid'),
            'start' => Yii::app()->request->getQuery('start'),
            'end' => Yii::app()->request->getQuery('end'),
        );
        $order = Yii::app()->request->getQuery('order');
        if(!empty($order)) $order = str_replace('order_', '', $order);
        $page = Yii::app()->request->getQuery('page');
        $result = $this->_push->manualList($search, $order, $page);
        
        $this->setPageTitle(array(Yii::t('admin', 'VManualList')));
        $sourceMap = $this->sourceMap;
        $sourceMap[0] = Yii::t('admin', 'VSource');
        ksort($sourceMap);
        $data = array(
            'sourceMap' => $sourceMap,
            'list' => $result['list'],
            'pages' => $result['pages'],
        );
        $this->render('manual', $data);
    }
    
    public function actionAdd() {
        $this->setPageTitle(array(Yii::t('admin', 'VManualAdd')));
        $viewData = array(
            'message' => null,
            'sourceMap' => $this->sourceMap,
        );
        $_form = new PushManualForm();
        $viewData['info'] = $_form->getAttributes();
        if (!Yii::app()->request->isPostRequest) {
            $viewData['info'] = array(
                'source' => Yii::app()->request->getQuery('source'),
                'sid' => Yii::app()->request->getQuery('sid'),
                'name' => Yii::app()->request->getQuery('name'),
                'shopid' => Yii::app()->request->getQuery('shopid'),
            );
            return $this->render("manuals", $viewData);
        }
        $info = Yii::app()->request->getPost('info');
        $_form->setAttributes($info);
        if (!$_form->validate()) {
            $viewData['message'] = $_form->getFirstError();
            return $this->render("manuals", $viewData);
        }
        $rs = $this->_push->manualAdd($_form->getAttributes());
        if (!$rs) {
            $viewData['message'] = Yii::t('admin', 'AAddFail');
            return $this->render("manuals", $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'AAddSuccess'), $this->createUrl('manual'));
    }
    
    public function actionEdit() {
        $this->setPageTitle(array(Yii::t('admin', 'VManualEdit')));
        $viewData = array(
            'message' => null,
            'sourceMap' => $this->sourceMap,
        );
        if (!Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getQuery('id');
            $info = $this->_push->getManualById($id);
            $viewData['info'] = $info;
            return $this->render('manuals', $viewData);
        }
        $_form = new PushManualForm();
        $info = Yii::app()->request->getPost('info');
        $_form->setAttributes($info);
        if (!$_form->validate()) {
            $viewData['message'] = $_form->getFirstError();
            $viewData['info'] = $_form->getAttributes();
            return $this->render('manuals', $viewData);
        }
        $rs = $this->_push->manualEdit($info['id'], $info);
        if (!$rs) {
            $viewData['message'] = Yii::t('admin', 'AEditFail');
            $viewData['info'] = $info;
            return $this->render("manuals", $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'AEditSuccess'), $this->createUrl('manual'));
    }
    
    public function actionDelete()
    {
        $id = Yii::app()->request->getQuery('id');
        $rs = $this->_push->manualDelete($id);
        if($rs){
            $this->showError(Yii::t('admin', 'ADelSuccess'), $this->createUrl('manual'));
        }else{
            $this->showError(Yii::t('admin', 'ADelFail'), $this->createUrl('manual'));
        }
    }
}