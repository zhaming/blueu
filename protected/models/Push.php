<?php
/**
 *	推送表
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class Push extends CActiveRecord {

    public $id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{push}}';
    }

    public function primaryKey() {
        return "id";
    }

}

