<?php

/*
 * 蓝牙基站model
 */

/**
 * 2014-5-13 16:46:08 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * Stations.php hugb
 *
 */
class Stations extends CActiveRecord {

    public $id;
    public $uuid;
    public $mid;
    public $name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{stations}}';
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

