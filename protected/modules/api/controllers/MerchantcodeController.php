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

        $page       = Yii::app()->request->getParam('page', 1);
        $pagesize   = Yii::app()->request->getParam('pagesize', 10);
    }

    public function actionGetCoupon(){
        $codeid = Yii::app()->request->getParam("codeid");
        $userid = Yii::app()->request->getParam("userid");
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


    public function actionStampList(){

    }
    public function actionGetStamp(){

    }
}
