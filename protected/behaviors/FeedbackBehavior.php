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

    public function getList($filter = array(), $page = null, $pagesize = null) {
        return array();
    }

    public function create($data) {
        return true;
    }

}