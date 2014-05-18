<?php

class StationController extends BController {

    public function actionIndex() {
        $filters = Yii::app()->request->getQuery('filters');
        $listData = BlueStation::model()->findAll();
        $this->render('index', array('listData' => $listData));
    }

    public function actionAdd() {
        $id = '';
        $name = '';
        $describ = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id');
            $name = Yii::app()->request->getPost('name');
            $describ = Yii::app()->request->getPost('describ');
            if (!empty($id) && !empty($name) && !empty($describ)) {
                $criteria = new CDbCriteria;
                $criteria->addColumnCondition(array('id' => $id));
                if (BlueStation::model()->exists($criteria)) {
                    $this->showError('已经存在此基站编码, 请重新指定');
                } else {
                    $model = new BlueStation;
                    $model->id = $id;
                    $model->name = $name;
                    $model->describ = $describ;
                    if ($model->save()) {
                        $this->showSuccess('保存成功', $this->createUrl('edit?id=' . $id));
                    } else {
                        $this->showError('保存失败');
                    }
                }
            } else {
                $this->showError('请填写完整信息');
            }
        }
        $this->render('add', compact('id', 'name', 'describ'));
    }

    public function actionEdit() {
        $id = '';
        $name = '';
        $describ = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getQuery('id');
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id' => $id));
            $model = BlueStation::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作', $this->createUrl('index'));
            } else {
                $name = Yii::app()->request->getPost('name');
                $describ = Yii::app()->request->getPost('describ');
                if (!empty($name) && !empty($describ)) {
                    $model->name = $name;
                    $model->describ = $describ;
                    if ($model->save()) {
                        $this->showSuccess('保存成功', $this->createUrl('edit?id=' . $id));
                    } else {
                        $this->showError('保存失败');
                    }
                } else {
                    $this->showError('请填写完整信息');
                }
            }
        } else {
            $criteria = new CDbCriteria;
            $id = Yii::app()->request->getQuery('id');
            $criteria->addColumnCondition(array('id' => $id));
            $model = BlueStation::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作', $this->createUrl('index'));
            } else {
                $id = $model->id;
                $name = $model->name;
                $describ = $model->describ;
            }
        }
        $this->render('edit', compact('id', 'name', 'describ'));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id' => $id));
            $model = BlueStation::model()->find($criteria);
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
