<?php
/**
 *商铺model
 *@author wzq
 */
class MerchantShop extends CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_shop}}';
    }

    public function primaryKey() {
        return "id";
    }
}