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
        $owner = Yii::app()->request->getParam("owner");
        $page = Yii::app()->request->getParam("page",1);


        $param['pageSize'] =2;
        $param['page'] =$page;
        $param['merchantid'] = Yii::app()->user->getId();
        $param['selfid'] = Yii::app()->user->getId();
        if(!empty($name))
            $param['name']   =  $name;
        if(!empty($isonly))
            $param['isonly'] = $isonly;
         if(!empty($owner))
            $param['owner'] = $owner;

        $res=$this->shopBehavior->getList($param);

        $result =  array_merge($param,$res);

        $this->render("index",$result);
    }
    public function actionCreate(){
        if(Yii::app()->request->IsPostRequest){

            $shop = Yii::app()->request->getPost("shop");
            $shop['merchantid']=Yii::app()->user->getId();

            $res = $this->shopBehavior->saveOrUpdate($shop);
            if($res){
                $this->showSuccess('创建成功', $this->createUrl('create'));
            }else{
                $this->showError('创建失败', $this->createUrl('create'));
            }

        }else{

            //商圈
            $district  = District::model()->findAll();
            $result['district'] = $district;
            //行业-分类
            $categoryBehavior = new CategoryBehavior();
            $category = $categoryBehavior->getAll();
            $result['category'] = $category;

            $this->render("create",$result);
        }
    }

    public function actionEdit(){
        if(Yii::app()->request->IsPostRequest){

        }else{
            $id  =  Yii::app()->request->getParam("id");
        }
    }

    public function actionAddShopAccount(){
        if(Yii::app()->request->IsPostRequest){
             $shopid =  Yii::app()->request->getPost("shopid");
             $username = Yii::app()->request->getPost("username");
             $passwd = Yii::app()->request->getPost("passwd");

             if(empty($username) || empty($passwd)){
                $this->showError("用户名密码不能为空",$this->referer);
                Yii::app()->end();
             }

             $bhv = new AccountBehavior();
             if($bhv->isExist($username)){
                $this->showError("用户名已经存在",$this->referer);
                Yii::app()->end();
             }
             $res = $this->shopBehavior-> createAccount($username,$passwd,$shopid);
             if($res){
                $this->showSuccess("创建成功");
             }else{
                $this->showError("创建失败");
             }
             $this->redirect($this->referer);

        }else{
            $shopid  = Yii::app()->request->getParam("id");
            if(empty($shopid))
            {
                $this->showError("非法操作",$this->referer);
                Yii::app()->end();
            }
            $shop = $this->shopBehavior->getById($shopid);

            if(empty($shop)){
                $this->showError("没有查询到该店铺",$this->referer);
                Yii::app()->end();
            }
            if($shop->merchantid != Yii::app()->user->getId()){
                $this->showError("这不是你的店铺",$this->referer);
                Yii::app()->end();
            }

            $this->render("create_account",compact('shop'));
        }
    }

    public function actionDelete(){
        $this->showError('非法操作', $this->referer);
    }
}
