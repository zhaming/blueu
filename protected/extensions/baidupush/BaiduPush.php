<?php
/**
 *	控制台入口
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	
 *
 *	$Id$
 */

class BaiduPush extends Channel {
    
    const DEBUG = true;
    
    protected $_deviceList = array(
        'browser'   => 1,
        'pc'        => 2,
        'android'   => 3,
        'ios'       => 4,
        'winphone'  => 5,
    );

    public function pushMessage2 ($device_type, $push_type, $push_param, $messages, $deployed = false)
    {
        $device_type = strtolower($device_type);
        $deviceList = array();
        if(array_key_exists($device_type, $this->_deviceList))
            $deviceList = array($device_type => $this->_deviceList[$device_type]);
        else if('all' === $device_type)
            $deviceList = $this->_deviceList;
        switch ($push_type) {
            case 1:
                $optional[Channel::USER_ID] = $push_param; //如果推送单播消息，需要指定user
                break;
            case 2:
                $optional[Channel::TAG_NAME] = $push_param; //如果推送tag消息，需要指定tag_name
                break;
            case 3:  //广播
            default:
                break;
        }
        
        $rs = true;
        foreach ($deviceList as $type => $value) {
            //指定发到android设备
            $optional[Channel::DEVICE_TYPE] = $value;
            //指定消息类型为通知
            $optional[Channel::MESSAGE_TYPE] = $type == 'ios' ? 1 : $messages['type'];
            if($type == 'ios') $optional[Channel::DEPLOY_STATUS] = $deployed ? 2 : 1;

            $ret = $this->pushMessage ( $push_type, $messages['msg'], $messages['key'], $optional ) ;
            $this->output($ret);
            $rs &= $ret;
        }
        return $rs;
    }

    public function setTag2($tag_name, $user_id)
    {
        $optional[Channel::USER_ID] = $user_id;
        $ret = $this->setTag($tag_name, $optional);
        $this->output($ret);
        return $ret ? $ret['response_params']['tid'] : $ret;
    }

    public function fetchTag2($tag_name = null)
    {
        $optional[Channel::TAG_NAME] = $tag_name;
        $ret = $this->fetchTag($optional);
        $this->output($ret);
        return $ret;
    }

    public function initAppIoscert2 ( $name, $description, $release_cert, $dev_cert, $deployed = false )
    {
        if(is_file($release_cert)) $release_cert = file_get_contents($release_cert);
        if(is_file($dev_cert)) $dev_cert = file_get_contents ($dev_cert);
        $optional[Channel::DEPLOY_STATUS] = $deployed ? 2 : 1;
        
        $ret = $this->initAppIoscert($name, $description, $release_cert, $dev_cert, $optional);
        $this->output($ret);
        return $ret;
    }

    public function updateAppIoscert2 ( $name, $description, $release_cert, $dev_cert, $deployed = false )
    {
        if(is_file($release_cert)) $release_cert = file_get_contents($release_cert);
        if(is_file($dev_cert)) $dev_cert = file_get_contents ($dev_cert);
        $optional[Channel::DEPLOY_STATUS] = $deployed ? 2 : 1;

        $optional[ Channel::NAME ] = $name;
        $optional[ Channel::DESCRIPTION ] = $description;
        $optional[ Channel::RELEASE_CERT ] = $release_cert;
        $optional[ Channel::DEV_CERT ] = $dev_cert;
        $ret = $this->updateAppIoscert ($optional) ;
        $this->output($ret);
        return $ret;
    }
    
    private function output($ret) {
        if(!self::DEBUG) return;
        $func = __FUNCTION__;
        if ( false === $ret ){
            $msg = 
<<<MSG
WRONG, $func ERROR!
ERROR NUMBER: {$this->errno()}
ERROR MESSAGE: {$this->errmsg()}
REQUEST ID: {$this->getRequestId()}
MSG;
            $msg = "\033[1;40;31m" . $msg ."\033[0m" . "\n";
        }else{
            $result = print_r($ret, true);
            $msg = 
<<<MSG
SUCC, $func OK!
RESULT: $result
MSG;
            $msg = "\033[1;40;32m" . $msg ."\033[0m" . "\n";
        }
        echo $msg;
    }
}