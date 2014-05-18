<?php

/*
 * 创建用户表单
 */

/**
 * 2014-5-12 11:16:45 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * UserCreateForm.php hugb
 *
 */
class UserCreateForm extends CFormModel {

    public $username;
    public $password;
    public $repassword;
    public $name;
    public $sex = 0;
    public $century;
    public $mobile;
    private $error;

    public function rules() {
        return array(
            array('username,password,repassword,name', 'required'),
            array('sex,mobile,century', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $this->username = trim($this->username);
        return true;
    }

    public function attributeLabels() {
        return array(
            'username' => '用户名',
            'password' => '密码',
            'repassword' => '确认密码',
            'name' => '昵称',
            'sex' => '性别',
            'mobile' => '手机号',
            'century' => '年代'
        );
    }

    public function save() {
        if ($this->validate()) {
            $data = array(
                'username' => $this->username,
                'password' => $this->password,
                'name' => $this->name,
                'sex' => $this->sex,
                'mobile' => $this->mobile,
                'century' => $this->century
            );
            $userBehavoir = new UserBehavior();
            return $userBehavoir->regsiter($data);
        } else {
            $firstError = array_shift($this->getErrors());
            $this->error = array_shift($firstError);
        }
        return false;
    }

    public function getError() {
        return $this->error;
    }

}