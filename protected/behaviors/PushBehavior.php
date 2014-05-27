<?php
/**
 *	推送
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	
 *
 *	$Id$
 */

class PushBehavior extends BaseBehavior {
    
    const ERROR_CMD_NONE = 0;
    const ERROR_CMD_TASK = 1;
    const ERROR_CMD_KW = 2;
    const ERROR_CMD_TPL = 3;
    const ERROR_CMD_URL = 4;
    const ERROR_CMD_ACTOR = 5;
    const ERROR_CMD_API = 6;
    const ERROR_CMD_IV = 7;
    const ERROR_CMD_IA = 8;
    const ERROR_CMD_SNS = 9;
    
    static $sleep = 5;
    
    private $total = 0;
    private $success = 0;
    
    
    /**
     * 绑定客户端设备推送信息
     * @param integer $userid 用户ID
     * @param array $data 
     *    user_id: 百度云推送分配的设备用户ID
     *    channel_id: 百度云推送分配的设备通道ID
     *    platform: 设备系统平台，android或ios
     * @return mixed
     */
    public function bindDeviceInfo($userid, $data) {
        if(empty($userid)) return false;
        if(!isset($data['user_id']) || empty($data['user_id'])) return false;
        if(!isset($data['platform']) || !in_array(strtolower($data['platform']), array('android', 'ios'))) return false;
        $data['platform'] = strtolower($data['platform']);
        
        $userExtR = UserExt::model()->findAllByPk($userid);
        if(empty($userExtR)) {
            $userExtT = new UserExt();
            $userExtT->userid = $userid;
            $userExtT->user_id = $data['user_id'];
            $userExtT->channel_id = $data['channel_id'];
            $userExtT->platform = $data['platform'];
            $rs = $userExtT->save();
        } else {
            $info = array(
                'user_id' => $data['user_id'],
                'channel_id' => $data['channel_id'],
                'platform' => $data['platform'],
            );
            $rs = UserExt::model()->updateByPk($userid, $info);
        }
        return $rs;
    }
    
    /**
     * 客户端用户到店
     * @param array $data 
     *    userid: 用户ID
     *    uuid: 基站UUID
     *    param: 基站扩展信息，如距离、温度等
     *    left: 是否离开，默认0否 1是
     * @return mixed
     */
    public function userToShop($data) {
        $stationR = Station::model()->findByAttributes(array('uuid' => $data['uuid']));
        if(!empty($stationR)) $stationR->updateByPk($stationR->id, array('param' => json_encode($data['param'])));
        if(empty($stationR) || $stationR->disabled != 0 || empty($stationR->shopid)) {
            $this->errorLog(Yii::t('api', 'Station Illegal'));
            return false;
        }
        
        $rs = false;
        $shopUserR = ShopUser::model()->findByAttributes(array('userid' => $data['userid'], 'station' => $data['uuid']));
        if($data['left'] == 0) {
            if(empty($shopUserR) || (!empty($shopUserR->come_time) && !empty($shopUserR->go_time))) {
                $shopUserT = new ShopUser();
                $shopUserT->userid = $data['userid'];
                $shopUserT->station = $data['uuid'];
                $shopUserT->shopid = $stationR->shopid;
                $shopUserT->come_time = time();
                $rs = $shopUserT->save();
            } else {
                $this->errorLog(Yii::t('api', 'Repeat Request'));
            }
        } else {
            if(!empty($shopUserR->come_time) && empty($shopUserR->go_time)) {
                $rs = ShopUser::model()->updateByPk($shopUserR->id, array('go_time' => time()));
            } else {
                $this->errorLog(Yii::t('api', 'Repeat Request'));
            }
        }
        return $rs;
    }
    
    /**
     * 推送消息点击
     * @param array $data 
     *    pushid: 推送ID
     * @return mixed
     */
    public function userClick($data) {
        return Push::model()->updateByPk($data['pushid'], array('onclick' => 1, 'clicktime' => time()));
    }
    
    
    /**
     * 控制台推送信息
     * @param integer $taskid
     * @return integer 
     */
    public function push($taskid = 0)
    {
//请开发者设置自己的apiKey与secretKey
$apiKey = "Tp3bIrUoG13eoE5GvwVRcI9W";
$secretKey = "ItaHRAXueuTwYPANjLtNcA4mRObGoi1e";

#test
//$userId = '813292011209507601';
//$userId = '1148340223945189762';
//$userId = '868725677998357477'; //iPhone
$userId = '856690259366666776'; //HUAWEI
//$channelId = '3891701151187579171';
$tag_name = '分组1';
$tag_name1 = '分组2';

$push_type = 2;  // userid -> 1
$push_param = 'group3';  // userid
$messages = array(
    'type' => 1,  //0:消息 1:通知
    'key' => 'msg_key',
    'msg' => '{ 
        "title": "来自后台的通知",
        "description": "爆料：小米论坛数据库800万用户资料泄漏！尽情期待",
        "notification_basic_style":7,
        "open_type":1,
        "user_confirm":1,
        "url":"http://www.mi.com",
        "aps":{
			"sound":"",
			"badge":1
		},
        "custom_content":{"key1":"value1"},
        "key1":"value1"
    }',
);

$cert_name = 'APNs-blueu';
$cert_desc = 'the demo for APNs';
$pro_cert = '../../APNs-pro.pem';
$dev_cert = '../../APNs-dev.pem';

//test_initAppIoscert($cert_name, $cert_desc, $pro_cert, $dev_cert);
//test_pushMessage('all', $push_type, $push_param, $messages);
        
        
        
        $_task = new AdminTaskBehavior();
        if($taskid == 0)
            $tasks = $_task->tasks(false, true, __FUNCTION__);
        else
            $tasks[] = $_task->getById($taskid);
        if(empty($tasks)) return self::ERROR_CMD_TASK;
        
        $result = '';
        foreach($tasks as $v){
            $_task->setRuntime($v['id'], 1);
            $rs = $this->_push($v);
            $result .= $rs;
            $_task->edit($v['id'], array('runtime' => 0, 'lasttime' => time()));
        }
        return $result;
    }
    
    /**
     * 循环调用方法doPush方法
     * @param array $row 
     */
    private function _push($row)
    {
        $ext = MingString::json2arr($row['ext']);
        
        $this->total = 0;
        $i = 0;
        $affectedRows = $ext['pageSize'];
        $result = '';
        $_sns = new AdminSnsBehavior();
        
        $_task = new AdminTaskBehavior();
        $logId = $_task->logAdd($row['id'], array('start' => time()));
        
        while(true)
        {
            if($row['count'] > 0)
                if($this->total > $row['count'] - 1) break;
            else
                if($affectedRows < $ext['pageSize']) break;

            $pageStart = $ext['pageStart'] + (++$i - 1) * $ext['pageSize'];
            $sql = sprintf($row['sql'], $pageStart, $ext['pageSize']);
            $rs = $_sns->getBySql($sql);
            if(empty($rs)){
                $result .= self::ERROR_CMD_SNS;
                break;
            }
            $affectedRows = count($rs);
            $this->total += $affectedRows;
            foreach($rs as $v)
            {
                $rs = $this->doPush($v, $row['actor']);
                if($rs == self::ERROR_CMD_NONE){
                    $this->success++;
                    $_sns->setStatus($v['id'], 1);
                }
                if(strpos($rs, self::ERROR_CMD_IV) !== false) $_sns->setStatus($v['id'], 2);
                $result .= $rs;
                sleep(self::$sleep);
            }
        }
        $_task->plusExecTimes($row['id'], $this->success);
        
        $info = array(
            'end' => time(),
            'total' => $this->total,
            'success' => $this->success,
            'result' => $result,
        );
        $_task->logEdit($logId, $info);
        $this->success = 0;
        
        return $result;
    }
    
    /**
     * 实际执行推送，并返回状态码
     * @param array $row
     * @param integer $actor
     * @return integer 
     */
    private function doPush($row, $actor)
    {
        $keywords = $this->getKeyword($row['key_words']);
        if(empty($keywords)) return self::ERROR_CMD_KW;
        
        $tpls = $this->getTpl($keywords['tpl_id']);
        if(empty($tpls)) return self::ERROR_CMD_TPL;
        
        $tokens = $this->getActorParams($row['platform'], $actor);
        if(empty($tokens)) return self::ERROR_CMD_ACTOR;
        
        $urls = $this->getUrl($keywords['rule_id'], array('platform' => $row['platform'], 'weibo_id' => $row['weibo_id']));
        if(empty($urls)) return self::ERROR_CMD_URL;

        $result = '';
        $params['nick'] = $row['user_name'];
        $params['keyword'] = current(explode(' ', $keywords['key_words']));
        //$fields = $row['platform'] == 'qq' ? array('keyword', 'url') : array();
        foreach($urls as $url)
        {
            $params['url'] = $url;
            $content = $this->getCommentContent($tpls['template'], $params);
            
            //$rs = $this->_doPush($row['platform'], $tokens, array($row['weibo_id'], $row['user_id']), $content);
            $rs = $this->_doPush($row['platform'], $tokens, $row['weibo_id'], $content);
            $result .= $rs;
        }
        
        if( $result == str_repeat(true, count($urls)) ){
            return self::ERROR_CMD_NONE;
        }elseif(strpos($result, self::ERROR_CMD_IA) !== false){
            $_app = new AdminAppBehavior();
            $_app->setAuthStatus($tokens, 0);
        }
        return $result;
    }
    
    /**
     * 调用相应平台API，发送评论
     * @param string $platform
     * @param array $tokens
     * @param integer $to
     * @param string $content
     * @return mixed
     */
    private function _doPush($platform, $tokens, $to, $content)
    {
        $toauth = ucfirst(strtolower($platform)) . 'TOauth';
        if(!@class_exists($toauth)) return false;
        $_toauth = new $toauth();
        if(!@method_exists($_toauth, 'sendMessage')) return false;
        $rs = $_toauth->sendMessage($tokens, $to, $content, true);
        
        echo "\n".date('Y-m-d H:i:s')."\n";
        print_r($to);echo $content."\n";
        print_r($rs); //重定向到日志中
        return true;
        
        if( (isset($rs['ret']) && $rs['ret'] > 0) || isset($rs['error_code']) || isset($rs['error']) || empty($rs) )
        {
            if(isset($rs['errcode']) && $rs['errcode'] == 11) return self::ERROR_CMD_IV;
            if(isset($rs['msg']) && $rs['msg'] == 'forbidden access') return self::ERROR_CMD_IA;
            
            echo "\n".date('Y-m-d H:i:s')."\n";
            print_r($to);echo $content."\n";
            print_r($rs); //重定向到日志中
            return self::ERROR_CMD_API;
        }
        return true;
    }
    
    /**
     * 根据关键字ID获取规则ID
     * @param integer $keywordId
     * @return integer 
     */
    private function getKeyword($keywordId)
    {
        $_keyword = new AdminKeywordBehavior();
        $rs = $_keyword->getById($keywordId);
        return $rs;
    }
    
    /**
     * 获取评论模板
     * @param integer $tplId
     * @return array 
     */
    private function getTpl($tplId)
    {
        $_tpl = new AdminTplBehavior();
        $rs = $_tpl->getByIdAndZero($tplId);
        return $rs;
    }
    
    /**
     * 获取关键字URL
     * @param integer $keywordId
     * @param array $params
     * @return string 
     */
    private function getUrl($urlId, $params)
    {
        $urlFormat = '%s/site/go/p/%s';
        $_url = new AdminUrlBehavior();
        
        $urls = array();
        $urlIds = explode(',', $urlId);
        foreach($urlIds as $id)
        {
            $rs = $_url->getById($id);
            if(empty($rs)) continue;
            $p = array(
                $rs['short'],
                $params['platform'],
                $params['weibo_id']
            );
            $p = MingCrypt::authCrypt(implode('|', $p), 'ENCODE');
            $urls[] = sprintf($urlFormat, Yii::app()->params->host, $p);
        }
        return $urls;
    }

    /**
     * 获取执行者
     * @param string $platform
     * @param integer $actor
     * @return array 
     */
    private function getActorParams($platform, $actor)
    {
        $_app = new AdminAppBehavior();
        if($actor > 0)
        {
            $auths = $_app->getAuthById($actor);
            if(empty($auths)) return false;
            if($auths['platform'] == $platform)
                return array(
                    'token' => $auths['token'],
                    'token_secret' => $auths['token_secret'],
                );
        }
        $authIds = $_app->getAppAuthIds($platform);
        if(empty($authIds)) return false;
        $auths = $authIds[array_rand($authIds)];
        return array(
            'token' => $auths['token'],
            'token_secret' => $auths['token_secret'],
        );
    }

    /**
     * 获取评论内容
     * @param string $template
     * @param array $params
     * @return string
     */
    private function getCommentContent($template, $params, $fields = array())
    {
        $matches = array();
        preg_match_all('/%([^%]*)%/', $template, $matches);
        if(empty($matches[0]))
            $content = $template;
        else
        {
            $search = $matches[0];
            $replace = array();
            foreach($matches[1] as $v)
                $replace[] = (empty($fields) || in_array($v, $fields)) ? $params[$v] : '';
            $content = str_replace($search, $replace, $template);
        }
        return $content;
    }
}