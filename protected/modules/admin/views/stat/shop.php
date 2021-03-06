<div class="container">
    <div class="row">
        <div id="graphic" class="span12">
            <div id="main" style="height:400px"></div>
        </div>
    </div>
</div>

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
        title: {
            text: "",
            link: "http://mantis.yeamu.com/",
            x: "left",
            //y: "-20",
            //itemGap: "10px",
            //padding: "1 0",
            subtext: "",
            sublink: "http://pma.yeamu.com/",
            textStyle: {fontSize: 24},
            subtextStyle: {fontSize: 12, color: "red"}
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['蒸发量','降水量']
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
                data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
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
                name:'蒸发量',
                type:'bar',
                data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
            },
            {
                name:'降水量',
                type:'bar',
                data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
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
    
    /*require.config({
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
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'line'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data:['直接访问','邮件营销','联盟广告','视频广告','搜索引擎','百度','谷歌','必应','其他']
        },
        toolbox: {
            show : true,
            orient: 'vertical',
            x: 'right',
            y: 'bottom',
            feature : {
                mark : {show: false},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : false,
        xAxis : [
            {
                type : 'category',
                boundaryGap : true,
                data : ['周一','周二','周三','周四','周五','周六','周日']
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel : {
                    formatter: '{value} 次数'
                },
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
            myChart.showLoading({text: 'Loading..', effect: 'whirling'});
            myChart.setOption(option);
            //myChart.hideLoading();
        }
    );*/
</script>