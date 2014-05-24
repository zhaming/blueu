<?php
/**
 *	用户推送扩展表
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class UserExt extends CActiveRecord {

    public $id;
    public $name;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{user_ext}}';
    }

    public function primaryKey() {
        return "userid";
    }

    public function relations() {
        $relations = array(
            'user' => array(
                self::HAS_ONE, 'User', 'id'
            )
        );
        return $relations;
    }
}

