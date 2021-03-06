<?php

class MerchantcodeController extends IController {

    private $pageSize;

    public function init() {
        parent::init();
        $this->pageSize = Yii::app()->params->page_size;
    }

    /*
     * 优惠券列表
     *
     */

    public function actionCouponList() {

        $page = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', $this->pageSize);
        $shopid = Yii::app()->request->getParam("shopid");

        $couponBehavior = new MerchantCouponBehavior;

        $ar['page'] = $page;
        $ar['pageSize'] = $pagesize;
        $ar['shopid'] = $shopid;
        $res = $couponBehavior->getList($ar);

        $data = array();
        if (!empty($res['data'])) {
            foreach ($res['data'] as $key => $value) {
                if (!empty($value->pic)) {
                    $value->pic = HelpTemplate::getAdUrl($value->pic);
                }
                $data[] = $value;
            }
        }
        $this->data = $data;
    }

    /**
     * 我的优惠券
     */
    public function actinoMyCoupon() {

        $page = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', $this->pageSize);
        $shopid = Yii::app()->request->getParam("shopid");

        $ar['page'] = $page;
        $ar['pageSize'] = $pagesize;
        $ar['shopid'] = $shopid;
    }

    /**
     * 获取优惠券
     */
    public function actionGetCoupon() {
        if (Yii::app()->request->getRequestType() != 'POST') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $codeid = Yii::app()->request->getPost("codeid");
        $userid = Yii::app()->request->getPost("userid");
        if (empty($codeid)) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'codeid' . Yii::t('api', ' is not set.');
            return;
        }
        if (empty($userid)) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            return;
        }

        $res = MerchantCodeLog::model()->isHave($codeid, $userid);
        if ($res) {
            $this->error_code = self::ERROR_NO_DATA;
            $this->message = "该用户已经获取了此种优惠券.";
            return;
        }

        $obj = new MerchantCodeLog;

        $obj->userid = $userid;
        $obj->codeid = $codeid;
        $obj->gettime = time();

        $obj->save();

        //Validate user is get this code;
    }

    /**
     * 印花列表
     */
    public function actionStampList() {

        $page = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', $this->pageSize);
        $shopid = Yii::app()->request->getParam("shopid");

        $stampBehavior = new MerchantStampBehavior;

        $ar['page'] = $page;
        $ar['pageSize'] = $pagesize;
        $ar['shopid'] = $shopid;
        $res = $stampBehavior->getList($ar);
        $data = array();
        if (!empty($res['data'])) {
            foreach ($res['data'] as $key => $value) {
                if (!empty($value->pic)) {
                    $value->pic = HelpTemplate::getAdUrl($value->pic);
                }
                $data[] = $value;
            }
        }
        $this->data = $data;
    }

    public function actionGetStamp() {
        if (Yii::app()->request->getRequestType() != 'POST') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method');
            return;
        }
        $codeid = Yii::app()->request->getPost("codeid");
        $userid = Yii::app()->request->getPost("userid");

        if (empty($codeid)) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            return;
        }
        if (empty($userid)) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            return;
        }

        $res = MerchantCodeLog::model()->isHave($codeid, $userid);
        if ($res) {
            $this->error_code = self::ERROR_NO_DATA;
            $this->message = "该用户已经获取过了.";
            return;
        }

        $obj = new MerchantCodeLog;

        $obj->userid = $userid;
        $obj->codeid = $codeid;
        $obj->gettime = time();

        $obj->save();
    }

}
