<?php

/*
 * 用户反馈
 */

/**
 * 2014-6-1 10:38:32 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * Feedback.php hugb
 *
 */
class Feedback extends CActiveRecord {

    public $id;
    public $content;
    public $contact;
    public $userid;
    public $created;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{feedback}}';
    }

    public function primaryKey() {
        return "id";
    }

    public function relations() {
        $relations = array(
            'account' => array(
                self::BELONGS_TO, 'Account', 'userid'
            )
        );
        return $relations;
    }

}
