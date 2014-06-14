<?php
class SearchController extends IController {

    const SHOP = "shop";
    const PRODUCT="product";
    const STAMP ='stamp';
    const COUPON = 'coupon';


    public function actionIndex(){
        $key = Yii::app()->request->getParam("key");
        $page = Yii::app()->request->getParam("page",1);
        $pagesize = Yii::app()->request->getParam("pagesize",Yii::app()->params->page_size);
        if(empty($key))
            return;
        if($page <=0 ) $page =1;

        $data['key']      = $key;
        $data['page']     = $page;
        $data['pagesize'] = $pagesize;
        $data['data']     = array();

        $sql =
        '
        (select id,name,pic,intro ,"shop" as type from merchant_shop
                where name like "'.$key.'%" or intro like "'.$key.'%" or address like "'.$key.'%" or marketplace like "'.$key.'%"  )
        union all
        (select id,name,pic,intro ,"product" as type  from merchant_product where name like "'.$key.'%" or intro like "'.$key.'%" )
        union all
        (select id,name,pic,intro ,"coupon" as type  from merchant_coupon where name like "'.$key.'%" or intro like "'.$key.'%" )
        union all
        (select id,name,pic,intro ,"stamp" as type  from merchant_stamp where name like "'.$key.'%" or intro like"'.$key.'%" )
        ';
        $countsql = 'select count(*) as count from ( '.$sql.') t ';
        $db = Yii::app()->db;

        $count_res = $db->createCommand($countsql)->queryRow();
        $count = $count_res['count'];
        $limit  = "limit ".(($page-1)*$pagesize).",".$pagesize ;

        $data['data'] =  $db->createCommand($sql.$limit)->queryAll();
        $this->data =  $data;
    }


}