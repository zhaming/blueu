<?php
/**
 *商铺-商品关系表model
 *@author wzq
 */
class MerchantShopProduct extends CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_shop_product}}';
    }

    public function relations() {
        $relations = array(
            'shop' => array(
                self::BELONGS_TO,
                'MerchantShop',
                "shopid"
            ),
            'product' => array(
                self::BELONGS_TO,
                'MerchantProduct',
                "productid"
            )
        );
        return $relations;
    }
}