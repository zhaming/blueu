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
        $this->render('manual');
    }
}