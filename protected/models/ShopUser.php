<?php
/**
 *	到店用户
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class ShopUser extends CActiveRecord {

    public $id;
    public $name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{shop_user}}';
    }

    public function primaryKey() {
        return "id";
    }

}

