<?php

/*
 * 帐号
 */

/**
 * 2014-5-19 10:53:31 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * Account.php hugb
 *
 */
class Account extends CActiveRecord {

    public $id;
    public $username;
    public $password;
    public $roleid;
    public $status;
    public $registertime;
    public $logintime;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{account}}';
    }

    public function primaryKey() {
        return "id";
    }

    public function relations() {
        $relations = array(
            'user' => array(
                self::HAS_ONE, 'User', 'id'
            ),
        );
        return $relations;
    }

    public function changePass($id, $oldpwd, $newPwd) {
        return true;
    }

    public function managers() {
        return $this->findByAttributes(array('type' => 0));
    }

}

