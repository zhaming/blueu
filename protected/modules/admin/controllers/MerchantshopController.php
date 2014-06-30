<?php

class MerchantshopController extends BController {

    private $shopBehavior;
    private $fileBehavior;
    private $categoryBehavior;

    public function init() {
        parent::init();
        $this->fileBehavior = new FileBehavior();
        $this->categoryBehavior = new CategoryBehavior();
        $this->shopBehavior = new MerchantShopBehavior();
        $this->setPageTitle(Yii::t('admin', 'Merchant shop_manager'));
    }

    /**
     * 店铺列表
     */
    public function actionIndex() {
        $params = array();
        $params['name'] = Yii::app()->request->getParam("name");
        $params['isonly'] = Yii::app()->request->getParam("isonly");
        $params['owner'] = Yii::app()->request->getParam("owner");
        $params['page'] = Yii::app()->request->getParam("page", 1);
        $params['pagesize'] = Yii::app()->request->getParam("pagesize", Yii::app()->params->page_size);

        $res = $this->shopBehavior->getList($params);
        $this->render("index", array_merge($params, $res));
    }

    /**
     * 创建店铺
     * @return type
     */
    public function actionCreate() {
        $viewData = array();
        $shopCreateForm = new ShopCreateForm();
        // 商圈
        $viewData['district'] = District::model()->findAll();
        // 行业
        $viewData['category'] = $this->categoryBehavior->getAll();
        if (!Yii::app()->request->IsPostRequest) {
            $viewData['shop'] = $shopCreateForm->getAttributes();
            return $this->render("create", $viewData);
        }
        $shopCreateForm->setAttributes(Yii::app()->request->getPost("shop"));
        if (!$shopCreateForm->execute()) {
            $viewData['message'] = $shopCreateForm->getFirstError();
            $viewData['shop'] = $shopCreateForm->getAttributes();
            return $this->render('create', $viewData);
        }
        $this->showSuccess(Yii::t("admin", "Create success."), $this->createUrl('index'));
    }

    /**
     * 编辑店铺
     */
    public function actionEdit() {
        $viewData = array();
        $shopEditForm = new ShopEditForm();
        // 商圈
        $viewData['district'] = District::model()->findAll();
        // 行业
        $viewData['category'] = $this->categoryBehavior->getAll();
        if (!Yii::app()->request->IsPostRequest) {
            $shopid = Yii::app()->request->getParam("id");
            if (empty($shopid)) {
                return $this->showError(Yii::t("admin", "Illegal request."), $this->createUrl('index'));
            }
            $viewData['shop'] = $this->shopBehavior->getById($shopid);
            if (empty($viewData['shop'])) {
                // 店铺不存在
                return $this->showError(Yii::t("admin", "Illegal request."), $this->createUrl('index'));
            }
            if (!HelpTemplate::isLoginAsAdmin() && $viewData['shop']['merchantid'] != Yii::app()->user->getId() && $viewData['shop']['selfid'] != Yii::app()->user->getId()) {
                // 这不是你的店铺
                return $this->showError(Yii::t("admin", "Illegal request."), $this->createUrl('index'));
            }
            return $this->render("edit", $viewData);
        }
        $shopEditForm->setAttributes(Yii::app()->request->getPost("shop"));
        if (!$shopEditForm->execute()) {
            $viewData['message'] = $shopEditForm->getFirstError();
            $viewData['shop'] = $shopEditForm->getAttributes();
            return $this->render('create', $viewData);
        }
        $this->showSuccess(Yii::t("admin", "Update success."), $this->createUrl('index'));
    }

    public function actionAddShopAccount() {
        if (Yii::app()->request->IsPostRequest) {
            $shopid = Yii::app()->request->getPost("shopid");
            $username = Yii::app()->request->getPost("username");
            $passwd = Yii::app()->request->getPost("passwd");

            if (empty($username) || empty($passwd)) {
                $this->showError(Yii::t("admin", "Username and pass not allow empty"), $this->referer);
                Yii::app()->end();
            }

            $bhv = new AccountBehavior();
            if ($bhv->isExist($username)) {
                $this->showError(Yii::t("admin", "Username already exists"), $this->referer);
                Yii::app()->end();
            }
            $res = $this->shopBehavior->createAccount($username, $passwd, $shopid);
            if ($res) {
                $this->showSuccess(Yii::t("comment", "Create Success"));
            } else {
                $this->showError(Yii::t("comment", "Create Failure"));
            }
            $this->redirect($this->referer);
        } else {
            $shopid = Yii::app()->request->getParam("id");
            if (empty($shopid)) {
                $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
                Yii::app()->end();
            }
            $shop = $this->shopBehavior->getById($shopid);

            if (empty($shop)) {
                //"没有查询到该店铺"
                $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
                Yii::app()->end();
            }
            if ($shop->merchantid != Yii::app()->user->getId()) {
                //"这不是你的店铺"
                $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
                Yii::app()->end();
            }

            $this->render("create_account", compact('shop'));
        }
    }

    public function actionDelete() {

        $shopid = Yii::app()->request->getParam("id");
        if (empty($shopid)) {
            $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
            Yii::app()->end();
        }
        $shop = $this->shopBehavior->getById($shopid);

        if (empty($shop)) {
            //"没有查询到该店铺"
            $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
            Yii::app()->end();
        }
        if (($shop->merchantid == Yii::app()->user->getId()) || ($shop->selfid == Yii::app()->user->getId() )) {
            $shop->delete();
        } else {
            //"这不是你的店铺"
            $this->showError(Yii::t("comment", "Illegal Operation"), $this->referer);
            Yii::app()->end();
        }
        $this->showSuccess(Yii::t("commnet", "Delete Success"), $this->referer);
    }

    public function actionDistrict() {
        $this->layout = "null";
        echo header("Content-Type:application/json");

        $pid = Yii::app()->request->getParam("pid");

        $district = District::model()->findAll();
        $data = array();
        if (!empty($district))
            foreach ($district as $key => $value) {
                if ($value->parentid == $pid)
                    $data[] = $value;
            }
        echo CJSON::encode($data);
    }

    public function actionCategory() {
        $this->layout = "null";
        echo header("Content-Type:application/json");

        $pid = Yii::app()->request->getParam("pid");

        $res = Category::model()->findAll();
        $data = array();
        if (!empty($res))
            foreach ($res as $key => $value) {
                if ($value->parentid == $pid)
                    $data[] = $value;
            }
        echo CJSON::encode($data);
    }

}