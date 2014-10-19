<?php

/*
 * 地图
 */

/**
 * 2014-6-1 15:38:45 UTF-8
 * @package application
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * Map.php hugb
 *
 */
class Map extends CActiveRecord {

    public $id;
    public $name;
    public $marketplace;
    public $floor;
    public $map;
    public $disabled;
    public $created;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{map}}';
    }

    public function primaryKey() {
        return "id";
    }

}
