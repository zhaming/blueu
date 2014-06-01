<?php

/*
 * 商户API
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
        $pagesize = Yii::app()->request->getQuery('pagesize', 10);
        $merchants = $this->merchantBehavior->apiGetList($page, $pagesize);
        if (empty($merchants)) {
            $this->error_code = self::ERROR_NO_DATA;
            $this->message = Yii::t('admin', 'No data.');
            return;
        }
        $this->data = array();
        foreach ($merchants as $merchant) {
            $this->data[] = array(
                'id' => $merchant['id'],
                'name' => $merchant['name'],
                "legal" => $merchant['legal'],
                "telephone" => $merchant['telephone'],
                "bank" => $merchant['bank'],
                "shopnum" => $merchant['shopnum']
            );
        }
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
        $account = $this->checkToken();
        if (empty($account)) {
            return;
        }
        $merchant = $this->merchantBehavior->detail($merchantId);
        if (empty($merchant)) {
            $this->error_code = self::ERROR_NO_DATA;
            $this->message = $this->merchantBehavior->getError();
            return;
        }
        $this->data = array(
            'id' => $merchant['id'],
            'name' => $merchant['name'],
            "legal" => $merchant['legal'],
            "telephone" => $merchant['telephone'],
            "bank" => $merchant['bank'],
            "shopnum" => $merchant['shopnum']
        );
    }

}