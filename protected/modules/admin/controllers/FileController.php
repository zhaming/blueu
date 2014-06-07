<?php

/*
 * 文件上传
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * FileController.php hugb
 *
 */
class FileController extends BController {

    protected $fileBehavior;
    protected $userBehavior;
    protected $advertisementBehavior;

    public function init() {
        parent::init();
        $this->layout = false;
        $this->fileBehavior = new FileBehavior();
        $this->userBehavior = new UserBehavior();
        $this->advertisementBehavior = new AdvertisementBehavior();
    }

    public function actionUpload() {
        $data = array(
            'code' => 0,
            'message' => 'Success',
            'data' => null
        );
        $this->layout = false;
        $id = Yii::app()->request->getPost('id');
        $type = Yii::app()->request->getPost('type');
        if (empty($id)) {
            $data['code'] = 1;
            $data['message'] = Yii::t('Request params error.');
            echo CJSON::encode($data);
            return;
        }
        if (empty($type)) {
            $data['code'] = 1;
            $data['message'] = Yii::t('Request params error.');
            echo CJSON::encode($data);
            return;
        }
        if (!$this->fileBehavior->isHaveUploadFile()) {
            $data['code'] = 2;
            $data['message'] = Yii::t('admin', 'No files uploaded.');
            echo CJSON::encode($data);
            return;
        }
        switch ($type) {
            case 1:
                $file = $this->fileBehavior->saveUploadAvatar();
                if (!$file) {
                    $data['code'] = 3;
                    $data['message'] = $this->fileBehavior->getError();
                    echo CJSON::encode($data);
                    return;
                }
                if (!$this->userBehavior->edit(array('id' => $id, 'avatar' => $file['path']))) {
                    $data['code'] = 4;
                    $data['message'] = $this->fileBehavior->getError();
                    echo CJSON::encode($data);
                    return;
                }
                $data['url'] = HelpTemplate::getAvatarUrl($file['path']);
                break;
            case 2:
                $file = $this->fileBehavior->saveUploadAd();
                if (!$file) {
                    $data['code'] = 3;
                    $data['message'] = $this->fileBehavior->getError();
                    echo CJSON::encode($data);
                    return;
                }
                if (!$this->advertisementBehavior->update($id, array('pic' => $file['path']))) {
                    $data['code'] = 4;
                    $data['message'] = $this->fileBehavior->getError();
                    echo CJSON::encode($data);
                    return;
                }
                $data['url'] = HelpTemplate::getAdUrl($file['path']);
                break;
        }
        echo CJSON::encode($data);
    }

}
