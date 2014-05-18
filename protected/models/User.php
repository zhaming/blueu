<?php

/*
 * 用户model
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * User.php hugb
 *
 */
class User extends CActiveRecord {

    public $id;
    public $name;
    public $sex;
    public $mobile;
    public $period;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{user}}';
    }

    public function primaryKey() {
        return "id";
    }

    public function relations() {
        $relations = array(
            'account' => array(
                self::HAS_ONE, 'Account', 'id'
            )
        );
        return $relations;
    }

}

