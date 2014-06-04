<?php

class BController extends CController {

    public $pagename;
    public $controller_id;
    public $action_id;
    public $referer;
    public $menu = array();
    public $breadcrumbs = array();
    protected $error;

    protected function beforeAction($action) {
        parent::beforeAction($action);

        $this->controller_id = $this->getId();
        $this->action_id = $this->getAction()->getId();
        $this->referer = Yii::app()->request->getUrlReferrer();

        $this->checkPermissions();
        $this->resourceInsert();

        return true;
    }

    public function filters() {
        return array(
            'accessControl',
        );
    }

    protected function isSuperAdmin() {
        return HelpTemplate::isLoginAsSuperAdmin();
    }

    protected function isAdmin() {
        return HelpTemplate::isLoginAsAdmin();
    }

    protected function isMerchant() {
        return HelpTemplate::isLoginAsMerchant();
    }

    public function checkPermissions() {
        $rules = array(
            'manager' => array('login', 'findpwd'),
            'merchant' => array('register')
        );
        if (Yii::app()->user->id == null) {
            if (key_exists($this->controller_id, $rules) && in_array($this->action_id, $rules[$this->controller_id])) {
                
            } else {
                $this->redirect('/admin/manager/login');
            }
        }
    }

    public function resourceInsert() {
        //$cs = Yii::app()->getClientScript();
        //$baseUrl = Yii::app()->request->baseUrl;

        /* $cs->registerScriptFile($baseUrl . '/statics/plugins/jquery-1.8.2.min.js');
          $cs->registerCssFile($baseUrl . '/statics/plugins/bootstrap/css/bootstrap.css');
          $cs->registerScriptFile($baseUrl . '/statics/plugins/bootstrap/js/bootstrap.js');
          $cs->registerCssFile($baseUrl . '/statics/plugins/bootstrap/css/bootstrap-responsive.css');

          $cs->registerScriptFile($baseUrl . '/statics/plugins/zTree/js/jquery.ztree.core-3.5.js');
          $cs->registerScriptFile($baseUrl . '/statics/plugins/zTree/js/jquery.ztree.excheck-3.5.js');
          $cs->registerCssFile($baseUrl . '/statics/plugins/zTree/css/zTreeStyle/zTreeStyle.css');

          $cs->registerScriptFile($baseUrl . '/statics/plugins/fancybox/jquery.fancybox-1.3.4.js');
          $cs->registerCssFile($baseUrl . '/statics/plugins/fancybox/jquery.fancybox-1.3.4.css');

          $cs->registerCssFile($baseUrl . '/statics/css/admin.css'); */
    }

    protected function afterAction($action) {
        parent::afterAction($action);
    }

    public function showSuccess($msg, $url = '') {
        $message = array('type' => 'success', 'msg' => $msg);
        Yii::app()->user->setFlash('messagetip', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    public function showError($msg, $url = '') {
        $message = array();
        $message['type'] = 'error';
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('messagetip', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    public function showMessage($msg, $url = '', $type = false) {
        $message = array();
        $message['type'] = $type;
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('messagetip', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    public function setPageTitle($pageName) {
        if (is_array($pageName))
            $pageName = implode(Yii::app()->params->title_separator, $pageName);
        parent::setPageTitle(Yii::t('application', '{appName}{separator}{pageName}', array(
                    '{appName}' => Yii::app()->params->title,
                    '{separator}' => Yii::app()->params->title_separator,
                    '{pageName}' => $pageName,
        )));
        $this->pagename = $pageName;
    }

    public function getPageTitle() {
        if (parent::getPageTitle() !== null) {
            return parent::getPageTitle();
        }
        return $this->pageTitle = empty(Yii::app()->name) ? Yii::app()->params->title : Yii::app()->name;
    }

}
