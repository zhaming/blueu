<?php if (!empty($message)) { ?>
<div class="alert alert-block alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    <i class="icon-warning-sign"></i>&nbsp;&nbsp;
    <?php echo $message; ?>	
</div>
<?php } ?>
<!--div class="row">
    <div class="col-xs-12">
        <div class="space-8"></div>
        <form action="/admin/user/create" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[username]"><?php echo Yii::t('admin', 'Username'); ?></label>
                <div class="col-sm-9">
                    <input type="text" name="user[username]" value="<?php echo $user['username'] ?>" placeholder="<?php echo Yii::t('admin', 'Username'); ?>" class="col-xs-10 col-sm-5" />
                    <span class="help-inline col-xs-12 col-sm-7">
                        <span class="middle"><?php echo Yii::t('admin', 'Pelase input email'); ?></span>
                    </span>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[password]"><?php echo Yii::t('admin', 'Password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="user[password]" value="<?php echo $user['password'] ?>" placeholder="<?php echo Yii::t('admin', 'Password'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[repassword]"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="user[repassword]" value="<?php echo $user['repassword'] ?>" placeholder="<?php echo Yii::t('admin', 'Repeat password'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[name]"><?php echo Yii::t('admin', 'Name'); ?></label>
                <div class="col-sm-9">
                    <input type="text" name="user[name]" value="<?php echo $user['name'] ?>" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[avatar]"><?php echo Yii::t('admin', 'Avatar'); ?></label>
                <div class="col-sm-9">
                    <input type="file" name="file" id="id-input-file-single-upload" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[sex]"><?php echo Yii::t('admin', 'Sex'); ?></label>
                <div class="col-sm-9">
                    <label>
                        <input name="user[sex]" value="0" type="radio"<?php if ($user['sex']==0) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'Unknown'); ?></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input name="user[sex]" value="1" type="radio"<?php if ($user['sex']==1) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'Female'); ?></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input name="user[sex]" value="2" type="radio"<?php if ($user['sex']==2) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'Male'); ?></span>
                    </label>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[mobile]"><?php echo Yii::t('admin', 'Mobile'); ?></label>
                <div class="input-group col-sm-9">
                    <input type="text" name="user[mobile]" class="col-xs-10 col-sm-5" id="form-field-mask-2" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[century]"><?php echo Yii::t('admin', 'Century'); ?></label>
                <div class="col-sm-9">
                    <select name="user[century]" class="col-sm-5">
                        <option value="other"><?php echo Yii::t('admin', 'Other'); ?></option>
                        <option value="00">00</option>
                        <option value="90">90</option>
                        <option value="80">80</option>
                        <option value="70">70</option>
                    </select>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t('admin', 'Create'); ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div-->
<div class="container">
    <div class="row">
        <div id="graphic" class="span12">
            <div id="main" style="height:400px"></div>
        </div>
    </div>
</div>

<!--echarts demo-->
<script src="/statics/js/esl/esl.js"></script>
<script type="text/javascript">
    require.config({
        packages: [
            {
                name: 'echarts',
                location: 'js/echarts',
                main: 'echarts'
            },
            {
                name: 'zrender',
                location: 'js/zrender',
                main: 'zrender'
            }
        ]
    });

    var option = {
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data:['直接访问','邮件营销','联盟广告','视频广告','搜索引擎','百度','谷歌','必应','其他']
        },
        toolbox: {
            show : true,
            orient: 'vertical',
            x: 'right',
            y: 'center',
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : ['周一','周二','周三','周四','周五','周六','周日']
            }
        ],
        yAxis : [
            {
                type : 'value',
                splitArea : {show : true}
            }
        ],
        series : [
            {
                name:'直接访问',
                type:'bar',
                data:[320, 332, 301, 334, 390, 330, 320]
            },
            {
                name:'邮件营销',
                type:'bar',
                stack: '广告',
                data:[120, 132, 101, 134, 90, 230, 210]
            },
            {
                name:'联盟广告',
                type:'bar',
                stack: '广告',
                data:[220, 182, 191, 234, 290, 330, 310]
            },
            {
                name:'视频广告',
                type:'bar',
                stack: '广告',
                data:[150, 232, 201, 154, 190, 330, 410]
            },
            {
                name:'搜索引擎',
                type:'bar',
                data:[862, 1018, 964, 1026, 1679, 1600, 1570],
                markLine : {
                    itemStyle:{
                        normal:{
                            lineStyle:{
                                type: 'dashed'
                            }
                        }
                    },
                    data : [
                        [{type : 'min'}, {type : 'max'}]
                    ]
                }
            },
            {
                name:'百度',
                type:'bar',
                barWidth : 5,
                stack: '搜索引擎',
                data:[620, 732, 701, 734, 1090, 1130, 1120]
            },
            {
                name:'谷歌',
                type:'bar',
                stack: '搜索引擎',
                data:[120, 132, 101, 134, 290, 230, 220]
            },
            {
                name:'必应',
                type:'bar',
                stack: '搜索引擎',
                data:[60, 72, 71, 74, 190, 130, 110]
            },
            {
                name:'其他',
                type:'bar',
                stack: '搜索引擎',
                data:[62, 82, 91, 84, 109, 110, 120]
            }
        ]
    };

    require(
        [
            'echarts',
            'echarts/chart/line',
            'echarts/chart/bar'
        ],
        function(ec) {
            var myChart = ec.init(document.getElementById('main'));
            myChart.setOption(option);
        }
    )
</script>