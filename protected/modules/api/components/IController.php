<?php

/*
 * API控制器基类
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * IController.php hugb
 *
 */
class IController extends CController {

    protected $error_code = 0;
    protected $error_msg = '';
    protected $message = '';
    protected $data = null;

    const REQUEST_FAILURE = 1;
    const REQUEST_METHOD_ERROR = 2;
    const REQUEST_PARAMS_ERROR = 3;
    const REQUEST_TOKEN_INVALID = 4;

    /* 所有错误码定义 */

    public $errors = array(
        '0' => '请求成功',
        '1' => '请求失败',
        '2' => '请求方法不正确',
        '3' => '请求参数错误',
        '4' => 'token无效',
        '100' => '请求方法错误，请求method必须为GET、PUT、POST、DELETE其中一个，具体参照API文档。',
        '101' => '参数错误，或缺少必要参数',
        '999' => "程序错误,未定义的错误码",
    );

    public function beforeAction($action) {
        parent::beforeAction($action);

        /* 检查是否登录 */
        // $this->recoveryLogin();
        /* 检查访问权限 */
        // $this->checkPermissions();

        return true;
    }

    protected function afterAction($action) {
        parent::afterAction($action);
        header('Content-Type: application/json;charset=utf-8;');
        $data = array(
            "error_code" => $this->error_code,
            "error_msg" => $this->errors[$this->error_code]
        );

        if (!empty($this->message)) {
            $data['error_msg'] = $data['error_msg'] . '，' . $this->message;
        }

        if (!empty($this->data)) {
            $data['data'] = $this->data;
        }

        exit(json_encode($data));
    }

    protected function getJsonFormData() {
        //return CJSON::decode(file_get_contents('php://input'));
        return CJSON::decode(Yii::app()->request->rawBody);
    }

    protected function checkToken() {

        return true;
    }

}
