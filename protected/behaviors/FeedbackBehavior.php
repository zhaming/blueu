<?php

/*
 * 意见反馈
 */

/**
 * 2014-5-20 14:53:23 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * FeedbackBehavior.php hugb
 *
 */
class FeedbackBehavior extends BaseBehavior {

    public function getList() {
        $criteria = new CDbCriteria();
        $count = Feedback::model()->count($criteria);

        $pager = new CPagination($count);
        $pager->setPageSize(self::DEFAULT_PAGE_SIZE);
        $pager->applyLimit($criteria);

        $data = Feedback::model()->findAll($criteria);

        return array('pager' => $pager, 'data' => $data);
    }

    public function create($data) {
        $feedback = new Feedback();
        $feedback->content = $data['content'];
        $feedback->contact = $data['contact'];
        if (isset($data['userid'])) {
            $feedback->userid = $data['userid'];
        }
        $feedback->created = time();
        return $feedback->save();
    }

}