<?php

class MerchantcouponController extends BController {

    private $couponBehavior;
    private $pageSize;
    public function init(){
        parent::init();
        $this->couponBehavior = new MerchantCouponBehavior;
        $this->pageSize = Yii::app()->params->page_size;
    }

    public function actionIndex(){
        $page = Yii::app()->request->getParam("page",1);
        $name = Yii::app()->request->getParam('name');

        $param['page'] = $page;
        $param['name'] = $name;
        $param['pageSize'] =$this->pageSize;
        $res = $this->couponBehavior->getList($param);

        $res['name'] = $name;
        $this->render("list",$res);
    }
    public function actionCreate(){

        if(Yii::app()->request->isPostRequest){
            $coupon = Yii::app()->request->getPost("coupon");
            $shopid = Yii::app()->request->getParam("shopid");

            if(empty($shopid)){
                $this->showError(Yii::t("shop","Pelase choose  a shop"),$this->referer);
                Yii::app()->end;
            }

            if(empty($coupon['validity_end']) || empty($coupon['validity_end'])){
                $this->showError(Yii::t("comment","Pelease select a date"),$this->referer);
            }else{
                $coupon['validity_start'] = strtotime($coupon['validity_start']);
                $coupon['validity_end'] = strtotime($coupon['validity_end']);
            }

             $transaction = Yii::app()->db->beginTransaction();
            try {
                $code = new MerchantCode;
                $code->type=3;
                $code->validity_start=$coupon['validity_start'];
                $code->validity_end=$coupon["validity_end"];
                $code->code =MerchantCode::model()->getNewCode();
                $code->total=$coupon['total'];
                $code->used=0;
                $code->save();

                $coupon['codeid'] = $code->id;
                $coupon["merchantid"] = Yii::app()->user->getId();


                $fileBehavior = new FileBehavior();
                if ($fileBehavior->isHaveUploadFile('coupon[pic]')) {

                    $file = $fileBehavior->saveUploadFile('coupon[pic]');
                    if ($file) {
                        $coupon['pic'] = $file['path'];
                    }
                }

                foreach ($shopid as $key => $value) {
                    $coupon['shopid'] = $value;
                    $this->couponBehavior->saveOrUpdate($coupon);
                }

            } catch (Exception $e) {
                $transaction->rollback();
                $this->showError(Yii::t("shop","Create Failure"),$this->referer);
                Yii::app()->end();
            }
            $transaction->commit();
            $this->showSuccess(Yii::t("comment","Create Success"),$this->referer);

        }else{
            $shopBehavior = new MerchantShopBehavior;
             $ar = array();
            $isadmin = HelpTemplate::isLoginAsAdmin();
            if(!$isadmin){
                $ar['merchantid'] = Yii::app()->user->getId();
                $ar['selfid'] = Yii::app()->user->getId();
            }
            $shop = $shopBehavior->getList($ar);

            $this->render("create",$shop);
        }
    }
    public function actionEdit(){
        if(Yii::app()->request->isPostRequest){
            $data = Yii::app()->request->getPost("coupon");

            $fileBehavior = new FileBehavior();
            if ($fileBehavior->isHaveUploadFile('coupon[pic]')) {

                $file = $fileBehavior->saveUploadFile('coupon[pic]');
                if ($file) {
                    $data['pic'] = $file['path'];
                }
            }
            if(empty($data['validity_end']) || empty($data['validity_end'])){
                $this->showError(Yii::t("comment","Pelease select a date"),$this->referer);
                die();
            }else{
                $data['validity_start'] = strtotime($data['validity_start']);
                $data['validity_end'] = strtotime($data['validity_end']);
            }

             $transaction = Yii::app()->db->beginTransaction();
             try {
                $this->couponBehavior->saveOrUpdate($data);
                $code = MerchantCode::model()->findByPk($data['codeid']);
                $code->validity_start=$data['validity_start'];
                $code->validity_end=$data['validity_end'];
                $code->total=$data['total'];
                $code->save();

            } catch (Exception $e) {
                $transaction->rollback();
                $this->showError(Yii::t("shop","Modify Failure"),$this->referer);
                Yii::app()->end();
            }
            $transaction->commit();

            $this->showSuccess(Yii::t("comment","Modify Success"),$this->referer);
        }else{
            $id = Yii::app()->request->getParam("id");
            if(empty($id)){
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end;
            }

            $coupon = $this->couponBehavior->getById($id);

            if(empty($coupon)){
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end;
            }
            $shopBehavior = new MerchantShopBehavior;
            $ar = array();
            $isadmin = HelpTemplate::isLoginAsAdmin();
            if(!$isadmin){
                $ar['merchantid'] = Yii::app()->user->getId();
                $ar['selfid'] = Yii::app()->user->getId();
            }
            $shop = $shopBehavior->getList($ar);
            $shop['coupon'] = $coupon;
            $this->render("edit",$shop);
        }

    }

    public function actionDelete(){
        $id  = Yii::app()->request->getParam("id");
        if (empty($id) || !is_numeric($id)) {
            $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
            Yii::app()->end();
        }
        MerchantCoupon::model()->deleteAllByAttributes(
                    array(),"id=:id",
                    array(":id"=>$id)
        );

        $this->ShowSuccess(Yii::t("comment","Delete Success"),$this->referer);
    }

    public function actionValidateCoupon(){
        $name =  Yii::app()->request->getParam("name");
        $code = Yii::app()->request->getParam("code");

        $data['code'] =$code;
        $data['name'] = $name;
        if(!empty($code) && !empty($name)){
            $res = MerchantCodeLog::model()->getCouponList($code,$name);
            $data['data'] =$res;
        }

        $this->render("validate",$data);
    }

    public function actionUseCoupon(){
        $userid = Yii::app()->request->getParam("uid");
        $codeid = Yii::app()->request->getParam("cid");
        if(empty($userid) || empty($codeid)){
            $this->showError("",$this->referer);
            return;
        }

        // $res  =  MerchantCodeLog::model()->isUsed($codeid,$userid);
        // if($res){
        //     $this->showError("已经使用",$this->referer);
        //     return;
        // }

        MerchantCodeLog::model()->useCoupon($codeid,$userid);

        $this->ShowSuccess(Yii::t('comment',"Success"),$this->referer);
    }
}