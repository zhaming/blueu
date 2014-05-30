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
    const ERROR_CMD_PARAM = 2;
    const ERROR_CMD_USER = 3;
    const ERROR_CMD_BIND = 4;
    const ERROR_CMD_REPEAT = 5;
    const ERROR_CMD_PUSH = 6;
    const ERROR_CMD_DB = 7;
    
    const ERROR_CMD_SHOP = 6;
    const ERROR_CMD_TPL = 3;
    const ERROR_CMD_URL = 4;
    const ERROR_CMD_API = 6;
    const ERROR_CMD_IV = 7;
    const ERROR_CMD_IA = 8;
    const ERROR_CMD_SNS = 9;
    
    static $sleep = 5;
    
    private $total = 0;
    private $success = 0;
    
    
    /**
     * 绑定客户端设备推送信息
     * for API
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
     * for API
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
     * for API
     * @param array $data 
     *    pushid: 推送ID
     * @return mixed
     */
    public function userClick($data) {
        return Push::model()->updateByPk($data['pushid'], array('onclick' => 1, 'clicktime' => time()));
    }
    
    /**
     * 添加推送记录
     * @param array $info
     * @return mixed 
     */
    public function add($info)
	{
        $push = new Push();
        $push->to = $info['to'];
        $push->message = $info['message'];
        $push->type = $info['type'];
        $push->shopid = $info['shopid'];
        if(isset($info['from'])) $push->from = $info['from'];
        if(isset($info['source'])) $push->from = $info['source'];
        if(isset($info['sid'])) $push->from = $info['sid'];
        $push->created = time();
        return $push->save();
	}
    
    
    /**
     * 控制台推送信息
     * @param integer $immediately
     * @param json $params
     * @return integer 
     */
    public function push($immediately = 0, $params = '')
    {
        $params = json_decode($params, true);
        $_task = new TaskBehavior();
        if($immediately == 1){
            $tasks = $_task->tasks(__FUNCTION__, false, false, $immediately);
            $result = $this->pushImmediately($tasks, $params);
        }else{
            if(isset($params['taskid']) && $params['taskid'] > 0)
                $tasks[] = $_task->getById($params['taskid']);
            else
                $tasks = $_task->tasks(__FUNCTION__, false, true, $immediately);
            $result = $this->pushCrontab($tasks, $params);
        }
        return $result;
    }
    
    /**
     * 即时推送
     * @param array $row 
     */
    private function pushImmediately($tasks, $params)
    {
        if(empty($tasks)) return self::ERROR_CMD_TASK;
        if(!isset($params['userid']) || !isset($params['uuid'])) return self::ERROR_CMD_PARAM;
        $params = $this->pushImmediatelyBefore($params);
        
        $_task = new TaskBehavior();
        $result = '';
        foreach($tasks as $v){
            $method = 'do'.ucfirst($v['item']);
            if(!method_exists($this, $method)) continue;
            $result .= $this->$method($v, $params);
            $_task->edit($v['id'], array('lasttime' => time()));
        }
        return $result;
    }
    
    /**
     * 定时推送
     * @param array $row 
     */
    private function pushCrontab($tasks, $params)
    {
        if(empty($tasks)) return self::ERROR_CMD_TASK;
        if(!isset($params['userid']) || !isset($params['uuid'])) return self::ERROR_CMD_PARAM;
        $params = $this->pushImmediatelyBefore($params);
        
        $_task = new TaskBehavior();
        $result = '';
        foreach($tasks as $v){
            $method = 'do'.ucfirst($v['item']);
            if(!method_exists($this, $method)) continue;
            $_task->setRuntime($v['id'], 1);
            $result .= $this->$method($v, $params);
            $_task->edit($v['id'], array('runtime' => 0, 'lasttime' => time()));
        }
    }
    
    /**
     * 即时推送预处理
     * @param array $params
     * @return array 
     */
    private function pushImmediatelyBefore($params)
    {
        $userid = $params['userid'];
        $shopid = $params['shopid'];
        
        $_user = new UserBehavior();
        $pushSetting = $_user->getPushSetting($userid);
        if(empty($pushSetting) || $pushSetting['pushable'] == 0) return self::ERROR_CMD_USER;
        if(empty($pushSetting['user_id']) || empty($pushSetting['platform'])) return self::ERROR_CMD_BIND;
        
        $_shop = new MerchantShopBehavior();
        $shopR = $_shop->getById($shopid);
        $shopname = $shopR->name;
        return array_merge($params, $pushSetting, array('shopname' => $shopname));
    }
    
    /**
     * 推送欢迎通知
     * @param record $tasks
     * @param array $params
     * @return integer
     */
    private function doWelcome($tasks, $params)
    {
        $checkRs = $this->doWelcomeCheck($params['userid'], $params['shopid'], $tasks['item']);
        if(!$checkRs) return self::ERROR_CMD_REPEAT;
        $msg = $this->getMsg($tasks['msg'], $params['shopname']);
        $messages = $this->getMessages($msg, $params['platform']);
        $_task = new TaskBehavior();
        $logId = $_task->logAdd($tasks['id'], array('start' => time()));
        $pushRs = $this->bdPush($params['platform'], $params['user_id'], $messages);
        
        if($pushRs){
            $success = 1;
            $result = self::ERROR_CMD_NONE;
            
            $info = array(
                'to' => $params['userid'],
                'shopid' => $params['shopid'],
                'type' => $tasks['item'],
                'message' => json_encode($messages, true),
            );
            if(!$this->add($info)) $result = self::ERROR_CMD_DB;
        }else{
            $success = 0;
            $result = self::ERROR_CMD_PUSH;
        }
        $info = array(
            'end' => time(),
            'success' => $success,
            'result' => $result,
        );
        $_task->logEdit($logId, $info);
        return $result;
    }
    
    /*private function doLike()
    {
        //
    }*/
    
    /**
     * 一天内一家店仅推送一条欢迎通知给用户
     * @param array $data 
     *    pushid: 推送ID
     * @return mixed
     */
    private function doWelcomeCheck($userid, $shopid, $type) {
        $criteria = new CDbCriteria();
        $criteria->select = 'created';
        $criteria->addCondition("`to` = '$userid'");
        $criteria->addCondition("`shopid` = '$shopid'");
        $criteria->addCondition("`type` = '$type'");
        $criteria->order = 'created DESC';
        $pushR = Push::model()->find($criteria);
        if(!empty($pushR) && MingString::sameDay($pushR->created, time())) return false;
        return true;
    }
    
    /**
     * 获取推送消息
     * @param string $msg
     * @param string $platform
     * @param array $extra
     * @return array 
     */
    private function getMessages($msg, $platform, $extra = array())
    {
        $key = 'msg_'.rand(100000000, 999999999);
        if(preg_match("/^http[s]?:\/\/[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$/ui", $msg)){
            $message = array(
                'description' => Yii::app()->params->title,
                'notification_basic_style' => 7,
                'open_type' => 1,
                'user_confirm' => 1,
                'url' => $msg,
                'aps' => array(
                    'sound' => '',
                    'badge' => 1
                )
            );
        }else{
            $message = array(
                'description' => $msg,
                'notification_basic_style' => 7,
                'aps' => array(
                    'sound' => '',
                    'badge' => 1
                )
            );
        }
        if($platform == 'android') $message['title'] = Yii::app()->params->title;
        if(!empty($extra)){
            if($platform == 'ios'){
                $message = array_merge($message, $extra);
            }else{
                $message = array_merge($message, array('custom_content' => $extra));
            }
        }
        return array(
            'type' => Yii::app()->params->message_type,
            'key' => $key,
            'msg' => json_encode($message)
        );
    }

    /**
     * 获取推送消息主体内容
     * @param string $msgtpl
     * @param mixed $param
     * @return string
     */
    private function getMsg($msgtpl, $param)
    {
        if(strpos($msgtpl, '%') === false) return $msgtpl;
        return vsprintf($msgtpl, $param);
    }
    
    /**
     * 百度推送
     * @param string $platform
     * @param integer $user_id
     * @param array $messages
     * @return type
     */
    private function bdPush($platform, $user_id, $messages)
    {
        $_baiduPush = new BaiduPush(Yii::app()->params->apikey, Yii::app()->params->secretkey);
        if($platform == 'ios'){
            $release_cert = realpath(Yii::app()->basePath.Yii::app()->params->pem_pro);
            $dev_cert = realpath(Yii::app()->basePath.Yii::app()->params->pem_dev);
            $_baiduPush->initAppIoscert2 (
                Yii::app()->params->title, 
                Yii::app()->params->meta_description, 
                $release_cert, 
                $dev_cert, 
                Yii::app()->params->deployed
            );
        }
        return $_baiduPush->pushMessage2($platform, 1, $user_id, $messages, Yii::app()->params->deployed);
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
}