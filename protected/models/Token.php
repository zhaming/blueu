<?php

/*
 * token
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
 * Token.php hugb
 *
 */
class Token extends CActiveRecord {

    public $id;
    public $data;
    public $expires_at;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{token}}';
    }

    public function primaryKey() {
        return "id";
    }

}