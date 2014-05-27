<?php

class MerchantcouponController extends BController {

    private $couponBehavior;
    public function init(){
        parent::init();
        $this->couponBehavior = new MerchantCouponBehavior;
    }

    public function actionIndex(){
        $page = Yii::app()->request->getParam("page",1);
        $name = Yii::app()->request->getParam('name');

        $param['page'] = $page;
        $param['name'] = $name;
        $param['pageSize'] =4;
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
                        $coupon['pic'] = $file['hash'];
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
            $ar['merchantid'] = Yii::app()->user->getId();
            $ar['selfid'] = Yii::app()->user->getId();
            $shop = $shopBehavior->getList($ar);

            $this->render("create",$shop);
        }
    }
    public function actionEdit(){
        if(Yii::app()->request->isPostRequest){
            $fileBehavior = new FileBehavior();
            if ($fileBehavior->isHaveUploadFile('coupon[pic]')) {

                $file = $fileBehavior->saveUploadFile('coupon[pic]');
                if ($file) {
                    $product['pic'] = $file['hash'];
                }
            }
        }else{
            $this->render("edit");
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
}