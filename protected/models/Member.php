<?php

/*
 * 会员model
 */

/**
 * 2014-5-13 16:46:08 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * Member.php hugb
 *
 */
class Member extends CActiveRecord {

    public $uid;
    public $mid;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{member}}';
    }

    public function primaryKey() {
        return "id";
    }

}