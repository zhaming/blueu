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
    const SERVER_ERROR = 999;

    protected $userBehavior;
    protected $tokenBehavior;

    /* 所有错误码定义 */
    public $errors = array(
        '0' => '请求成功',
        '1' => '请求失败',
        '2' => '请求方法错误',
        '3' => '请求参数错误',
        '4' => 'token无效',
        '999' => "程序错误"
    );

    public function init() {
        parent::init();
        $this->userBehavior = new UserBehavior();
        $this->tokenBehavior = new TokenBehavior();
    }

    protected function beforeAction($action) {
        parent::beforeAction($action);
        header('Content-Type: application/json;charset=utf-8;');
        return true;
    }

    protected function afterAction($action) {
        parent::afterAction($action);
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
        $username = $this->getHeader('X-Auth-Username');
        $password = $this->getHeader('X-Auth-Password');
        if ($username != '' && $password != '') {
            $params = array('username' => $username, 'password' => $password);
            $user = $this->userBehavior->apiLogin($params);
            if (!$user) {
                $this->error_code = self::REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
                return false;
            }
            return $user;
        }
        $tokenId = $this->getHeader('X-Auth-Token');
        if ($tokenId == '') {
            $this->error_code = self::REQUEST_TOKEN_INVALID;
            $this->message = Yii::t('api', 'Token not set');
            return false;
        }
        $token = $this->tokenBehavior->get($tokenId);
        if ($token == null) {
            $this->error_code = self::REQUEST_TOKEN_INVALID;
            $this->message = Yii::t('api', 'Token not exist');
            return false;
        }
        if (time() > $token->expires_at) {
            $this->error_code = self::REQUEST_TOKEN_INVALID;
            $this->message = Yii::t('api', 'Token has expired');
            return false;
        }
        return CJSON::decode($token->data);
    }

    protected function getHeader($key, $default = '') {
        $newKey = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        if (isset($_SERVER[$newKey])) {
            return $_SERVER[$newKey];
        } else {
            return $default;
        }
    }

}
