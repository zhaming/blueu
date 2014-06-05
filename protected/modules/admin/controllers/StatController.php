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
    
    private $_stat;
    
    protected function beforeAction($action) {
        parent::beforeAction($action);
        $this->_stat = new StatBehavior();
        return true;
    }
    
    public function actionUser() {
        $this->render('user');
    }
    
    public function actionIndustry() {
        $this->render('industry');
    }
    
    public function actionShop() {
        $this->render('shop');
    }
}