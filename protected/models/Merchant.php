<?php

/*
 * 商户model
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
 * Merchant.php hugb
 *
 */
class Merchant extends CActiveRecord {

    public $id;
    public $name;
    public $legal;
    public $telephone;
    public $bank;
    public $shopnum;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{merchant}}';
    }

    public function primaryKey() {
        return "id";
    }

    public function relations() {
        $relations = array(
            'station' => array(
                self::HAS_MANY, 'BlueStation', 'id'
            ),
            'account' => array(
                self::HAS_ONE, 'Account', 'id'
            )
        );
        return $relations;
    }

}

