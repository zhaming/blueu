<?php
class MerchantproductController  extends BController {

    public $productBehavior;
    public $shopBehavior;
    public function init(){
        parent::init();
        $this->productBehavior = new MerchantProductBehavior();
        $this->shopBehavior = new MerchantShopBehavior();
    }

    public function actionIndex(){
        $page = Yii::app()->request->getParam("page",1);
        $name = Yii::app()->request->getParam('name');

        $param["pageSize"] =2;
        $param["page"] = $page;
        if(!empty($name))
            $param['name'] =$name;
        $res  = $this->productBehavior->getList($param);

        $data = array_merge($param,$res);
        $this->render("list",$data);
    }

    public function actionCreate(){
        if(Yii::app()->request->IsPostrequest){
            $shopid  = Yii::app()->request->getPost("shopid");
            $product = Yii::app()->request->getPost("product");
            //TODO 图片处理

            $product['merchantid'] = Yii::app()->user->getId();
            $product['shops'] =  $shopid;
            $res =  $this->productBehavior->saveOrUpdate($product);
            //更新关联表
            if(!empty($shopid)){
                MerchantShopProduct::model()->deleteAllByAttributes(
                    array(),"productid=:id",
                    array(":id"=>$res->id)
                );
                foreach ($shopid as $key => $value) {
                    $data  = new MerchantShopProduct;
                    $data->shopid= $value;
                    $data->productid = $res->id;
                    $data->save();
                }
            }
            $this->showSuccess("添加成功");
            $this->redirect($this->referer);
        }else{

            //我能管理的店铺
            $ar['merchantid'] = Yii::app()->user->getId();
            $ar['selfid'] = Yii::app()->user->getId();
            $shop = $this->shopBehavior->getList($ar);


            $this->render("create",$shop);
        }
    }

    public function actionEdit(){
        if(Yii::app()->request->IsPostrequest){
            $shopid  = Yii::app()->request->getPost("shopid");
            $product = Yii::app()->request->getPost("product");
            //TODO 图片处理

            $product['merchantid'] = Yii::app()->user->getId();
            $product['shops'] =  $shopid;
            $res =  $this->productBehavior->saveOrUpdate($product);
            //更新关联表
                MerchantShopProduct::model()->deleteAllByAttributes(
                    array(),"productid=:id",
                    array(":id"=>$res->id)
                );
                foreach ($shopid as $key => $value) {
                    $data  = new MerchantShopProduct;
                    $data->shopid= $value;
                    $data->productid = $res->id;
                    $data->save();
                }
            $this->showSuccess("修改成功");
            $this->redirect($this->referer);

        }else{
            $id = Yii::app()->request->getParam("id");
            if(empty($id)){
                $this->showError("非法操作",$this->referer);
            }

            $product  = $this->productBehavior->getById($id);
            if(empty($product)){
                $this->showError("非法操作",$this->referer);
            }
            $ar['merchantid'] = Yii::app()->user->getId();
            $ar['selfid'] = Yii::app()->user->getId();
            $shop = $this->shopBehavior->getList($ar);
            $data =  $shop['data'];

            $used_shop = $product->shop_product;

            $this->render("edit",compact("product","data","used_shop"));
        }
    }
    public function actionDelete(){
        $this->redirect($this->referer);
    }

}