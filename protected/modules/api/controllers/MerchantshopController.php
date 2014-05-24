<?php
class MerchantshopController  extends IController {

    private $shopBehavior ;
    private $productBehavior;
    public function init(){
        parent::init();
        $this->shopBehavior=new MerchantShopBehavior;
        $this->productBehavior = new MerchantProductBehavior;
    }

    public function actionList(){

        $page = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', 10);
        $id =  Yii::app()->request->getParam("merchantid");
        if(!empty($id)){
            // $this->error_code = self::ERROR_REQUEST_PARAMS;
            // return;
            $param['merchantid'] = $id;
            $param['selfid'] = $id;
        }
        $param['page'] = $page;
        $param['pageSize'] =$pagesize;

        $data = $this->shopBehavior->getlist($param);
        $this->data = $data['data'] ;
    }

    public function actionDetail(){
        $id = Yii::app()->request->getParam("id");
        if(empty($id)){
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            return;
        }
        $res  =  $this->shopBehavior->getById($id);
        if(empty($res)){
            $this->error_code = self::ERROR_NOT_FOUNT;
            return;
        }
        $this->data = $res;
    }

    public function actionProducts(){
        $shopid=Yii::app()->request->getParam("shopid");
        $page = Yii::app()->request->getParam("page",1);
        $pageSize =Yii::app()->request->getParam("pagesize",10);
        $param['page'] = $page;
        $param["pageSize"] =$pageSize;
        //不带商铺id 返回所有的信息
        //带商铺id查询关联
        if(empty($shopid)){
            $res =  $this->productBehavior->getlist($param);
        }else{
            $res =  $this->productBehavior->getListByShopId($shopid,$page,$pageSize);
        }
        $this->data = $res['data'];
    }

    public function actionProductDetail(){
        $id = Yii::app()->request->getParam("productid");
        if(empty($id)){
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            return;
        }
        $res  =  $this->productBehavior->getById($id);
        if(empty($res)){
            $this->error_code = self::ERROR_NOT_FOUNT;
            return;
        }
        $this->data = $res;
    }
}
