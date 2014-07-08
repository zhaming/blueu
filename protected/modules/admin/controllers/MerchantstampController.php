<?php

class MerchantstampController extends BController {

    private $stampBehavior;

    public function init() {
        parent::init();
        $this->setPageTitle(Yii::t('shop', 'Stamp Manager'));
        $this->stampBehavior = new MerchantStampBehavior();
    }

    public function actionIndex() {
        $page = Yii::app()->request->getParam("page", 1);
        $name = Yii::app()->request->getParam('name');

        $param['page'] = $page;
        $param['name'] = $name;
        $param['pageSize'] = Yii::app()->params->page_size;
        if (!HelpTemplate::isLoginAsAdmin()) $param['merchantid'] = Yii::app()->user->getId();
        $res = $this->stampBehavior->getList($param);

        $res['name'] = $name;
        $this->render("list", $res);
    }

    public function actionCreate() {
        if (Yii::app()->request->isPostRequest) {
            $stamp = Yii::app()->request->getPost("stamp");
            $shopid = Yii::app()->request->getParam("shopid");

            if (empty($shopid)) {
                $this->showError(Yii::t("shop", "Pelase choose  a shop"), $this->referer);
                Yii::app()->end;
            }

            if (empty($stamp['validity_end']) || empty($stamp['validity_end'])) {
                $this->showError(Yii::t("comment", "Pelease select a date"), $this->referer);
            } else {
                $stamp['validity_start'] = strtotime($stamp['validity_start']);
                $stamp['validity_end'] = strtotime($stamp['validity_end']);
            }

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $code = new MerchantCode;
                $code->type = 4;
                $code->validity_start = $stamp['validity_start'];
                $code->validity_end = $stamp["validity_end"];
                $code->code = MerchantCode::model()->getNewCode();
                $code->total = $stamp['total'];
                $code->used = 0;
                $code->save();

                $stamp['codeid'] = $code->id;
                $stamp["merchantid"] = Yii::app()->user->getId();


                $fileBehavior = new FileBehavior();
                if ($fileBehavior->isHaveUploadFile('stamp[pic]')) {

                    $file = $fileBehavior->saveUploadFile('stamp[pic]');
                    if ($file) {
                        $stamp['pic'] = $file['path'];
                    }
                }

                foreach ($shopid as $key => $value) {
                    $stamp['shopid'] = $value;
                    $this->stampBehavior->saveOrUpdate($stamp);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                $this->showError(Yii::t("shop", "Create Failure"), $this->referer);
                Yii::app()->end();
            }
            $transaction->commit();
            $this->showSuccess(Yii::t("comment", "Create Success"), $this->referer);
        } else {
            $shopBehavior = new MerchantShopBehavior;
            $ar = array();
            $isadmin = HelpTemplate::isLoginAsAdmin();
            if (!$isadmin) {
                $ar['merchantid'] = Yii::app()->user->getId();
                $ar['selfid'] = Yii::app()->user->getId();
            }
            $shop = $shopBehavior->getList($ar);

            $this->render("create", $shop);
        }
    }

    public function actionEdit() {
        if (Yii::app()->request->isPostRequest) {
            $data = Yii::app()->request->getPost("stamp");
            $fileBehavior = new FileBehavior();
            if ($fileBehavior->isHaveUploadFile('stamp[pic]')) {
                $file = $fileBehavior->saveUploadFile('stamp[pic]');
                if ($file) {
                    $data['pic'] = $file['path'];
                }
            }
            if (empty($data['validity_end']) || empty($data['validity_end'])) {
                $this->showError(Yii::t("comment", "Pelease select a date"), $this->referer);
                die();
            } else {
                $data['validity_start'] = strtotime($data['validity_start']);
                $data['validity_end'] = strtotime($data['validity_end']);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $this->stampBehavior->saveOrUpdate($data);
                $code = MerchantCode::model()->findByPk($data['codeid']);
                $code->validity_start = $data['validity_start'];
                $code->validity_end = $data['validity_end'];
                $code->total = $data['total'];
                $code->save();
            } catch (Exception $e) {
                $transaction->rollback();
                $this->showError(Yii::t("shop", "Modify Failure"), $this->referer);
                Yii::app()->end();
            }
            $transaction->commit();

            $this->showSuccess(Yii::t("comment", "Modify Success"), $this->referer);
        } else {
            $id = Yii::app()->request->getParam("id");
            if (empty($id)) {
                $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
                Yii::app()->end;
            }

            $stamp = $this->stampBehavior->getById($id);

            if (empty($stamp)) {
                $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
                Yii::app()->end;
            }
            $shopBehavior = new MerchantShopBehavior;
            $isadmin = HelpTemplate::isLoginAsAdmin();
            $ar = array();
            if (!$isadmin) {
                $ar['merchantid'] = Yii::app()->user->getId();
                $ar['selfid'] = Yii::app()->user->getId();
            }
            $shop = $shopBehavior->getList($ar);
            $shop['stamp'] = $stamp;
            $this->render("edit", $shop);
        }
    }

    public function actionDelete() {
        $id = Yii::app()->request->getParam("id");
        if (empty($id) || !is_numeric($id)) {
            $this->showError(Yii::t("comment", "Illegal request."), $this->referer);
        } elseif ($this->stampBehavior->deleteById($id)) {
            $this->ShowSuccess(Yii::t("comment", "Delete success."), $this->referer);
        } else {
            $this->showError(Yii::t("comment", "Delete failure."), $this->referer);
        }
    }

}