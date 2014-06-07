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
<script type="text/javascript">
    require.config({
        baseUrl: '/statics/',
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
        title : {
            text: '未来一周气温变化',
            subtext: '纯属虚构'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['最高气温','最低气温']
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : ['周一','周二','周三','周四','周五','周六','周日']
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel : {
                    formatter: '{value} °C'
                },
                splitArea : {show : true}
            }
        ],
        series : [
            {
                name:'最高气温',
                type:'line',
                itemStyle: {
                    normal: {
                        lineStyle: {
                            shadowColor : 'rgba(0,0,0,0.4)',
                            shadowBlur: 5,
                            shadowOffsetX: 3,
                            shadowOffsetY: 3
                        }
                    }
                },
                data:[11, 11, 15, 13, 12, 13, 10],
                markPoint : {
                    data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name: '平均值'}
                    ]
                }
            },
            {
                name:'最低气温',
                type:'line',
                /*itemStyle: {
                    normal: {
                        lineStyle: {
                            shadowColor : 'rgba(0,0,0,0.4)',
                            shadowBlur: 5,
                            shadowOffsetX: 3,
                            shadowOffsetY: 3
                        }
                    }
                },*/
                data:[1, -2, 2, 5, 3, 2, 0],
                markPoint : {
                    data : [
                        {name : '周最低', value : -2, xAxis: 1, yAxis: -1.5}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name : '平均值'}
                    ]
                }
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