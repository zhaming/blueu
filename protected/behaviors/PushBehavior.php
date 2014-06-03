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
    const ERROR_CMD_LIMIT = 5;
    const ERROR_CMD_PUSH = 6;
    const ERROR_CMD_DB = 7;
    const ERROR_CMD_LIKE = 8;
    const ERROR_CMD_MANUAL = 9;
    
    private $total = 0;
    private $success = 0;
    
    static $sleep = 5;
    
    
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
                if($rs){
                    $params = array(
                        'userid' => $data['userid'],
                        'uuid' => $data['uuid'],
                        'shopid' => $stationR->shopid,
                    );
                    $this->runCommand($params);
                }
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
     * 获取关注列表
     * @param string $sql
     * @return mixed
     */
    public function getLikeBySql($sql)
    {
        return Like::model()->findAllBySql($sql);
    }
    
    /**
     * 获取人工推送列表
     * @param string $sql
     * @return mixed
     */
    public function getManualBySql($sql)
    {
        return PushManual::model()->findAllBySql($sql);
    }
    
    /**
     * 人工推送成功次数递增
     * @param integer $id
     * @param integer $cnt
     * @return mixed 
     */
    public function plusManual($id, $cnt = 1)
    {
        return PushManual::model()->updateCounters(array('count' => $cnt), "id = '$id'");
    }
    
    /**
     * 调用后台命令
     * @param array $params
     */
    private function runCommand($params)
    {
        $params = json_encode($params);
        $command = sprintf(Yii::app()->params->pushCmd, realpath(Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'), 1, $params);
        return exec($command);
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
     * @param record $tasks 
     * @param array $params
     * @return string
     */
    private function pushImmediately($tasks, $params)
    {
        if(empty($tasks)) return self::ERROR_CMD_TASK;
        if(!isset($params['userid']) || !isset($params['uuid'])) return self::ERROR_CMD_PARAM;
        $params = $this->pushImmediatelyBefore($params);
        if(!is_array($params)) return $params;
        
        $_task = new TaskBehavior();
        $result = '';
        foreach($tasks as $v){
            $method = 'do'.ucfirst($v['item']);
            if(!method_exists($this, $method)) continue;
            $logId = $_task->logAdd($v['id'], array('start' => time()));
            
            $rs = $this->$method($v, $params);
            $result .= $rs;
            
            $_task->edit($v['id'], array('lasttime' => time()));
            $info = array(
                'end' => time(),
                'total' => $this->total,
                'success' => $this->success,
                'result' => $rs,
            );
            $_task->logEdit($logId, $info);
        }
        return $result === '' ? self::ERROR_CMD_TASK : $result;
    }
    
    /**
     * 定时推送
     * @param array $row 
     */
    private function pushCrontab($tasks, $params)
    {
        /*if(empty($tasks)) return self::ERROR_CMD_TASK;
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
            
        }*/
    }
    
    /**
     * 即时推送预处理
     * @param array $params
     * @return mixed 
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
        $this->total = 1;
        $this->success = 0;
        $checkRs = $this->doWelcomeCheck($params['userid'], $params['shopid'], $tasks['item']);
        if(!$checkRs) return self::ERROR_CMD_LIMIT;
        $msg = $this->getMsg($tasks['msg'], $params);
        $messages = $this->getMessages($msg, $params['platform']);
        $pushRs = $this->bdPush($params['platform'], $params['user_id'], $messages);
        if(!$pushRs) return self::ERROR_CMD_PUSH;
        $this->success = 1;
        
        $info = array(
            'to' => $params['userid'],
            'shopid' => $params['shopid'],
            'type' => $tasks['item'],
            'message' => json_encode($messages),
        );
        if(!$this->add($info)) return self::ERROR_CMD_DB;
        return self::ERROR_CMD_NONE;
    }
    
    /**
     * 推送关注通知
     * @param record $tasks
     * @param array $params
     * @return integer
     */
    private function doLike($tasks, $params)
    {
        $this->total = 1;
        $this->success = 0;
        $checkRs = $this->doLikeCheck($tasks['sql'], $tasks['ext'], $tasks['item'], $params);
        if($checkRs !== true) return $checkRs;
        $msg = $this->getMsg($tasks['msg'], $params);
        $messages = $this->getMessages($msg, $params['platform'], array('shopid' => $params['shopid']));
        $pushRs = $this->bdPush($params['platform'], $params['user_id'], $messages);
        if(!$pushRs) return self::ERROR_CMD_PUSH;
        $this->success = 1;
        
        $info = array(
            'to' => $params['userid'],
            'shopid' => $params['shopid'],
            'type' => $tasks['item'],
            'message' => json_encode($messages),
        );
        if(!$this->add($info)) return self::ERROR_CMD_DB;
        return self::ERROR_CMD_NONE;
    }
    
    /**
     * 推送人工通知
     * @param record $tasks
     * @param array $params
     * @return integer
     */
    private function doManual($tasks, $params)
    {
        $this->total = $this->success = 0;
        $manualRs = $this->doManualCheck($tasks['sql'], $tasks['ext'], $params);
        if(is_int($manualRs)) return $manualRs;
        
        $result = '';
        foreach($manualRs as $v){
            $this->total++;
            if($v->limit > 0 && $v->limit <= $v->count){
                $result .= self::ERROR_CMD_LIMIT;
                continue;
            }
            $msgtpl = empty($v->msg) ? $tasks['msg'] : $v->msg;
            $msg = $this->getMsg($msgtpl, array_merge($params, array('name' => $v->name)));
            $extra = array(
                'shopid' => $v->shopid,
                'source' => $v->source,
                'sid' => $v->sid,
            );
            $messages = $this->getMessages($msg, $params['platform'], $extra);
            $pushRs = $this->bdPush($params['platform'], $params['user_id'], $messages);
            if(!$pushRs){
                $result .= self::ERROR_CMD_PUSH;
                continue;
            }
            $this->plusManual($v->id);
            $this->success++;
            
            $info = array(
                'to' => $params['userid'],
                'shopid' => $params['shopid'],
                'type' => $tasks['item'],
                'message' => json_encode($messages),
            );
            if(!$this->add($info))
                $result .= self::ERROR_CMD_DB;
            else
                $result .= self::ERROR_CMD_NONE;
        }
        return $result;
    }
    
    /**
     * 一天内一家店仅推送一条欢迎通知给用户
     * @param integer $userid
     * @param integer $shopid
     * @param string $type
     * @return boolean
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
     * 基于用户关注推送
     * 基于用户接收关注推送频率推送
     * @param string $sql
     * @param string $ext
     * @param string $type
     * @param array $params
     * @return mixed
     */
    private function doLikeCheck($sql, $ext, $type, $params) {
        if(strpos($sql, '%') === false) return self::ERROR_CMD_TASK;
        $ext = json_decode($ext, true);
        if(empty($ext)) return false;
        $arr = array();
        foreach($ext as $v){
            $arr[] = $params[$v];
        }
        $sql = vsprintf($sql, $arr);
        $rs = $this->getLikeBySql($sql);
        if(empty($rs)) return self::ERROR_CMD_LIKE;
        
        if($params['likepush'] == '1'){
            $userid = $params['userid'];
            $shopid = $params['shopid'];
            $criteria = new CDbCriteria();
            $criteria->select = 'created';
            $criteria->addCondition("`to` = '$userid'");
            $criteria->addCondition("`shopid` = '$shopid'");
            $criteria->addCondition("`type` = '$type'");
            $pushR = Push::model()->find($criteria);
            if(!empty($pushR)) return self::ERROR_CMD_LIMIT;
        }
        return true;
    }
    
    /**
     * 基于人工推送列表推送
     * @param string $sql
     * @param string $ext
     * @param array $params
     * @return mixed
     */
    private function doManualCheck($sql, $ext, $params) {
        if(strpos($sql, '%') === false) return self::ERROR_CMD_TASK;
        $ext = json_decode($ext, true);
        if(empty($ext)) return self::ERROR_CMD_TASK;
        $arr = array();
        foreach($ext as $v){
            $arr[] = $params[$v];
        }
        $sql = vsprintf($sql, $arr);
        $rs = $this->getManualBySql($sql);
        if(empty($rs)) return self::ERROR_CMD_MANUAL;
        return $rs;
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
     * @param mixed $params
     * @return string
     */
    private function getMsg($msgtpl, $params)
    {
        $matches = array();
        $cnt = preg_match_all('/({.*?})/ui', $msgtpl, $matches);
        if(empty($cnt)) return $msgtpl;
        foreach($matches[0] as $v){
            $k = substr($v, 1, -1);
            $msgtpl = str_replace($v, $params[$k], $msgtpl);
        }
        return $msgtpl;
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
}