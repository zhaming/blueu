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
}