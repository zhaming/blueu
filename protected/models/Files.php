<?php

/*
 * 文件资源model
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
 * Files.php hugb
 *
 */
class Files extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{files}}';
    }

}

