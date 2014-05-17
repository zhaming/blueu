<?php 
class UserController extends BController
{
    public function actionIndex()
    {
        $filters = Yii::app()->request->getQuery('filters');
        $blueid = Yii::app()->request->getQuery('blueid');
        $criteria = new CDbCriteria;
        if (!empty($blueid)) {
            $criteria->addColumnCondition(array('blueid'=>$blueid));
        }
        $listData = User::model()->findAll($criteria);
        $this->render('index', array('listData' => $listData));
    }

    public function actionDelete()
    {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id'=>$id));
            $model = User::model()->find($criteria);
            if (!is_null($model)) {
                if ($model->delete()) {
                    $this->showSuccess('删除成功', $this->createUrl('index'));
                } else {
                    $this->showError('删除失败', $this->createUrl('index'));
                }
            }
        }
        $this->showError('非法操作', $this->createUrl('index'));
    }
}
?>
