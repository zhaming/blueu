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

var Password = {};

Password.ShowStrong = function(doms)
{
	data = Password.checkStrong($(doms[0]).val());
    $(doms[1]).hide();
	$('#' + data).show();
};

Password.checkStrong = function(sPW)
{
	Modes=0;
	for (i=0;i<sPW.length;i++){
		Modes|=Password.CharMode(sPW.charCodeAt(i));
	}
	var btotal = Password.bitTotal(Modes);
	if (sPW.length >= 10) btotal++;
	switch(btotal) {
		case 1:
			return "pw_check_1";
		case 2:
			return "pw_check_2";
		case 3:
			return "pw_check_3";
		default:
			return "pw_check_1";
	}
}

Password.CharMode = function(iN)
{
	if (iN>=65 && iN <= 90)
		return 2;
	if (iN>=97 && iN <= 122)
		return 4;
	else
		return 1;
}

Password.bitTotal = function(num)
{
	modes = 0;
	for(i=0; i<3; i++)
	{
		if (num & 1) modes++;
		num >>>= 1;
	}
	return modes;
}

function cascadingDropDown(dom1, dom2, ajaxUrl, defaultCid)
{
    $.getJSON(ajaxUrl, {cid:$(dom1).val()}, function(json){
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

function formdate(id, format, isdatetime)
{
    if(isdatetime == '' || isdatetime == undefined){
        var size = 10;
        var showTime = 'false';
        if(format == '' || format == undefined) format = '%Y-%m-%d';
    }else{
        var size = 18;
        var showTime = 'true';
        if(format == '' || format == undefined) format = '%Y-%m-%d %H:%M:%S';
    }
    var input = $('#' + id);
    if(input == undefined) return;
    input.attr('size', size);
    
    Calendar.setup({
        inputField: id,
        ifFormat  : format,
        showsTime : showTime,
        timeFormat: '24'
    });
}

var Tag = {}

Tag.init = function()
{
    var userid = $('.userinfo').attr('id');
    Tag.select();
    Tag.save(userid);
}

Tag.select = function()
{
    var taglist = '.guess-taglist';
    var tagPre = '#tag_';
    var viewPre = '#view_';
    var chkallPre = '#chkall_';
    var defaultClass = 'tag tag-gray';
    var selectedClass = 'tag tag-red';
    
    $(taglist).each(function(){
        var id = $(this).attr('id').substring(4);
        var defaultTagSelector = tagPre + id + '>span[class$=' + defaultClass.substring(4) + ']';
        var selectedTagSelector = tagPre + id + '>span[class$=' + selectedClass.substring(4) + ']';
        var viewSelector = viewPre + id;
        $(defaultTagSelector).each(function(){
            $(this).click(function(){
                if($(this).attr('class') == defaultClass)
                    $(this).attr('class', selectedClass);
                else
                    $(this).attr('class', defaultClass);
                
                var size = $(selectedTagSelector).size();
                $(viewSelector).html(size);
            });
        });

        var chkallSelector = chkallPre + id;
        $(chkallSelector).click(function(){
            if($(this).attr('chkall') != 'true'){
                $(defaultTagSelector).each(function(){
                    $(this).attr('class', selectedClass);
                });
                $(this).attr('chkall', 'true');
            }else{
                $(selectedTagSelector).each(function(){
                    $(this).attr('class', defaultClass);
                });
                $(this).attr('chkall', 'false');
            }
            
            var size = $(selectedTagSelector).size();
            $(viewSelector).html(size);
        });
    });
}

Tag.save = function(userid)
{
    var recommendSubmit = '#recommend-submit';
    var listSubmit = '#list-submit';
    var recommendClass = '.guess-tagrecommend';
    var listClass = '.guess-taglist';
    var selectedClass = 'tag tag-red';
    var recommendPre = 'recommend_';
    var listPre = 'subtag_';
    var url = '/site/saveTags';
    var itemUrl = '/site/items/id/';
    
    var recommendSelector = recommendClass + '>span[class$=' + selectedClass.substring(4) + ']';
    var listSelector = listClass + '>span[class$=' + selectedClass.substring(4) + ']';
    
    $(recommendSubmit).click(function(){
        var recommends = new Array();
        $(recommendSelector).each(function(){
            id = $(this).attr('id').replace(recommendPre, '');
            recommends.push(id);
        });

        var tags = recommends.join(',');
        $.post(url, {userid: userid, tags: tags}, function(result){
            alert(result);
        });
    });
    
    $(listSubmit).click(function(){
        var lists = new Array();
        $(listSelector).each(function(){
            id = $(this).attr('id').replace(listPre, '');
            lists.push(id);
        });
        
        var tags = lists.join(',');
        if(tags == '') {alert('亲，姐您还未选择哦');return;}
        $.post(url, {userid: userid, tags: tags}, function(result){
            if(result == 'true')
                location.href = itemUrl + userid;
            else
                alert(result);
        });
    });
}

var App = {}

App.init = function()
{
    $('.friend>a>img').each(function(){
        $(this).click(function(){
            $('.friend>a>img').attr('class', '');
            $(this).attr('class', 'imgborder');
            $('#nick').val($(this).attr('alt'));
            $('#head').val($(this).attr('src'));
            $('#name').val($(this).attr('name'));
        });
    })
}

App.click = function()
{
    $('#submit').click(function(){
        var nick = $('#nick').val();
        if(nick == ''){
            alert('请选择一个好友');
            return false;
        }
        return true;
    });
}

var Items = {}

Items.click = function(url, doms)
{
    var itemUrl = url + '/kw/';
    for(var i = 0; i < doms.length; i++){
        if($(doms[i]) == undefined || $(doms[i]) == '') continue;
		$(doms[i]).each(function(){
            $(this).click(function(){
                var kw = $(this).html();
                location.href = itemUrl + Common.trim(kw);
            });
        });
	}
}