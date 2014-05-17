<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BController extends CController
{

    public $controller_id;
    public $action_id;
    public $referer;
    public $pageTitle = '新三版 - 后台';
    public $pageName = '后台';

    public $menu=array();

    public $breadcrumbs=array();


    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->controller_id = $this->getId();
        $this->action_id = $this->getAction()->getId();

        // $this->checkPermissions();
        $this->resourceInsert();
        return true;
    }

    // 检查访问你权限
    public function checkPermissions()
    {
        $rules['guest'] = array(
            'manager' => array('login'),
            );
        if (Yii::app()->user->getState('manager_id') == null) {
            if(empty($rules['guest'][$this->controller_id]) || !in_array($this->action_id, $rules['guest'][$this->controller_id])){
                $this->showMessage('请先登陆','/admin/manager/login');
            }
        }
        $rules['user'] = Yii::app()->session['rule'];
        $this_url = $this->controller_id."/".$this->action_id;

        // 有权限访问的url
        $url_array = array('manager/logout', 'manager/login', 'site/index');
        if (!empty($rules['user'])) {
            foreach ($rules['user'] as $key => $value) {
                $url_array[]=$value['controllerid']."/".$value['actionid'];
            }
        }
        if(!in_array($this_url, $url_array)){
            //$this->showError("你没有执行该操作的权限");
            //$this->redirect("/admin");
        }
    }

    // 加载文件 css， js
    public function resourceInsert()
    {
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->request->baseUrl;
        $cs->registerScriptFile($baseUrl.'/statics/plugins/jquery-1.8.2.min.js');
        $cs->registerCssFile($baseUrl.'/statics/plugins/bootstrap/css/bootstrap.min.css');
        $cs->registerScriptFile($baseUrl.'/statics/plugins/bootstrap/js/bootstrap.min.js');
        $cs->registerCssFile($baseUrl.'/statics/plugins/bootstrap/css/bootstrap-responsive.min.css');

        // ztree
        $cs->registerScriptFile($baseUrl.'/statics/plugins/zTree/js/jquery.ztree.core-3.5.js');
        $cs->registerScriptFile($baseUrl.'/statics/plugins/zTree/js/jquery.ztree.excheck-3.5.js');
        $cs->registerCssFile($baseUrl.'/statics/plugins/zTree/css/zTreeStyle/zTreeStyle.css');
        
        // fancybox
        $cs->registerScriptFile($baseUrl.'/statics/plugins/fancybox/jquery.fancybox-1.3.4.js');
        $cs->registerCssFile($baseUrl.'/statics/plugins/fancybox/jquery.fancybox-1.3.4.css');

    }

    protected function afterAction($action)
    {
        $message = Yii::app()->user->getFlash('alertmsg');
        if($message!=null)
        {
            if($message['type'])
                echo '<script>alert("'.$message['msg'].'");</script>';
            else
                echo '<script>alert("'.$message['msg'].'");</script>';
        }
    }



    public function showSuccess($msg, $url = '')
    {
        $message = array();
        $message['type'] = 'success';
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('alertmsg', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    public function showError($msg, $url = '')
    {
        $message = array();
        $message['type'] = 'error';
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('alertmsg', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    public function showMessage($msg, $url = '',$type=false)
    {
        $message = array();
        $message['type'] = $type;
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('alertmsg', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

}
