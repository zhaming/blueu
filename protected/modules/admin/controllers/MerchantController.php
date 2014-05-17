<?php 
class MerchantController extends BController
{
    public function actionIndex()
    {
        $filters = Yii::app()->request->getQuery('filters');
        $listData = Merchant::model()->findAll();
        $this->render('index', array('listData' => $listData));
    }

    public function actionAdd()
    {
        $id = '';
        $name = '';
        $describ = '';
        $pic = '';
        $url = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id');
            $name = Yii::app()->request->getPost('name');
            $describ = Yii::app()->request->getPost('describ');
            $url = Yii::app()->request->getPost('url');
            $blueid = Yii::app()->request->getPost('blueid');
            if (!empty($id) && !empty($name) && !empty($describ) && !empty($blueid)) {
                $criteria = new CDbCriteria;
                $criteria->addColumnCondition(array('id'=>$id));
                if (Merchant::model()->exists($criteria)) {
                    $this->showError('商户编号已存在, 请重新指定');
                } else {
                    $model = new Merchant;
                    $model->id = $id;
                    $model->name = $name;
                    $model->url = $url;
                    $model->describ = $describ;
                    $model->blueid = $blueid;
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
        $blueid = Yii::app()->request->getQuery('blueid');
        $rc_station = BlueStation::model()->findAll();
        $this->render('add', compact('id', 'name', 'describ', 'pic', 'url', 'blueid', 'rc_station'));
    }

    public function actionEdit()
    {
        $id = '';
        $name = '';
        $describ = '';
        $pic = '';
        $url = '';
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getQuery('id');
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id'=>$id));
            $model = Merchant::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作',  $this->createUrl('index'));
            } else {
                $name = Yii::app()->request->getPost('name');
                $url = Yii::app()->request->getPost('url');
                $describ = Yii::app()->request->getPost('describ');
                $blueid = Yii::app()->request->getPost('blueid');
                if (!empty($name) && !empty($describ)) {
                    $model->name = $name;
                    $model->url = $url;
                    $model->describ = $describ;
                    $model->blueid = $blueid;
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
            $criteria->addColumnCondition(array('id'=>$id));
            $model = Merchant::model()->find($criteria);
            if (is_null($model)) {
                $this->showError('非法操作',  $this->createUrl('index'));
            } else {
                $id = $model->id;
                $name = $model->name;
                $url = $model->url;
                $describ = $model->describ;
                $pic = $model->pic;
                $blueid = $model->blueid;
            }
        }
        $rc_station = BlueStation::model()->findAll();
        $this->render('edit', compact('id', 'name', 'describ', 'pic', 'url', 'blueid', 'rc_station'));
    }

    public function actionDelete()
    {
        $id = Yii::app()->request->getQuery('id');
        if (!empty($id)) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('id'=>$id));
            $model = Merchant::model()->find($criteria);
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
