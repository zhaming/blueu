<?php if (Yii::app()->user->hasFlash('alertmsg')): ?>
    <?php $msg = Yii::app()->user->getFlash('alertmsg'); ?>
    <?php if ($msg['type'] == 'success'): ?>
    <?php $div_css_class['class'] = 'alert alert-success'; ?>
    <?php elseif ($msg['type'] == 'error'): ?>
    <?php $div_css_class['class'] = 'alert alert-error'; ?>
    <?php else: ?>
    <?php $div_css_class['class'] = 'alert alert-warning'; ?>
    <?php endif; ?>
    <?php echo CHtml::tag('div', $div_css_class); ?>
    <?php echo $msg['msg']; ?>
    <a class="close" href="#">&times;</a>
    <?php echo CHtml::closeTag('div'); ?>
<?php endif; ?>
<script>
    $('a.close').click(function(){
        //$('div.alert').slideUp();
        $(this).parent().slideUp();
    });
       
    // setTimeout(function(){
    //     $('.alert a.close').click();
    // },2000);
</script>
