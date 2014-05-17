<?php
class  UserController extends IController
{
    public function actionIndex()
    {
        if ($this->method == 'POST') {
            $result = array();
            $result['errcode'] = 0;
            $result['errmsg'] = 'success';
            if (isset($_POST['name']) && isset($_POST['blueid'])) {
                $name = $_POST['name'];
                $blueid = $_POST['blueid'];
                $criteria = new CDbCriteria;
                $criteria->addColumnCondition(
                    array(
                        'name'=>$name,
                        'blueid'=>$blueid,
                    )
                );
                $users = User::model()->find($criteria);
                if (is_null($users)) {
                    $user = new User();
                    $user->name = $name;
                    $user->blueid = $blueid;
                    if (!$user->save()) {
                        $this->showError(100);
                        Yii::app()->end();
                    }
                }
                echo JsonTools::json_encode_cn($result);
                Yii::app()->end();
            }
        }
        $this->showError(100);
        Yii::app()->end();
    }

}
?>
