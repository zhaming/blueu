<?php

/*
 * 商户api
 */

/**
 * 2014-5-20 11:04:30 UTF-8
 * @package application.modeules.api.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MerchantController.php hugb
 *
 */
class MerchantController extends IController {

    protected $merchantBehavior;

    public function init() {
        parent::init();
        $this->merchantBehavior = new MerchantBehavior();
    }

    public function actionList() {
        if (Yii::app()->request->getRequestType() != 'GET') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use GET method');
            return;
        }
        $page = Yii::app()->request->getQuery('page', 1);
        $pagesize = Yii::app()->request->getQuery('pagesize', 2);
        $data = $this->merchantBehavior->getlist(array(), $page, $pagesize);
        $this->data = $data['data'];
    }

    public function ActionDetail() {
        if (Yii::app()->request->getRequestType() != 'GET') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use GET method');
            return;
        }
        $merchantId = Yii::app()->request->getQuery('id');
        if ($merchantId == null) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'merchantid' . Yii::t('api', ' is not set');
            return;
        }
        $userData = $this->checkToken();
        if (!$userData) {
            return;
        }
        $merchant = $this->merchantBehavior->detail($merchantId);
        if (!$merchant) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->userBehavior->getError();
            return;
        }
        $this->data = $merchant;
    }

}