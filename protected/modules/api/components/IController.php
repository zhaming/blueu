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

    const ERROR_BAD_REQUEST = 1;
    const ERROR_REQUEST_FAILURE = 2;
    const ERROR_REQUEST_METHOD = 3;
    const ERROR_REQUEST_PARAMS = 4;
    const ERROR_TOKEN_INVALID = 5;
    const ERROR_UNAUTHORIZED = 6;
    const ERROR_PAYMENT_REQUIRED = 7;
    const ERROR_FORBIDDEN = 8;
    const ERROR_NOT_FOUNT = 9;
    const ERROR_INTERNAL_SERVER_ERROR = 10;
    const ERROR_NOT_IMPLEMENTED = 11;

    protected $userBehavior;
    protected $tokenBehavior;

    /* */
    protected $error_code = 0;
    protected $error_msg = '';
    protected $message = '';
    protected $data = null;

    /* */
    protected static $errorMessages = array(
        0 => 'Success',
        self::ERROR_BAD_REQUEST => 'Bad Request',
        self::ERROR_REQUEST_FAILURE => 'Request failure',
        self::ERROR_REQUEST_METHOD => 'Request method error',
        self::ERROR_REQUEST_PARAMS => 'Request params error',
        self::ERROR_TOKEN_INVALID => 'Token invalid',
        self::ERROR_UNAUTHORIZED => 'Unauthorized',
        self::ERROR_PAYMENT_REQUIRED => 'Payment required',
        self::ERROR_FORBIDDEN => 'Forbidden',
        self::ERROR_NOT_FOUNT => 'Not Found',
        self::ERROR_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::ERROR_NOT_IMPLEMENTED => 'Not Implemented',
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
            "error_msg" => self::$errorMessages[$this->error_code]
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
        return CJSON::decode(Yii::app()->request->rawBody);
    }

    protected function checkToken() {
        $username = $this->getHeader('X-Auth-Username');
        $password = $this->getHeader('X-Auth-Password');
        if ($username != '' && $password != '') {
            $params = array('username' => $username, 'password' => $password);
            $user = $this->userBehavior->apiLogin($params);
            if (!$user) {
                $this->error_code = self::ERROR_REQUEST_FAILURE;
                $this->message = $this->userBehavior->getError();
                return false;
            }
            return $user;
        }
        $tokenId = $this->getHeader('X-Auth-Token');
        if ($tokenId == '') {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = Yii::t('api', 'Token not set');
            return false;
        }
        $token = $this->tokenBehavior->get($tokenId);
        if ($token == null) {
            $this->error_code = self::ERROR_TOKEN_INVALID;
            $this->message = Yii::t('api', 'Token not exist');
            return false;
        }
        if (time() > $token->expires_at) {
            $this->error_code = self::ERROR_TOKEN_INVALID;
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
