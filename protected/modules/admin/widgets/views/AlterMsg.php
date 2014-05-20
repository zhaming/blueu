<?php $message = Yii::app()->user->getFlash('messagetip'); if ($message != null) { ?>
        <div class="alert alert-block <?php echo $message['type'] == 'success'?"alert-success":"alert-danger"  ?>">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            <p>
                <strong>
                    <?php echo $message['msg']; ?>
                </strong>
            </p>
        </div>
<?php } ?>