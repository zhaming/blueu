<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->getLocale()->getId(); ?>"
      dir="<?php echo Yii::app()->getLocale()->getOrientation(); ?>">
    <head>
        <base id="web_base" href="<?php echo Yii::app()->params->host; ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
        <meta name="language" content="<?php echo Yii::app()->getLocale()->getId(); ?>" />
        <meta content="<?php echo Yii::app()->params->meta_keywords; ?>" name="keywords" />
        <meta content="<?php echo Yii::app()->params->meta_description; ?>" name="description" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link href="/statics/favicon.ico" rel="shortcut icon" />
    </head>
    <body><?php echo $content; ?></body>
</html>
