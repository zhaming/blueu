<?php

class MerchantcodeController extends IController {

    public function init(){
        parent::init();
    }

    /*
    *优惠券列表
    *
    */
    public function actionCouponList(){

        $page     = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', 10);
        $shopid   = Yii::app()->request->getParam("shopid");

        $couponBehavior = new MerchantCouponBehavior;

        $ar['page']     = $page;
        $ar['pageSize'] = $pagesize;
        $ar['shopid']   = $shopid;
        $res = $couponBehavior->getList($ar);
        $this->data =  array();
        if(!empty($res['data'])){
            $this->data = $res['data'];
        }
    }

/**
 * 我的优惠券
 */
    public function actinoMyCoupon(){

        $page     = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', 10);
        $shopid   = Yii::app()->request->getParam("shopid");

        $ar['page']     = $page;
        $ar['pageSize'] = $pagesize;
        $ar['shopid']   = $shopid;
    }


    /**
     * 获取优惠券
     */
    public function actionGetCoupon(){

        if (Yii::app()->request->getRequestType() != 'POST') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $codeid = Yii::app()->request->getPost("codeid");
        $userid = Yii::app()->request->getPost("userid");

        if(empty($codeid) ){
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            return;
        }
        if(empty($userid)){
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            return;
        }

        $res  = MerchantCodeLog::model()->isHave($codeid,$userid);
        if($res){
            $this->error_code = self::ERROR_NO_DATA;
            $this->message ="该用户已经获取了此种优惠券.";
            return;
        }

        $obj = new MerchantCodeLog;

        $obj->userid = $userid;
        $obj->codeid= $codeid;
        $obj->gettime = time();

        $obj->save();

        //Validate user is get this code;
    }

/**
 * 印花列表
 */
    public function actionStampList(){

        $page     = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', 10);
        $shopid   = Yii::app()->request->getParam("shopid");

        $stampBehavior = new MerchantStampBehavior;

        $ar['page']     = $page;
        $ar['pageSize'] = $pagesize;
        $ar['shopid']   = $shopid;
        $res = $stampBehavior->getList($ar);
        $this->data =  array();
        if(!empty($res['data'])){
            $this->data = $res['data'];
        }

    }
    public function actionGetStamp(){

    }
}
