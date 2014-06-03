<?php

/*
 * 意见反馈
 */

/**
 * 2014-6-1 10:49:24 UTF-8
 * @package application
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * FeedbackController.php hugb
 *
 */
class FeedbackController extends BController {

    public $feedbackBehavior;

    public function init() {
        parent::init();
        $this->setPageTitle(Yii::t('admin', 'Feedback'));
        $this->feedbackBehavior = new FeedbackBehavior();
    }

    public function actionindex() {
        $this->render('index', $this->feedbackBehavior->getList());
    }

}
