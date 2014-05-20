<?php

/*
 * 广告API
 */

/**
 * 2014-5-20 14:23:12 UTF-8
 * @package application.modeules.api.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AdvertisementController.php hugb
 *
 */
class AdvertisementController extends IController {

    protected $advertisementBehavior;

    public function init() {
        parent::init();
        $this->advertisementBehavior = new AdvertisementBehavior();
    }

    public function actionDetail() {
        if (Yii::app()->request->getRequestType() != 'GET') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use GET method');
            return;
        }
        $adId = Yii::app()->request->getQuery('id');
        if ($adId == null) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'advertisementid' . Yii::t('api', ' is not set');
            return;
        }
        $advertisement = $this->advertisementBehavior->detail($adId);
        if (!$advertisement) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->advertisementBehavior->getError();
            return;
        }
        $this->data = $advertisement;
    }

}