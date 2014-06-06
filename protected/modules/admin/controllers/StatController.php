<?php
/**
 *	统计控制器
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	protected.modules.admin.controllers
 *
 *	$Id$
 */

class StatController extends BController {
    
    static $statMap = array(
        'user' => array('info', 'convert', 'share'),
        'industry' => array('total', 'shoptop', 'industrytop', 'coupontop', 'stamptop'),
        'shop' => array('toshop', 'coupontop', 'stamptop', 'realtime'),
    );
    private $_stat;
    
    protected function beforeAction($action) {
        parent::beforeAction($action);
        $this->_stat = new StatBehavior();
        return true;
    }
    
    public function actionUser() {
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[Yii::app()->controller->id]) ? 'info' : $t;
        echo $t;
        $this->render('user');
    }
    
    public function actionUserData() {
        echo __METHOD__;
    }
    
    public function actionIndustry() {
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[Yii::app()->controller->id]) ? 'info' : $t;
        echo $t;
        $this->render('industry');
    }
    
    public function actionShop() {
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[Yii::app()->controller->id]) ? 'info' : $t;
        echo $t;
        $this->render('shop');
    }
}