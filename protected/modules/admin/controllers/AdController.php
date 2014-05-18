<?php

class AdController extends BController {

    public function actionIndex() {
        $filters = Yii::app()->request->getQuery('filters');
        $merid = Yii::app()->request->getQuery('merid');
        $criteria = new CDbCriteria;
        if (!is_null($merid)) {
            $criteria->addColumnCondition(array('merid' => $merid));
        }
        $listData = Advertisement::model()->findAll($criteria);
        $this->render('index', array('listData' => $listData));
    }

    public function actionAdd() {
        $id = '';
        $name = '';
        $describ = '';
        $pic = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id');
            $name = Yii::app()->request->getPost('name');
            $pic = Yii::app()->request->getPost('pic');
            $describ = Yii::app()->request->getPost('describ');
            $merid = Yii::app()->request->getQuery('merid');
            if (!empty($id) && !empty($name) && !empty($merid) && !empty($describ)) {
                $criteria = new CDbCriteria;
                $criteria->addColumnCondition(array('id' => $id));
                if (Advertisement::model()->exists($criteria)) {
                    $this->showError('已经存在此广告编码, 请重新指定');
                } else {
                    $model = new Advertisement;
                    $model->id = $id;
                    $model->name = $name;
                    $model->describ = $describ;
                    $model->merid = $merid;
                    $file_cpt = new FilesComponent;
                    $upload_ret = $file_cpt->upload('pic');
                    if ($upload_ret) {
                        $model->pic = $upload_ret['hash'];
                    }
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
        $this->render('add', compact('id', 'name', 'pic', 'describ'));
    }

    public function actionEdit() {
        $id = '';
        $name = '';
        $describ = '';
        $pic = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getQuery('id');
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id' => $id));
            $model = Advertisement::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作', $this->createUrl('index'));
            } else {
                $name = Yii::app()->request->getPost('name');
                $describ = Yii::app()->request->getPost('describ');
                if (!empty($name) && !empty($describ)) {
                    $model->name = $name;
                    $model->describ = $describ;
                    $file_cpt = new FilesComponent;
                    $upload_ret = $file_cpt->upload('pic');
                    if ($upload_ret) {
                        $model->pic = $upload_ret['hash'];
                    }
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
            $model = Advertisement::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作', $this->createUrl('index'));
            } else {
                $id = $model->id;
                $name = $model->name;
                $describ = $model->describ;
                $pic = $model->pic;
            }
        }
        $this->render('edit', compact('id', 'name', 'pic', 'describ'));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id' => $id));
            $model = Advertisement::model()->find($criteria);
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
