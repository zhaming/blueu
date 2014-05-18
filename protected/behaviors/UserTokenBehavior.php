<?php

class UserTokenBehavior extends CActiveRecordBehavior {

    /**
     * 保持本次登录token
     * @param  [type] $user_id [description]
     * @param  [type] $token   [description]
     * @return [type]          [description]
     */
    public function saveToken($user_id, $token) {
        $result = false;
        $user = $this->getOwner()->getById($user_id);
        if (!empty($user)) {
            $user->token = $token;
            $user->last_operate = time();
            $result = $user->save();
        }
        return $result;
    }

    /**
     * 更新token 最后一次操作时间。
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function updateTokenLastOperateTime($user_id) {
        $result = false;
        $user = $this->getOwner()->getById($user_id);
        if (!empty($user)) {
            $user->last_operate = time();
            $result = $user->save();
        }
        return $result;
    }

    /**
     * 使用token 获取用户
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function getUserByToken($token) {
        $liveTime = 20 * 60;
        $user = array();
        $tmpUser = $this->getOwner()->getUserByAttributes(array('token' => $token, 'type' => User::USER_TYPE_GENERA));
        if (!empty($tmpUser)) {
            if (time() - $liveTime < $tmpUser['last_operate']) {
                $user = $tmpUser;
            }
        }
        return $user;
    }

}

?>