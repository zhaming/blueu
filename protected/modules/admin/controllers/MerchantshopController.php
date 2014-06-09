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
        $isadmin = HelpTemplate::isLoginAsAdmin();
        if(!$isadmin){
            $param['merchantid'] = Yii::app()->user->getId();
            $param['selfid'] = Yii::app()->user->getId();
        }
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
                $this->showSuccess(Yii::t("comment","Create Success"), $this->createUrl('create'));
            }else{
                $this->showError(Yii::t("comment","Create Failure"), $this->createUrl('create'));
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
                $shop = Yii::app()->request->getPost("shop");

                if(empty($shop['isonly']))
                    $shop['isonly'] =0;
                if(empty($shop['ismain']))
                    $shop['ismain'] =0;
                $res = $this->shopBehavior->saveOrUpdate($shop);
                if($res){
                    $this->showSuccess(Yii::t("comment","Modify Success"));
                }else{
                    $this->showError(Yii::t("comment","Modify Failure"));
                }
                $this->redirect($this->referer);
        }else{

            $shopid  =  Yii::app()->request->getParam("id");
            if(empty($shopid))
            {
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end();
            }
            $shop = $this->shopBehavior->getById($shopid);

            if(empty($shop)){
                 //"没有查询到该店铺"
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end();
            }
            $admin = HelpTemplate::isLoginAsAdmin();

            if($shop->merchantid != Yii::app()->user->getId() && !$admin){
               //"这不是你的店铺"
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end();
            }
              //商圈
            $district  = District::model()->findAll();
            $result['district'] = $district;
            //行业-分类
            $categoryBehavior = new CategoryBehavior();
            $category = $categoryBehavior->getAll();
            $this->render("edit",compact('shop',"district","category"));
        }
    }

    public function actionAddShopAccount(){
        if(Yii::app()->request->IsPostRequest){
             $shopid =  Yii::app()->request->getPost("shopid");
             $username = Yii::app()->request->getPost("username");
             $passwd = Yii::app()->request->getPost("passwd");

             if(empty($username) || empty($passwd)){
                $this->showError(Yii::t("admin","Username and pass not allow empty"),$this->referer);
                Yii::app()->end();
             }

             $bhv = new AccountBehavior();
             if($bhv->isExist($username)){
                $this->showError(Yii::t("admin","Username already exists"),$this->referer);
                Yii::app()->end();
             }
             $res = $this->shopBehavior-> createAccount($username,$passwd,$shopid);
             if($res){
                $this->showSuccess(Yii::t("comment","Create Success"));
             }else{
                $this->showError(Yii::t("comment","Create Failure"));
             }
             $this->redirect($this->referer);

        }else{
            $shopid  = Yii::app()->request->getParam("id");
            if(empty($shopid))
            {
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end();
            }
            $shop = $this->shopBehavior->getById($shopid);

            if(empty($shop)){
                //"没有查询到该店铺"
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end();
            }
            if($shop->merchantid != Yii::app()->user->getId()){
                //"这不是你的店铺"
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
                Yii::app()->end();
            }

            $this->render("create_account",compact('shop'));
        }
    }

    public function actionDelete(){

        $shopid  = Yii::app()->request->getParam("id");
        if(empty($shopid))
        {
            $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
            Yii::app()->end();
        }
        $shop = $this->shopBehavior->getById($shopid);

        if(empty($shop)){
            //"没有查询到该店铺"
            $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
            Yii::app()->end();
        }
        if( ($shop->merchantid == Yii::app()->user->getId()) || ($shop->selfid == Yii::app()->user->getId() )  ){
                $shop->delete();
        }else{
            //"这不是你的店铺"
            $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
            Yii::app()->end();
        }
        $this->showSuccess(Yii::t("commnet","Delete Success"),$this->referer);
    }

    public function actionDistrict(){
        $this->layout="null";
        echo header("Content-Type:application/json");

        $pid = Yii::app()->request->getParam("pid");

        $district  = District::model()->findAll();
        $data =array();
        if(!empty($district))
        foreach ($district as $key => $value) {
            if($value->parentid == $pid)
                $data[] = $value;
        }
        echo CJSON::encode($data);
    }
    public function actionCategory(){
        $this->layout="null";
        echo header("Content-Type:application/json");

        $pid = Yii::app()->request->getParam("pid");

        $res  = Category::model()->findAll();
        $data =array();
        if(!empty($res))
        foreach ($res as $key => $value) {
            if($value->parentid == $pid)
                $data[] = $value;
        }
        echo CJSON::encode($data);
    }
}