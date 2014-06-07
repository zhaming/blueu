function fixhover(doms, hoverclass){
    if(hoverclass == '' || hoverclass == null) return false;
    if(doms == '' || doms == null) {
        if(Browser.ie < 7) {
            var dom = document.all;
            for(var i = 0; i < dom.length; i++) {
                Form.hover(dom[i], hoverclass);
            }
        }
    } else {
        $(doms).each(function(){
            Form.hover($(this), hoverclass);
        });
    }
}

function formvalidate(form, rule, message, errorcontainer) {
    $.validator.setDefaults({
        errorClass: 'validateError',
        submitHandler: function(){document.forms[0].submit();}
    });
    $.validator.addMethod('username', function(value, element){
        var reg = /^[0-9a-zA-Z_]+$/;
        return this.optional(element) || reg.test(value);
    }, '用户名只能包括英文字母、数字和下划线');
	$.validator.addMethod('common_value', function(value, element){
        var reg = /^[0-9a-zA-Z_,]+$/;
        return this.optional(element) || reg.test(value);
    }, '只能包括英文字母、数字、逗号和下划线');
    $.validator.addMethod('password', function(value, element){
        var reg = /^[0-9a-zA-Z_]+$/;
        return this.optional(element) || reg.test(value);
    }, '密码只能包括英文字母、数字和下划线');
    $.validator.addMethod('mobile', function(value, element){
		var reg = /^(((1[3,5,8,9]{1}[0-9]{1}))+\d{8})$/;
        //var reg = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
        return this.optional(element) || (value.length == 11 && reg.test(value));
    }, '请输入合法的手机号码');
    $.validator.addMethod('phone', function(value, element){
        var reg = /^(\d{3,4}-?)?\d{7,9}$/;
        return this.optional(element) || reg.test(value);
    }, '请输入合法的电话号码');
    $.validator.addMethod('zip', function(value, element){
        var reg = /^[1-9]\d{5}$/;
        return this.optional(element) || reg.test(value);
    }, '请输入合法的邮政编码');
    $.validator.addMethod('ip', function(value, element){
        var reg = /^(\d+)\.(\d+)\.(\d+)\.(\d+)$/;
        return this.optional(element) || (reg.test(value) && (RegExp.$1 < 256 && RegExp.$2< 256 && RegExp.$3< 256 && RegExp.$4< 256));
    }, "请输入合法的IP信息");
    $.validator.addMethod('qq', function(value, element){
        var reg = /^[1-9]\d{4,8}$/;
        return this.optional(element) || reg.test(value);
    }, "请输入合法的QQ号码");
    $.validator.addMethod('english', function(value, element){
        var reg = /^[A-Za-z]+$/;
        return this.optional(element) || reg.test(value);
    }, '请输入英文字母');
    $.validator.addMethod('chinese', function(value, element){
        var reg = /^[\u0391-\uFFE5]+$/;
        return this.optional(element) || reg.test(value);
    }, '请输入中文字符');
    $.validator.addMethod('score', function(value, element){
        var reg = /^\+?[1-9][0-9]*$/;
        return this.optional(element) || reg.test(value);
    }, '请输入正整数');
	$.validator.addMethod('numeric', function(value, element){
        var reg = /^\d+?$/;
        return this.optional(element) || reg.test(value);
    }, '请输入数字');
	$.validator.addMethod('code', function(value, element){
        var reg = /^[0-9]*$/;
        return this.optional(element) || reg.test(value);
    }, '请输入正数字');
	$.validator.addMethod('endTime', function(value, element){
		var strdt1 = $('#start_time').val().replace(/-/g,"/");
		var strdt2 = $('#end_time').val().replace(/-/g,"/");
		var dt1=new Date(Date.parse(strdt1));
		var dt2=new Date(Date.parse(strdt2));
		var result=true;
		if(dt1>dt2)
		{
			result=false;
		}
		return this.optional(element) || result;
    }, '结束时间不能小于开始时间');
	$.validator.addMethod('kwTime', function(value, element){
		var strdt1 = $('#kw_start').val().replace(/-/g,"/");
		var strdt2 = $('#kw_end').val().replace(/-/g,"/");
		var dt1=new Date(Date.parse(strdt1));
		var dt2=new Date(Date.parse(strdt2));
		var result=true;
		if(dt1>dt2)
		{
			result=false;
		}
		return this.optional(element) || result;
    }, '结束时间不能小于开始时间');
	$.validator.addMethod('deadline', function(value, element){
		var strdt1 = $('#deadline').val().replace(/-/g,"/");
		var strdt2 = $('#end_time').val().replace(/-/g,"/");
		var dt1=new Date(Date.parse(strdt1));
		var dt2=new Date(Date.parse(strdt2));
		var result=true;
		if(dt1>dt2)
		{
			result=false;
		}
		return this.optional(element) || result;
    }, '报名结束时间不能大于活动结束时间');
	$.validator.addMethod('url', function(value, element){
        var reg = /^http(s)?:\/\/(?!([\w-]+\.[\w-]+$))([\w-]+\.)+[\w-]+(\/[\w-   .\/?%&=]*)?$/;
		if('#' != value)
        	return this.optional(element) || reg.test(value);
		else
			return true;
    }, '请输入正确的url');
    jQuery.extend(jQuery.validator.messages, {
            required: "必填字段",
            remote: "请修正该字段",
            email: "请输入正确格式的电子邮件",
            url: "请输入合法的网址",
            date: "请输入合法的日期",
            dateISO: "请输入合法的日期 (ISO).",
            number: "请输入合法的数字",
            digits: "只能输入整数",
            creditcard: "请输入合法的信用卡号",
            equalTo: "请再次输入相同的值",
            accept: "请输入拥有合法后缀名的字符串",
            maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
            minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
            rangelength: jQuery.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
            range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
            max: jQuery.validator.format("请输入一个最大为 {0} 的值"),
            min: jQuery.validator.format("请输入一个最小为 {0} 的值")
    });
    if(message == '' || message == null) message = {};
    var container = null;
    if($(errorcontainer) != undefined) container = $(errorcontainer);
    $(form).validate({
        rules: rule,
        messages: message,
        errorLabelContainer: container
    });
}

function cascadingDropDown(dom1, dom2, ajaxUrl, defaultCid)
{
    $.getJSON(ajaxUrl, {type:$(dom1).val()}, function(json){
        $(dom2).empty();
        $.each(json, function(key, value){
            if(value == '') return;
            var selected = '';
            if(defaultCid == key) selected = " selected='selected'";
            var option = '<option value=' + key + selected + '>' + value + '</option>';
            $(dom2).append(option);
        });
    });
}

function toBreakWord(dom, length) {
    $(dom).each(function(){
        var word = $(this).html();
        var newWord = '';
        while(word.length > length) {
            newWord += word.substr(0, length) + '<br>';
            word = word.substr(length, word.length);
        }
        $(this).html(newWord + word);
    });
}

function JsonToString(o) {    
    var arr = []; 
    var fmt = function(s) { 
        if (typeof s == 'object' && s != null) return JsonToString(s); 
        return /^(string|number)$/.test(typeof s) ? "'" + s + "'" : s; 
    } 
    for (var i in o) 
         arr.push("'" + i + "':" + fmt(o[i])); 
    return '{' + arr.join(',') + '}'; 
}



var Order = {
	arrow_up: 'statics/images/spinner_up.gif',
	arrow_down: 'statics/images/spinner_down.gif',
	title_up: '升序',
	title_down: '降序'
};

Order.init = function(doms){
	if(doms == undefined) return false;

	for(var i = 0; i < doms.length; i++){
		var dom = $(doms[i]);
		if(dom == null || dom == undefined) continue;
		Order.view(dom);
		dom.click(function(){
			Order.order($(this), 'one');
		});
	}
};

Order.order = function(dom, type){
	var field = dom.attr('id');
	var url = location.href.substr(location.host.length + location.href.indexOf(location.host));
	url = url.toLowerCase();
	var orderSplitor = '+';//兼容Yii框架URL规则
	var defaultOrder = field + orderSplitor + 'desc';
	var orderK = 'order';
	var orderUrl = '';
	var splitor = ',';
	if(type == null) type = 'one';
	var regText = (url.indexOf('?') == -1) ? "\/order\/([^\/]+)" : "&order=([^&]+)";
	var reg = new RegExp(regText, "g");

	if(url.indexOf(orderK) == -1){
		orderUrl = '&' + orderK + '=' + defaultOrder;
		if(url.indexOf('?') == -1){
			orderUrl = '/' + orderK + '/' + defaultOrder;
		}
		url += orderUrl;
	}else{
		if(url.indexOf('?') == -1){
			matches = url.match(/\/order\/([^\/]+)/);
		}else{
			matches = url.match(/&order=([^&]+)/);
		}
		if(matches != null){
			var orderKV = matches[0];
			var orderV = matches[1];
			if(orderV.indexOf(field) !== 0){
				if(type == 'one'){
					orderNKV = orderKV.replace(reg, function($0, $1){
						return $0.replace($1, defaultOrder);
					});
				}else{
					orderNKV = orderKV + splitor + defaultOrder;
				}
			}else{
				orderVs = orderV.split(splitor);
				for(var i = 0; i < orderVs.length; i++){
					curOrder = orderVs[i];
					if(curOrder.indexOf(field) !== 0) continue;
					curOrders = curOrder.split(orderSplitor);
					if(curOrders[1] == 'asc'){
						curOrderNew = curOrders[0] + orderSplitor + 'desc';
					}else{
						curOrderNew = curOrders[0] + orderSplitor + 'asc';
					}
					if(type == 'one'){
						orderVs = [];
						orderVs[0] = curOrderNew;
						break;
					}
					orderVs[i] = curOrderNew;
				}
				orderNV = orderVs.join(splitor);
				orderNKV = orderKV.replace(orderV, orderNV);
			}
			url = url.replace(orderKV, orderNKV);
		}
	}

	location.href = url;
};

Order.view = function(dom){
	var field = dom.attr('id');
	var url = location.href.substr(location.host.length + location.href.indexOf(location.host));
	url = url.toLowerCase();
	var orderSplitor = escape(' ');
	var regText = '(/|=|,)' + field + '(.?|' + orderSplitor + ')' + '(asc|desc)';
	var reg = new RegExp(regText, "g");

	dom.css('cursor', 'pointer');
	dom.css('text-decoration', 'underline');
    dom.attr('title', '点击排序');

	matches = url.match(reg);
	if(matches == null) return false;
	var curArrow = Order.arrow_down;
	var curTitle = Order.title_down;
	if(matches[0].indexOf('desc') == -1){
		curArrow = Order.arrow_up;
		curTitle = Order.title_up;
	}

	var imgdiv = $("<img>");
	imgdiv.attr("src", curArrow);
	imgdiv.attr("title", curTitle);
	imgdiv.css("vertical-align", "middle");
	imgdiv.css("margin-left", "3px");
	imgdiv.appendTo(dom);
};

var Chart = {
    baseUrl: '/statics/js',
    opt: {
        tooltip: {trigger:'axis',axisPointer:{type:'shadow'}},
        toolbox: {show:true,feature:{saveAsImage:{show:true}}},
        grid: {x:30,y:30,x2:30,y2:30},
        calculable: false,
        markPoint: {data:[{type:'max',name:'最大值'},{type:'min',name:'最小值'}]},
        markLine: {data:[{type:'average',name:'平均值'}]},
    }
};

Chart.init = function(domid, url, param, extra)
{
    var dom = document.getElementById(domid);
    if(dom == null || dom == undefined) return;
    require.config({
        baseUrl: Chart.baseUrl,
        packages: [{
                name: 'echarts',
                location: 'echarts',
                main: 'echarts'
            },{
                name: 'zrender',
                location: 'zrender',
                main: 'zrender'
        }]
    });
    require(
        [
            'echarts',
            'echarts/chart/line',
            'echarts/chart/pie',
            'echarts/chart/bar'
        ], 
        function(ec) {
            var _chart = ec.init(dom);
            _chart.showLoading({text: 'Loading..', effect: 'whirling'});
            Chart.option(url, param, extra, _chart);
        }
    );
};

Chart.option = function(url, param, extra, _chart)
{
    var _xAxis;
    var _series = new Array();
    $.getJSON(url, param, function(json){
        $.each(json, function(key, value){
            if(value == '' || value == false) return;
            _xAxis = value.xAxis?value.xAxis:[];
            var datas = null;
            if(value.yAxis){
                datas = {data:value.yAxis, extra:value.extra};
            }else if(value.series){
                datas = {data:value.series, extra:value.extra};
            }
            var serie = Chart.serie(value.name, datas, extra.series);
            _series.push(serie);
        });
        var _option = {
            title: extra.title?extra.title:'',
            legend: extra.legend?extra.legend:'',
            tooltip: extra.tooltip?extra.tooltip:Chart.opt.tooltip,
            toolbox: extra.toolbox?extra.toolbox:Chart.opt.toolbox,
            grid: extra.grid?extra.grid:Chart.opt.grid,
            calculable: extra.calculable?extra.calculable:Chart.opt.calculable,
            xAxis: [{data: _xAxis}],
            yAxis: [extra.yAxis?extra.yAxis:{}],
            series : _series
        };
        console.log(_option);
        //alert(JsonToString(_option));
        _chart.hideLoading();
        _chart.setOption(_option);
    });
};

Chart.serie = function(name, datas, extra)
{
    var _itemStyle = {};
    if(datas.extra.itemStyle) _itemStyle = eval('(' + datas.extra.itemStyle + ')');
    var _serie = {
        name: name,
        type: extra.type?extra.type:'line',
        itemStyle: _itemStyle,
        radius: datas.extra.radius?datas.extra.radius:[],
        data: datas.data?datas.data:[],
        markPoint: extra.maxmin?Chart.opt.markPoint:null,
        markLine: extra.average?Chart.opt.markLine:null
    };
    return _serie;
}

/**
 * HTML patterns
 *
 * @author Craig Campbell
 * @version 1.0.9
 */
Rainbow.extend('html', [
    {
        'name': 'source.php.embedded',
        'matches': {
            2: {
                'language': 'php'
            }
        },
        'pattern': /&lt;\?=?(?!xml)(php)?([\s\S]*?)(\?&gt;)/gm
    },
    {
        'name': 'source.css.embedded',
        'matches': {
            1: {
                'matches': {
                    1: 'support.tag.style',
                    2: [
                        {
                            'name': 'entity.tag.style',
                            'pattern': /^style/g
                        },
                        {
                            'name': 'string',
                            'pattern': /('|")(.*?)(\1)/g
                        },
                        {
                            'name': 'entity.tag.style.attribute',
                            'pattern': /(\w+)/g
                        }
                    ],
                    3: 'support.tag.style'
                },
                'pattern': /(&lt;\/?)(style.*?)(&gt;)/g
            },
            2: {
                'language': 'css'
            },
            3: 'support.tag.style',
            4: 'entity.tag.style',
            5: 'support.tag.style'
        },
        'pattern': /(&lt;style.*?&gt;)([\s\S]*?)(&lt;\/)(style)(&gt;)/gm
    },
    {
        'name': 'source.js.embedded',
        'matches': {
            1: {
                'matches': {
                    1: 'support.tag.script',
                    2: [
                        {
                            'name': 'entity.tag.script',
                            'pattern': /^script/g
                        },

                        {
                            'name': 'string',
                            'pattern': /('|")(.*?)(\1)/g
                        },
                        {
                            'name': 'entity.tag.script.attribute',
                            'pattern': /(\w+)/g
                        }
                    ],
                    3: 'support.tag.script'
                },
                'pattern': /(&lt;\/?)(script.*?)(&gt;)/g
            },
            2: {
                'language': 'javascript'
            },
            3: 'support.tag.script',
            4: 'entity.tag.script',
            5: 'support.tag.script'
        },
        'pattern': /(&lt;script(?! src).*?&gt;)([\s\S]*?)(&lt;\/)(script)(&gt;)/gm
    },
    {
        'name': 'comment.html',
        'pattern': /&lt;\!--[\S\s]*?--&gt;/g
    },
    {
        'matches': {
            1: 'support.tag.open',
            2: 'support.tag.close'
        },
        'pattern': /(&lt;)|(\/?\??&gt;)/g
    },
    {
        'name': 'support.tag',
        'matches': {
            1: 'support.tag',
            2: 'support.tag.special',
            3: 'support.tag-name'
        },
        'pattern': /(&lt;\??)(\/|\!?)(\w+)/g
    },
    {
        'matches': {
            1: 'support.attribute'
        },
        'pattern': /([a-z-]+)(?=\=)/gi
    },
    {
        'matches': {
            1: 'support.operator',
            2: 'string.quote',
            3: 'string.value',
            4: 'string.quote'
        },
        'pattern': /(=)('|")(.*?)(\2)/g
    },
    {
        'matches': {
            1: 'support.operator',
            2: 'support.value'
        },
        'pattern': /(=)([a-zA-Z\-0-9]*)\b/g
    },
    {
        'matches': {
            1: 'support.attribute'
        },
        'pattern': /\s(\w+)(?=\s|&gt;)(?![\s\S]*&lt;)/g
    }
], true);
