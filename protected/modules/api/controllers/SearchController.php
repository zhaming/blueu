<?php
class SearchController extends IController {

    const SHOP = "shop";
    const PRODUCT="product";
    const STAMP ='stamp';
    const COUPON = 'coupon';


    public function actionIndex(){
        $key = Yii::app()->request->getParam("key");
        $type = Yii::app()->request->getParam("type",self::SHOP);
        $page = Yii::app()->request->getParam("page",1);
        $pagesize = Yii::app()->request->getParam("pagesize",10);
        if(empty($key))
            return;

        $data['type']     = $type;
        $data['key']      = $key;
        $data['page']     = $page;
        $data['pagesize'] = $pagesize;
        $data['data']     = array();
        switch ($type) {
            case self::SHOP:
                break;
            case self::PRODUCT:
                break;
            case self::STAMP:
                break;
            case self::COUPON:
                break;
            default:
                break;
        }
    }

    private function getShopData($key){

    }


}