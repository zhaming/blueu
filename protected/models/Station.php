<?php
/**
 *	蓝牙基站model
 *	@author		hugb <hu198021688500@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class Station extends CActiveRecord {

    public $id;
    public $uuid;
    public $mid;
    public $name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{station}}';
    }

    public function primaryKey() {
        return "id";
    }

    public function relations() {
        $relations = array(
            'merchant' => array(
                self::HAS_ONE, 'Merchant', 'blueid'
            ),
        );
        return $relations;
    }

}

