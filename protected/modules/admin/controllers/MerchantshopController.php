<?php

class MerchantshopController extends BController {

    private $shopBehavior;

    public function init() {
        parent::init();
        $this->shopBehavior = new MerchantShopBehavior();
    }
    public function actionIndex(){
        $name = Yii::app()->request->getParam("name");
        $isonly = Yii::app()->request->getParam("isonly");

        $param =array();
        if(!empty($name))
            $param['name']   =  $name;
        if(!empty($isonly))
            $param['isonly'] = $isonly;
        $res=$this->shopBehavior->getList($param);

        $this->render("index",array_merge($param,$res));
    }
    public function actionCreate(){
        if(Yii::app()->request->IsPostRequest){

            $shop = Yii::app()->request->getPost("shop");
            $shop['merchantid']=Yii::app()->user->getId();

            $res = $this->shopBehavior->saveOrUpdate($shop);
            if($res){
                $this->showSuccess('创建成功', $this->createUrl('create'));
            }else{
                $this->showError('非法操作', $this->createUrl('create'));
            }

        }else{
            $this->render("create");
        }
    }

    public function actionDelete(){
        $this->showError('非法操作', $this->createUrl('delete'));
    }
}
