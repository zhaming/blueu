<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->getLocale()->getId(); ?>"
      dir="<?php echo Yii::app()->getLocale()->getOrientation(); ?>">
    <head>
        <base id="web_base" href="<?php echo Yii::app()->params->host; ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
        <meta name="language" content="<?php echo Yii::app()->getLocale()->getId(); ?>" />
        <meta content="<?php echo Yii::app()->params->meta_keywords; ?>" name="keywords" />
        <meta content="<?php echo Yii::app()->params->meta_description; ?>" name="description" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link href="/statics/favicon.ico" rel="shortcut icon" />

        <!-- basic styles -->
        <link rel="stylesheet" href="/statics/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/statics/css/font-awesome.min.css" />

        <!--[if IE 7]>
        <link rel="stylesheet" href="/statics/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->
        <link rel="stylesheet" href="/statics/css/jquery-ui-1.10.3.custom.min.css" />
        <link rel="stylesheet" href="/statics/css/jquery.gritter.css" />
        <link rel="stylesheet" href="/statics/css/select2.css" />
        <link rel="stylesheet" href="/statics/css/bootstrap-editable.css" />
        <link rel="stylesheet" href="/statics/css/chosen.css" />
        <link rel="stylesheet" href="/statics/css/datepicker.css" />
        <link rel="stylesheet" href="/statics/css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="/statics/css/daterangepicker.css" />
        <link rel="stylesheet" href="/statics/css/colorpicker.css" />

        <!-- fonts -->
        <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->

        <!-- ace styles -->
        <link rel="stylesheet" href="/statics/css/ace.min.css" />
        <link rel="stylesheet" href="/statics/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="/statics/css/ace-skins.min.css" />

        <!--[if lte IE 8]>
        <link rel="stylesheet" href="/statics/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="/statics/js/ace-extra.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="/statics/js/html5shiv.js"></script>
        <script src="/statics/js/respond.min.js"></script>
        <![endif]-->
        <!-- basic scripts -->
        <!--[if !IE]> -->
        <script src="/statics/js/jquery-2.0.3.min.js"></script>
        <!-- <![endif]-->

        <!--[if IE]>
        <script src="/statics/js/jquery-1.10.2.min.js"></script>
        <![endif]-->

        <script type="text/javascript">
            if ("ontouchend" in document) {
                document.write("<script src='/statics/js/jquery.mobile.custom.min.js'>" + "<" + "script>");
            }
        </script>
        <script src="/statics/js/bootstrap.min.js"></script>
        <script src="/statics/js/typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
        <script src="/statics/js/excanvas.min.js"></script>
        <![endif]-->

        <script src="/statics/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="/statics/js/jquery.ui.touch-punch.min.js"></script>
        <!-- Gritter 是一个小型的 jQuery 消息通知插件,图片上传使用到 -->
        <script src="/statics/js/jquery.gritter.min.js"></script>
        <!--<script src="/statics/js/jquery.slimscroll.min.js"></script>-->
        <script src="/statics/js/jquery.easy-pie-chart.min.js"></script>
        <script src="/statics/js/jquery.sparkline.min.js"></script>
        <script src="/statics/js/date-time/bootstrap-timepicker.min.js"></script>
        <script src="/statics/js/date-time/bootstrap-datepicker.min.js"></script>
        <script src="/statics/js/jquery.maskedinput.min.js"></script>
        <script src="/statics/js/x-editable/bootstrap-editable.min.js"></script>
        <script src="/statics/js/x-editable/ace-editable.min.js"></script>
        <script src="/statics/js/bootbox.min.js"></script>

        <!--<script src="/statics/js/flot/jquery.flot.min.js"></script>-->
        <!--<script src="/statics/js/flot/jquery.flot.pie.min.js"></script>-->
        <!--script src="/statics/js/flot/jquery.flot.resize.min.js"></script>-->

        <!-- ace scripts -->

        <script src="/statics/js/ace-elements.min.js"></script>
        <script src="/statics/js/ace.min.js"></script>

        <script src="/statics/js/esl/esl.js"></script>
    </head>

    <body>
        <?php $this->widget('application.modules.admin.widgets.NavbarWidget'); ?>
        <div class="main-container" id="main-container">
            <div class="main-container-inner">
                <?php $this->widget('application.modules.admin.widgets.SidebarWidget'); ?>
                <div class="main-content">
                    <?php $this->widget('application.modules.admin.widgets.BreadcrumbsWidget'); ?>
                    <div class="page-content">
                        <?php echo $content; ?>
                    </div>
                </div>
                <?php $this->widget('application.modules.admin.widgets.SettingWidget'); ?>
            </div>
            <a id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div>

        <script type="text/javascript">
            jQuery(function($) {
                // 删除确认
                $(".delete-confirm").click(function() {
                    return confirm('Are you absolutely sure you want to delete?');
                });
                // 批量删除表单提交确认
                $(".batch-delete-confirm").click(function() {
                    if (confirm('Are you absolutely sure you want to delete?')) {
                        $(".batch-delete-form").submit();
                    }
                });
                // 首页统计效果
                $('.easy-pie-chart.percentage').each(function() {
                    var $box = $(this).closest('.infobox');
                    var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
                    var trackColor = barColor === 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
                    var size = parseInt($(this).data('size')) || 50;
                    $(this).easyPieChart({
                        barColor: barColor,
                        trackColor: trackColor,
                        scaleColor: false,
                        lineCap: 'butt',
                        lineWidth: parseInt(size / 10),
                        animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                        size: size
                    });
                });
                $('.sparkline').each(function() {
                    var $box = $(this).closest('.infobox');
                    var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
                    $(this).sparkline('html', {tagValuesAttribute: 'data-values', type: 'bar', barColor: barColor, chartRangeMin: $(this).data('min') || 0});
                });
                // 表单记录批量选择
                $('table th input:checkbox').on('click', function() {
                    var that = this;
                    $(this).closest('table').find('tr > td:first-child input:checkbox').each(function() {
                        this.checked = that.checked;
                        $(this).closest('tr').toggleClass('selected');
                    });
                });
                // 上传选择图片
                $('#id-input-file-single-upload').ace_file_input({
                    //style: true,
                    no_file: '',
                    //no_icon: "icon-upload-alt",
                    btn_choose: '选择',
                    btn_change: '重新选择',
                    icon_remove: "icon-remove",
                    //droppable: false,
                    thumbnail: true, //| true | large
                    before_change: function(files, dropped) {
                        var allowed_files = [];
                        for (var i = 0; i < files.length; i++) {
                            var file = files[i];
                            if (typeof file === "string") {
                                //IE8 and browsers that don't support File Object
                                if (!(/\.(jpe?g|png|gif|bmp)$/i).test(file)) {
                                    return false;
                                }
                            } else {
                                var type = $.trim(file.type);
                                if ((type.length > 0 && !(/^image\/(jpe?g|png|gif|bmp)$/i).test(type)) || (type.length === 0 && !(/\.(jpe?g|png|gif|bmp)$/i).test(file.name))) {//for android's default browser which gives an empty string for file.type
                                    continue;
                                }
                            }
                            allowed_files.push(file);
                        }
                        if (allowed_files.length === 0) {
                            return false;
                        }
                        return allowed_files;
                    }//,
                    //before_remove: null,
                    //preview_error: null
                });
                // 图片编辑
                $.fn.editable.defaults.mode = 'inline';
                $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
                $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>' +
                        '<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>';

                if (/msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) {
                    Image.prototype.appendChild = function(el) {
                    };
                }

                $('#mobile').editable({
                    type: 'text',
                    name: 'username'
                });

                //another option is using modals
                $('#avatar2').on('click', function() {
                    var modal = '<div class="modal hide fade">\
                            <div class="modal-header">\
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>\
                                    <h4 class="blue">Change Avatar</h4>\
                            </div>\
                            \
                            <form class="no-margin">\
                            <div class="modal-body">\
                                    <div class="space-4"></div>\
                                    <div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
                            </div>\
                            \
                            <div class="modal-footer center">\
                                    <button type="submit" class="btn btn-small btn-success"><i class="icon-ok"></i> Submit</button>\
                                    <button type="button" class="btn btn-small" data-dismiss="modal"><i class="icon-remove"></i> Cancel</button>\
                            </div>\
                            </form>\
                    </div>';

                    var modal = $(modal);
                    modal.modal("show").on("hidden", function() {
                        modal.remove();
                    });

                    var working = false;

                    var form = modal.find('form:eq(0)');
                    var file = form.find('input[type=file]').eq(0);
                    file.ace_file_input({
                        style: 'well',
                        btn_choose: 'Click to choose new avatar',
                        btn_change: null,
                        no_icon: 'icon-picture',
                        thumbnail: 'small',
                        before_remove: function() {
                            //don't remove/reset files while being uploaded
                            return !working;
                        },
                        before_change: function(files, dropped) {
                            var file = files[0];
                            if (typeof file === "string") {
                                //file is just a file name here (in browsers that don't support FileReader API)
                                if (!(/\.(jpe?g|png|gif)$/i).test(file))
                                    return false;
                            }
                            else {//file is a File object
                                var type = $.trim(file.type);
                                if ((type.length > 0 && !(/^image\/(jpe?g|png|gif)$/i).test(type))
                                        || (type.length == 0 && !(/\.(jpe?g|png|gif)$/i).test(file.name))//for android default browser!
                                        )
                                    return false;

                                if (file.size > 110000) {//~100Kb
                                    return false;
                                }
                            }

                            return true;
                        }
                    });

                    form.on('submit', function() {
                        if (!file.data('ace_input_files'))
                            return false;

                        file.ace_file_input('disable');
                        form.find('button').attr('disabled', 'disabled');
                        form.find('.modal-body').append("<div class='center'><i class='icon-spinner icon-spin bigger-150 orange'></i></div>");

                        var deferred = new $.Deferred;
                        working = true;
                        deferred.done(function() {
                            form.find('button').removeAttr('disabled');
                            form.find('input[type=file]').ace_file_input('enable');
                            form.find('.modal-body > :last-child').remove();

                            modal.modal("hide");

                            var thumb = file.next().find('img').data('thumb');
                            if (thumb)
                                $('#avatar2').get(0).src = thumb;

                            working = false;
                        });


                        setTimeout(function() {
                            deferred.resolve();
                        }, parseInt(Math.random() * 800 + 800));

                        return false;
                    });

                });

                try {
                    ace.settings.check('navbar', 'fixed');
                    ace.settings.check('sidebar', 'fixed');
                    ace.settings.check('main-container', 'fixed');
                    ace.settings.check('breadcrumbs', 'fixed');

                    var last_gritter;
                    // 编辑用户头像
                    $('.image-edit-select1').editable({
                        type: 'image',
                        name: 'avatar',
                        value: null,
                        image: {
                            btn_choose: 'Change Picture',
                            droppable: true,
                            /**
                             //this will override the default before_change that only accepts image files
                             before_change: function(files, dropped) {
                             return true;
                             },
                             */

                            //and a few extra ones here
                            name: 'file', //put the field name here as well, will be used inside the custom plugin
                            max_size: 11000000, //~100Kb
                            on_error: function(code) {//on_error function will be called when the selected file has a problem
                                if (last_gritter) {
                                    $.gritter.remove(last_gritter);
                                }
                                if (code === 1) {//file format error
                                    last_gritter = $.gritter.add({
                                        title: 'File is not an image!',
                                        text: 'Please choose a jpg|gif|png image!',
                                        class_name: 'gritter-error gritter-center'
                                    });
                                } else if (code === 2) {//file size rror
                                    last_gritter = $.gritter.add({
                                        title: 'File too big!',
                                        text: 'Image size should not exceed 100Kb!',
                                        class_name: 'gritter-error gritter-center'
                                    });
                                } else {//other error

                                }
                            },
                            on_success: function() {
                                $.gritter.removeAll();
                            }
                        },
                        url: function(params) {
                            // ***UPDATE AVATAR HERE*** //
                            //You can replace the contents of this function with examples/profile-avatar-update.js for actual upload


                            var deferred = new $.Deferred;

                            //if value is empty, means no valid files were selected
                            //but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
                            //so we return just here to prevent problems
                            var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
                            if (!value || value.length === 0) {
                                deferred.resolve();
                                return deferred.promise();
                            }


                            //dummy upload
                            setTimeout(function() {
                                if ("FileReader" in window) {
                                    //for browsers that have a thumbnail of selected image
                                    var thumb = $('.image-edit-select').next().find('img').data('thumb');
                                    if (thumb) {
                                        $('.image-edit-select').get(0).src = thumb;
                                    }
                                }
                                deferred.resolve({'status': 'OK'});
                                if (last_gritter) {
                                    $.gritter.remove(last_gritter);
                                }
                                last_gritter = $.gritter.add({
                                    title: 'Avatar Updated!',
                                    text: 'Uploading to server can be easily implemented. A working example is included with the template.',
                                    class_name: 'gritter-info gritter-center'
                                });
                            }, parseInt(Math.random() * 800 + 800));

                            return deferred.promise();
                        },
                        success: function(response, newValue) {
                        }
                    });
                } catch (e) {
                }
            });
        </script>
    </body>
</html>

