<?php

class MerchantcouponController extends BController {

    public function init(){
        parent::init();
    }

    public function actionIndex(){
        $this->render("list");
    }
}