<?php
/**
 *	推送
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	
 *
 *	$Id$
 */

class PushController extends IController {

    public function init() {
        parent::init();
    }

    public function actionToshop() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['userid'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'UserId' . Yii::t('api', ' is not set');
            return;
        }
        if (!isset($data['uuid'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'UUID' . Yii::t('api', ' is not set');
            return;
        }
        $pushBehavoir = new PushBehavior();
        $rs = $pushBehavoir->userToShop($data);
        if (!$rs) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $pushBehavoir->getError();
        }
    }

    public function actionClick() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['pushid'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'PushID' . Yii::t('api', ' is not set');
            return;
        }
        $pushBehavoir = new PushBehavior();
        $rs = $pushBehavoir->userClick($data);
        if (!$rs) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $pushBehavoir->getError();
        }
    }
}