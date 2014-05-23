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
    
    public function init() {
        parent::init();
    }

    public function actionIndex() {
        $this->actionUser();
    }
    
    public function actionUser() {
        $this->render('user');
    }
    
    public function actionShop() {
        $this->render('shop');
    }

    public function actionIndustry() {
        $this->render('industry');
    }
}