<?php

class BController extends CController {

    public $controller_id;
    public $action_id;
    public $referer;
    public $pageTitle = '新三版 - 后台';
    public $pageName = '后台';
    public $menu = array();
    public $breadcrumbs = array();

    protected function beforeAction($action) {
        parent::beforeAction($action);

        $this->controller_id = $this->getId();
        $this->action_id = $this->getAction()->getId();

        $this->checkPermissions();
        $this->resourceInsert();

        return true;
    }

    public function checkPermissions() {
        $rules = array(
            'manager' => array('login')
        );
        if (Yii::app()->user->id == null) {
            if (!key_exists($this->controller_id, $rules) || !in_array($this->action_id, $rules[$this->controller_id])) {
                $this->redirect('/admin/manager/login');
            }
        }
    }

    public function resourceInsert() {
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->request->baseUrl;

        /*$cs->registerScriptFile($baseUrl . '/statics/plugins/jquery-1.8.2.min.js');
        $cs->registerCssFile($baseUrl . '/statics/plugins/bootstrap/css/bootstrap.css');
        $cs->registerScriptFile($baseUrl . '/statics/plugins/bootstrap/js/bootstrap.js');
        $cs->registerCssFile($baseUrl . '/statics/plugins/bootstrap/css/bootstrap-responsive.css');

        $cs->registerScriptFile($baseUrl . '/statics/plugins/zTree/js/jquery.ztree.core-3.5.js');
        $cs->registerScriptFile($baseUrl . '/statics/plugins/zTree/js/jquery.ztree.excheck-3.5.js');
        $cs->registerCssFile($baseUrl . '/statics/plugins/zTree/css/zTreeStyle/zTreeStyle.css');

        $cs->registerScriptFile($baseUrl . '/statics/plugins/fancybox/jquery.fancybox-1.3.4.js');
        $cs->registerCssFile($baseUrl . '/statics/plugins/fancybox/jquery.fancybox-1.3.4.css');

        $cs->registerCssFile($baseUrl . '/statics/css/admin.css');*/
    }

    protected function afterAction($action) {
        parent::afterAction($action);

        $message = Yii::app()->user->getFlash('alertmsg');
        if ($message != null) {
            if ($message['type']) {
                echo '<script>alert("' . $message['msg'] . '");</script>';
            } else {
                echo '<script>alert("' . $message['msg'] . '");</script>';
            }
        }
    }

    public function showSuccess($msg, $url = '') {
        $message = array();
        $message['type'] = 'success';
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('alertmsg', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    public function showError($msg, $url = '') {
        $message = array();
        $message['type'] = 'error';
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('alertmsg', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    public function showMessage($msg, $url = '', $type = false) {
        $message = array();
        $message['type'] = $type;
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('alertmsg', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

}
