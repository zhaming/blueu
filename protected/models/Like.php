<?php

/*
 * 关注
 */

/**
 * 2014-5-19 17:14:25 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * Like.php hugb
 *
 */
class Like extends CActiveRecord {

    public $id;
    public $userid;
    public $source;
    public $sid;
    public $created;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{my_like}}';
    }

    public function primaryKey() {
        return "id";
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created = time();
            } else {
                
            }
            return true;
        } else {
            return false;
        }
    }

}