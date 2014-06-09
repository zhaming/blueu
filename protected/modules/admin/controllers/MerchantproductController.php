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

        $param["pageSize"] =20;
        $param["page"] = $page;
        if(!empty($name))
            $param['name'] =$name;
        //fix 我发布的和我建立的分店账号发布的
        $merchantid = Yii::app()->user->getId();
        $ids =array($merchantid);

        $result   = $this->shopBehavior->getList(array("merchantid"=>$merchantid));
        if(!empty($result['data'])){
            foreach ($result['data'] as $key => $value) {
                if(!empty($value->selfid)){
                    array_push($ids, $value->selfid);
                }
            }
        }
        $isadmin = HelpTemplate::isLoginAsAdmin();
        if(!$isadmin){
            $param['in']= array("merchantid"=> $ids );
        }

        $res  = $this->productBehavior->getList($param);
        $data = array_merge($param,$res);
        $this->render("list",$data);
    }


    public function actionCreate(){
        if(Yii::app()->request->IsPostrequest){
            $shopid  = Yii::app()->request->getPost("shopid");
            $product = Yii::app()->request->getPost("product");
            //TODO 图片处理
            if(empty($shopid)){
                $this->showError(Yii::t("shop","Pelase choose a shop"),$this->referer);
                Yii::app()->end();
            }
            // $file = new FilesComponent;
            // $result = $file->mUpload('product[pic]');
            // $product['pic'] = $result["hash"];
            //
            $fileBehavior = new FileBehavior();
            if ($fileBehavior->isHaveUploadFile('product[pic]')) {

                $file = $fileBehavior->saveUploadFile('product[pic]');
                if ($file) {
                    $product['pic'] = $file['path'];
                }
            }
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
            $this->showSuccess(Yii::t("comment","Create Success"));
            $this->redirect($this->referer);
        }else{

            //我能管理的店铺
            $ar = array();
            $isadmin = HelpTemplate::isLoginAsAdmin();
            if(!$isadmin){
                $ar['merchantid'] = Yii::app()->user->getId();
                $ar['selfid'] = Yii::app()->user->getId();
            }
            $shop = $this->shopBehavior->getList($ar);


            $this->render("create",$shop);
        }
    }

    public function actionEdit(){
        if(Yii::app()->request->IsPostrequest){
            $shopid  = Yii::app()->request->getPost("shopid");
            $product = Yii::app()->request->getPost("product");
            //TODO 图片处理

            $fileBehavior = new FileBehavior();
            if ($fileBehavior->isHaveUploadFile('product[pic]')) {
                $file = $fileBehavior->saveUploadFile('product[pic]');
                if ($file) {
                    $product['pic'] = $file['path'];
                }
            }else{
            }
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
            $this->showSuccess(Yii::t("commnet","Edite Success"));
            $this->redirect($this->referer);

        }else{
            $id = Yii::app()->request->getParam("id");
            if(empty($id)){
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
            }

            $product  = $this->productBehavior->getById($id);
            if(empty($product)){
                $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
            }
              $ar = array();
            $isadmin = HelpTemplate::isLoginAsAdmin();
            if(!$isadmin){
                $ar['merchantid'] = Yii::app()->user->getId();
                $ar['selfid'] = Yii::app()->user->getId();
            }
            $shop = $this->shopBehavior->getList($ar);
            $data =  $shop['data'];

            $used_shop = $product->shop_product;

            $this->render("edit",compact("product","data","used_shop"));
        }
    }
    public function actionDelete(){

        $id = Yii::app()->request->getParam("id");
        if(empty($id)){
            $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
        }

        $product  = $this->productBehavior->getById($id);
        if(empty($product)){
            $this->showError(Yii::t("comment","Illegal Operation"),$this->referer);
        }
        $res  = $product->delete();
        //删除关联
        MerchantShopProduct::model()->deleteAllByAttributes(
            array(),"productid=:id",
            array(":id"=>$id)
        );
        if($res)
            $this->showSuccess(Yii::t("commnet","Delete Success"));
        else
            $this->showError(Yii::t("commnet","Delete Failure"));
        $this->redirect($this->referer);
    }

}