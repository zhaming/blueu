<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <form action="<?php echo $this->createUrl('edit'); ?>" method="post" class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li>
                        <a href="<?php echo $this->createUrl('detail?id=' . $user['id']); ?>">
                            <i class="green icon-user bigger-125"></i>
                            <?php echo Yii::t('admin', 'Overview'); ?>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo $this->createUrl('edit?id=' . $user['id']); ?>">
                            <i class="green icon-edit bigger-125"></i>
                            <?php echo Yii::t('admin', 'Edit information'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->createUrl('resetpwd?id=' . $user['id']); ?>">
                            <i class="blue icon-key bigger-125"></i>
                            <?php echo Yii::t('admin', 'Reset password'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="edit-basic" class="tab-pane in active">
                        <?php if (!empty($message)) { ?>
                        <div class="alert alert-block alert-danger">
                            <p><strong><?php echo $message; ?></strong></p>
                        </div>
                        <?php } ?>
                        <input type="hidden" name="user[id]" value="<?php echo $user['id']; ?>" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t('admin', 'Name'); ?></label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input id="form-field-name" name="user[name]" id="form-field-name" value="<?php echo $user['name']; ?>" type="text" />
                                    <i class="icon-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-status"><?php echo Yii::t('admin', 'Status'); ?></label>
                            <div class="col-sm-9">
                                <label>
                                    <input name="user[status]" value="0" type="radio" class="ace"<?php if ($user['status'] == 0) {?> checked="checked"<?php } ?> />
                                    <span class="lbl"><?php echo Yii::t('admin', 'Normal'); ?></span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>
                                    <input name="user[status]" value="1" type="radio" class="ace"<?php if ($user['status'] == 1) {?> checked="checked"<?php } ?> />
                                    <span class="lbl"><?php echo Yii::t('admin', 'Disable'); ?></span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>
                                    <input name="user[status]" value="2" type="radio" class="ace"<?php if ($user['status'] == 2) {?> checked="checked"<?php } ?> />
                                    <span class="lbl"><?php echo Yii::t('admin', 'Delete'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-push"><?php echo Yii::t('admin', 'Push'); ?></label>
                            <div class="col-sm-9">
                                <label class="control-label">
                                    <input id="form-field-push" name="user[push]" class="ace ace-switch ace-switch-2" type="checkbox" checked />
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="icon-ok bigger-110"></i>
                        <?php echo Yii::t('admin', 'Save'); ?>
                    </button>
                    &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        <?php echo Yii::t('admin', 'Reset'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
jQuery(function($) {
    //another option is using modals
				// *** editable avatar *** //
				try {//ie8 throws some harmless exception, so let's catch it
			
					//it seems that editable plugin calls appendChild, and as Image doesn't have it, it causes errors on IE at unpredicted points
					//so let's have a fake appendChild for it!
					if( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ) Image.prototype.appendChild = function(el){}
			
					var last_gritter
					$('#avatar').editable({
						type: 'image',
						name: 'avatar',
						value: null,
						image: {
							//specify ace file input plugin's options here
							btn_choose: 'Change Avatar',
							droppable: true,
							/**
							//this will override the default before_change that only accepts image files
							before_change: function(files, dropped) {
								return true;
							},
							*/
			
							//and a few extra ones here
							name: 'avatar',//put the field name here as well, will be used inside the custom plugin
							max_size: 110000,//~100Kb
							on_error : function(code) {//on_error function will be called when the selected file has a problem
								if(last_gritter) $.gritter.remove(last_gritter);
								if(code == 1) {//file format error
									last_gritter = $.gritter.add({
										title: 'File is not an image!',
										text: 'Please choose a jpg|gif|png image!',
										class_name: 'gritter-error gritter-center'
									});
								} else if(code == 2) {//file size rror
									last_gritter = $.gritter.add({
										title: 'File too big!',
										text: 'Image size should not exceed 100Kb!',
										class_name: 'gritter-error gritter-center'
									});
								}
								else {//other error
								}
							},
							on_success : function() {
								$.gritter.removeAll();
							}
						},
					    url: function(params) {
							// ***UPDATE AVATAR HERE*** //
							//You can replace the contents of this function with examples/profile-avatar-update.js for actual upload
			
			
							var deferred = new $.Deferred
			
							//if value is empty, means no valid files were selected
							//but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
							//so we return just here to prevent problems
							var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
							if(!value || value.length == 0) {
								deferred.resolve();
								return deferred.promise();
							}
			
			
							//dummy upload
							setTimeout(function(){
								if("FileReader" in window) {
									//for browsers that have a thumbnail of selected image
									var thumb = $('#avatar').next().find('img').data('thumb');
									if(thumb) $('#avatar').get(0).src = thumb;
								}
								
								deferred.resolve({'status':'OK'});
			
								if(last_gritter) $.gritter.remove(last_gritter);
								last_gritter = $.gritter.add({
									title: 'Avatar Updated!',
									text: 'Uploading to server can be easily implemented. A working example is included with the template.',
									class_name: 'gritter-info gritter-center'
								});
								
							 } , parseInt(Math.random() * 800 + 800))
			
							return deferred.promise();
						},
						
						success: function(response, newValue) {
						}
					})
				}catch(e) {}
});
</script>