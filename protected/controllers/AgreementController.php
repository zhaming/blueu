<?php

/*
 * 用户协议
 */

/**
 * 2014-5-18 15:36:25 UTF-8
 * @package application
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AgreementController.php hugb
 *
 */
class AgreementController extends CController {

    public $layout = false;

    public function actionMerchant() {
        $this->render('merchant');
    }

}