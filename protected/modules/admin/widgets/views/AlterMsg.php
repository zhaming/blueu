<?php $message = Yii::app()->user->getFlash('messagetip'); if ($message != null) { ?>
<div class="alert alert-block<?php if ($message['type'] == 'success') { ?> alert-success<?php } ?><?php if ($message['type'] == 'error') { ?> alert-denger<?php } ?>">
    <p>
        <strong>
            <i class="<?php if ($message['type'] == 'success') { ?>icon-ok<?php } ?><?php if ($message['type'] == 'error') { ?>icon-remove<?php } ?>"></i>
            <?php echo $message['msg']; ?>
        </strong>
    </p>
</div>
<?php } ?>