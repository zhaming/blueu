<?php
class MerchantshopController  extends IController {

    private $shopBehavior ;
    public function init(){
        parent::init();
        $this->shopBehavior=new MerchantShopBehavior;
    }

    public function actionList(){

        $page = Yii::app()->request->getParam('page', 1);
        $pagesize = Yii::app()->request->getParam('pagesize', 2);
        $id =  Yii::app()->request->getParam("merchantid");
        if(empty($id)){
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = "merchantid".Yii::t('api', 'is not set');
            return;
        }
        $param['page'] = $page;
        $param['pageSize'] =$pagesize;
        $param['merchantid'] = $id;
        $param['selfid'] = $id;
        $data = $this->shopBehavior->getlist($param);
        $this->data = $data['data'] ;
    }
}
