<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try {
            ace.settings.check('breadcrumbs', 'fixed');
        } catch (e) {
            console.log(e);
        }
    </script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="/admin"><?php echo Yii::t('admin', 'Home'); ?></a>
        </li>
        <li class="active"><?php echo $menu; ?></li>
    </ul>
</div>