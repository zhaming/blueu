<div class="page-header">
    <h1>用户管理<small><i class="icon-double-angle-right"></i>编辑</small></h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#edit-basic">
                            <i class="green icon-edit bigger-125"></i><font><font>
                            基本信息
                            </font></font></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#edit-password">
                            <i class="blue icon-key bigger-125"></i><font><font>
                            重置密码
                            </font></font></a>
                    </li>
                </ul>
                <div class="tab-content profile-edit-tab-content">
                    <div id="edit-basic" class="tab-pane in active">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-email"><font><font>电子邮件</font></font></label>

                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input type="email" id="form-field-email" value="alexdoe@gmail.com">
                                    <i class="icon-envelope"></i>
                                </span>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-website"><font><font>网站</font></font></label>

                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input type="url" id="form-field-website" value="http://www.alexdoe.com/">
                                    <i class="icon-globe"></i>
                                </span>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-phone"><font><font>电话</font></font></label>

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
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1"><font><font>新密码</font></font></label>

                            <div class="col-sm-9">
                                <input type="password" id="form-field-pass1">
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2"><font><font>确认密码</font></font></label>

                            <div class="col-sm-9">
                                <input type="password" id="form-field-pass2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="button">
                        <i class="icon-ok bigger-110"></i><font><font>
                        节省
                        </font></font></button>

                    &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i><font><font>
                        复位
                        </font></font></button>
                </div>
            </div>
        </form>
    </div><!-- /span -->
</div>