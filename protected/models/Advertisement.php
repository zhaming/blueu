<?php

/*
 * 广告
 */

/**
 * 2014-5-20 14:33:33 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * Advertisement.php hugb
 *
 */
class Advertisement extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{advertisement}}';
    }

    public function primaryKey() {
        return "id";
    }

}

