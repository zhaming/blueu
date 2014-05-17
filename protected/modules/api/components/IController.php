<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class IController extends CController
{

    public $controller_id;
    public $action_id;
    public $referer;

    public $menu=array();

    public $breadcrumbs=array();


    public $method;

    public $params;

    public $error=array(
        '-1'=>'token无效',
        '0'=>"成功",
        '100'=>'请求方法错误，请求method必须为GET、PUT、POST、DELETE其中一个，具体参照API文档。',
        '101'=>'参数错误，或缺少必要参数',
        '999'=>"程序错误,未定义的错误码",
    );

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->params = CJSON::decode(file_get_contents('php://input'));

        // $this->recoveryLogin();

        $this->controller_id = $this->getId();
        $this->action_id = $this->getAction()->getId();
        $this->referer = Yii::app()->request->getUrlReferrer();

        // $this->checkPermissions();
        header('Content-Type: application/json;charset=utf-8;');
        return true;
    }

    public function checkParams($params,$keys,$type='empty')
    {
        if (!is_array($params))
            return false;
        foreach ($keys as $key) {
            if ($type=='empty') {
                if (empty($params[$key]))
                    return false;
            } elseif ($type=='isset') {
                if(!isset($params[$key]))
                    return false;
            } else {
                return false;
            }
        }
        return true;
    }

    public function showError($errcode)
    {
        if(empty($this->error[$errcode]))
            $errcode = 999;
        $error['errcode'] = $errcode;
        $error['errmsg'] = $this->error[$errcode];
        echo JsonTools::json_encode_cn($error);
    }
}
