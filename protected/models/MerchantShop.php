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
    public function relations() {
        $relations = array(
            'merchant' => array(
                self::HAS_ONE,
                'Merchant',
                array("id"=>"merchantid")
            ),
            // 'products' => array(
            //     self::MANY_MANY,
            //     'MerchantProduct',
            //     'merchant_shop_product(shopid，productid)',
            // ),
            'shop_product' =>array(
                self::HAS_MANY,
                "MerchantShopProduct",
                "shopid"
            )
        );
        return $relations;
    }
    
    public function getPicUrl() {
        if(empty($this->pic)) return '';
        return Yii::app()->params['host'] . Yii::app()->params['url_web'] . 'upload/original/' . $this->pic;
    }
}