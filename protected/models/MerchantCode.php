<?php
/**
 * 优惠券，印花 code表
 */
class MerchantCode extends  CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_code}}';
    }
}