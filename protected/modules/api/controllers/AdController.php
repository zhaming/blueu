<?php
class AdController extends IController
{
    public function actionIndex()
    {
        if ($this->method == 'GET' && isset($_GET['merid'])) {
            $result = array();
            $result['errcode'] = 0;
            $result['errmsg'] = 'success';
            $result['data'] = array();
            $merid = $_GET['merid'];
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('merid'=>$merid));
            $queryResult = Advertisement::model()->findAll($criteria);
            if (!empty($queryResult)) {
                foreach ($queryResult as $key => $value) {
                    $data = array();
                    $data['id'] = $value->id;
                    $data['name'] = $value->name;
                    $data['describ'] = $value->describ;
                    $data['pic'] = FilesComponent::getImageUrl($value->pic);
                    $result['data'][] = $data;
                }
            }
            echo JsonTools::json_encode_cn($result);
            Yii::app()->end();
        }
        $this->showError(100);
        Yii::app()->end();
    }
}
?>
