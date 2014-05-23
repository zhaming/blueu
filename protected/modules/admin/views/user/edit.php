<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <form class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#basic">
                            <i class="green icon-user bigger-125"></i>
                            <?php echo Yii::t('admin', 'Overview'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#edit-basic">
                            <i class="green icon-edit bigger-125"></i>
                            <?php echo Yii::t('admin', 'Edit'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#edit-password">
                            <i class="blue icon-key bigger-125"></i>
                            <?php echo Yii::t('admin', 'Reset password'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="basic" class="tab-pane in active">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 center">
                                <span class="profile-picture">
                                    <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="/statics/upload/avatar/profile-pic.jpg"></img>

                                </span>
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <div class="profile-user-info">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"><?php echo Yii::t('admin', 'Username'); ?></div>
                                        <div class="profile-info-value">
                                            <span><?php echo $account->username; ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"><?php echo Yii::t('admin', 'Status'); ?></div>
                                        <div class="profile-info-value">
                                            <span><?php echo HelpTemplate::accountStatus($account->status); ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"><?php echo Yii::t('admin', 'Sex'); ?></div>
                                        <div class="profile-info-value">
                                            <span><?php echo HelpTemplate::sex($user->sex); ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"><?php echo Yii::t('admin', 'Century'); ?></div>
                                        <div class="profile-info-value">
                                            <span><?php echo $user->century; ?>&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"><?php echo Yii::t('admin', 'Registration time'); ?></div>
                                        <div class="profile-info-value">
                                            <span><?php echo date('Y/m/d H:i:s', $account->registertime); ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"><?php echo Yii::t('admin', 'Last Online'); ?></div>
                                        <div class="profile-info-value">
                                            <span><?php echo date('Y/m/d H:i:s', $account->logintime); ?></span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div id="edit-basic" class="tab-pane">
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
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-status"><?php echo Yii::t('admin', 'Enable'); ?></label>
                            <div class="col-sm-9">
                                <label class="control-label">
                                    <input id="form-field-status" name="user[status]" class="ace ace-switch ace-switch-2" type="checkbox" checked />
                                    <span class="lbl"></span>
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
                    <div id="edit-password" class="tab-pane">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1"><?php echo Yii::t('admin', 'New password'); ?></label>
                            <div class="col-sm-9">
                                <input type="password" name="newpassword" id="form-field-pass1">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                            <div class="col-sm-9">
                                <input type="password" name="repassword" id="form-field-pass2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="button">
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