<?php
class MerchantController extends IController
{
    public function actionIndex()
    {
        if ($this->method == 'GET') {
            $result = array();
            $result['errcode'] = 0;
            $result['errmsg'] = 'success';
            $result['data'] = array();
            if (isset($_GET['blueid'])) {
                $blueid = $_GET['blueid'];
                $criteria = new CDbCriteria;
                $criteria->addColumnCondition(array('blueid'=>$blueid));
                $queryResult = Merchant::model()->find($criteria);
                if (!is_null($queryResult)) {
                    $data = array();
                    $data['id'] = $queryResult->id;
                    $data['name'] = $queryResult->name;
                    $data['describ'] = $queryResult->describ;
                    $data['url'] = $queryResult->url;
                    $data['pic'] = FilesComponent::getImageUrl($queryResult->pic);
                    
                    $criteriaStation = new CDbCriteria;
                    $criteriaStation->addColumnCondition(array('id'=>$blueid));
                    $queryResultStation = BlueStation::model()->find($criteriaStation);
                    if(!empty($queryResultStation)){
                        $data['positionX'] = $queryResultStation->positionX;
                        $data['positionY'] = $queryResultStation->positionY;
                    }
                    $result['data'] = $data;
                }
                echo JsonTools::json_encode_cn($result);
                Yii::app()->end();
            }
        }
        $this->showError(100);
        Yii::app()->end();
    }
}
