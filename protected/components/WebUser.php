<?php

class WebUser extends CWebUser {

    protected function beforeLogin($id, $states, $fromCookie) {
        return true;
    }

    protected function afterLogin($fromCookie) {
        $model = User::model()->findByPk($this->getId());
        if (!empty($model)) {
            //$model->vip = getenv('remote_addr');
            //$model->last_time = time();
            //$model->save();
        }
        //	$session = $_SESSION;//Yii::app()->user->getPersistentStates();
        //	print_r($session);
    }

    protected function beforeLogout() {
        return true;
    }

    protected function afterLogout() {
        
    }

    public function getGid() {
        if ($this->getId() !== Null) {
            $user = User::model()->findByPk($this->getId());
            if (!empty($user))
                return $user['role_id'];
        }
        return Null;
    }

}

?>
