<?php

/*
 * 文件操作相关业务
 */

/**
 * 2014-5-22 10:21:49 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * FileBehavior.php hugb
 *
 */
class FileBehavior extends BaseBehavior {

    public function saveUploadFile($filename="file") {
        $fileInstance = CUploadedFile::getInstanceByName($filename);

        $file = new File();
        $file->deleted = 0;
        $file->ctime = time();
        $file->name = $fileInstance->name;
        $file->type = $fileInstance->type;
        $file->size = $fileInstance->size;
        $file->extension = $fileInstance->extensionName;
        $file->hash = md5_file($fileInstance->getTempName());
        $file->path = date('y/m/d/') . $file->hash . (empty($file->extension) ? '' : '.' . $file->extension);

        $fileObj = File::model()->findByAttributes(array('hash' => $file->hash));
        if ($fileObj != null) {
            $this->error = Yii::t('admin', 'File already exists');
            return $fileObj;
        }
        if (!$file->save()) {
            $this->error = Yii::t('admin', 'Save the file information to database fails');
            return false;
        }
        $fileDirectory = $this->getOriginalDirectory() . DIRECTORY_SEPARATOR . date('y/m/d/');
        if (!file_exists($fileDirectory)) {
            mkdir($fileDirectory, 0777, true);
        }
        if (!$fileInstance->saveAs($this->getOriginalDirectory() . DIRECTORY_SEPARATOR . $file->path)) {
            $this->error = Yii::t('admin', 'Save the file fails');
            return false;
        }
        return $file->getAttributes();
    }

    public function saveUploadAvatar() {
        $file = $this->saveUploadFile();
        if (!$file) {
            return false;
        }
        Yii::import("ext.EPhpThumb.EPhpThumb");
        $thumb = new EPhpThumb();
        $thumb->init();

        $originalPath = $this->getOriginalDirectory() . DIRECTORY_SEPARATOR . $file['path'];
        $destPath = $this->getAvatarDirectory() . DIRECTORY_SEPARATOR . $file['path'];
        if (!file_exists(dirname($destPath))) {
            mkdir($destPath, 0777, true);
        }

        if (!$thumb->create($originalPath)->resize(100, 100)->save($destPath)) {
            $this->error = Yii::t('admin', 'Failed to generate thumbnails');
            return false;
        }
        return $file;
    }

    public function isHaveUploadFile($filename="file") {
        return CUploadedFile::getInstanceByName($filename) != null;
    }

    public function getAvatarDirectory() {
        return YiiBase::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'avatar';
    }

    public function getLogoDirectory() {
        return YiiBase::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'logo';
    }

    public function getOriginalDirectory() {
        return YiiBase::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'original';
    }

}