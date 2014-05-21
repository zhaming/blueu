<div class="page-header">
    <h1>管理员信息</h1>
</div>
<div id="user-profile-3" class="user-profile row">
    <div class="col-sm-offset-1 col-sm-10">
        <div class="well well-sm">
            <button type="button" class="close" data-dismiss="alert">×</button>
            &nbsp;
            <div class="inline middle blue bigger-110"> 您的个人资料是完成70％ </div>

            &nbsp; &nbsp; &nbsp;
            <div style="width:200px;" data-percent="70%" class="inline middle no-margin progress progress-striped active">
                <div class="progress-bar progress-bar-success" style="width:70%"></div>
            </div>
        </div>
        <div class="space"></div>
        <?php if (!empty($message)) { ?>
            <div class="alert alert-block alert-danger">
                <p>
                    <strong>
                        <?php echo $message; ?>
                    </strong>
                </p>
            </div>
        <?php } ?>

        <div class="space"></div>
        <form action="/admin/manager/edit" method="post" class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#edit-basic">
                            <i class="green icon-edit bigger-125"></i>
                            基本信息
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#edit-password">
                            <i class="blue icon-key bigger-125"></i>
                            密码
                        </a>
                    </li>
                </ul>
                <div class="tab-content profile-edit-tab-content">
                    <div id="edit-basic" class="tab-pane in active">
                        <h4 class="header blue bolder smaller">一般</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="ace-file-input ace-file-multiple"><input type="file"><label class="file-label" data-title="Change avatar"><span class="file-name" data-title="No File ..."><i class="icon-picture"></i></span></label><a class="remove" href="#"><i class="icon-remove"></i></a></div>
                            </div>
                            <div class="vspace-xs"></div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">用户名</label>
                                    <div class="col-sm-8">
                                        <input class="col-xs-12 col-sm-10" type="text" id="form-field-username" placeholder="Username" value="alexdoe">
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-first">名称</label>
                                    <div class="col-sm-8">
                                        <input class="input-small" type="text" id="form-field-first" placeholder="First Name" value="Alex">
                                        <input class="input-small" type="text" id="form-field-last" placeholder="Last Name" value="Doe">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-date">出生日期</label>
                            <div class="col-sm-9">
                                <div class="input-medium">
                                    <div class="input-group">
                                        <input class="input-medium date-picker" id="form-field-date" type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">
                                            <i class="icon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">性别</label>
                            <div class="col-sm-9">
                                <label class="inline">
                                    <input name="form-field-radio" type="radio" class="ace">
                                    <span class="lbl"> 男性</span>
                                </label>
                                &nbsp; &nbsp; &nbsp;
                                <label class="inline">
                                    <input name="form-field-radio" type="radio" class="ace">
                                    <span class="lbl"> 女</span>
                                </label>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-comment">评论</label>
                            <div class="col-sm-9">
                                <textarea id="form-field-comment"></textarea>
                            </div>
                        </div>
                        <div class="space"></div>
                        <h4 class="header blue bolder smaller">联系</h4>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-email">电子邮件</label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input type="email" id="form-field-email" value="alexdoe@gmail.com">
                                    <i class="icon-envelope"></i>
                                </span>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-website">网站</label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input type="url" id="form-field-website" value="http://www.alexdoe.com/">
                                    <i class="icon-globe"></i>
                                </span>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">电话</label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input class="input-medium input-mask-phone" type="text" id="form-field-phone">
                                    <i class="icon-phone icon-flip-horizontal"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="edit-password" class="tab-pane">
                        <div class="space-10"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">密码</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" id="form-field-pass1">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">新密码</label>
                            <div class="col-sm-9">
                                <input type="password" name="newpassword" id="form-field-pass2">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">确认密码</label>
                            <div class="col-sm-9">
                                <input type="password" name="repassword" id="form-field-pass3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="icon-ok bigger-110"></i>保存
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>