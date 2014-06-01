<?php

/*
 * 意见反馈API
 */

/**
 * 2014-5-20 14:51:14 UTF-8
 * @package application.modeules.api.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * FeedbackController.php hugb
 *
 */
class FeedbackController extends IController {

    protected $feedbackBehavior;

    public function init() {
        parent::init();
        $this->feedbackBehavior = new FeedbackBehavior();
    }

    public function actionCreate() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['content'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'content' . Yii::t('api', ' is not set');
            return;
        }

        $account = $this->checkToken();
        if ($account) {
            $data['userid'] = $account['id'];
        }

        if (!$this->feedbackBehavior->create($data)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->feedbackBehavior->getError();
        }
    }

}