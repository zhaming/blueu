<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title><?php echo $this->getPageTitle()?></title>
		<meta name="description" content="<?php echo $this->getPageState('description')?>">
		<meta name="keywords" content="<?php echo $this->getPageState('keywords')?>">

		<link rel="stylesheet" type="text/css" href="/statics/css/skin.css">
		<script type="text/javascript" src="/statics/plugins/jquery-1.7.2.min.js"></script>
		
<script type="text/javascript" src="/statics/plugins/highslide/highslide-with-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="/statics/plugins/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '/statics/plugins/highslide/graphics/';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
//hs.dimmingOpacity = 0.75;

// Add the controlbar
hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: 0.75,
		position: 'bottom center',
		hideOnMouseOut: true
	}
});
</script>
<!--[if IE 6]>
	<script src="//letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>
	<script></script>
<![endif]-->
<!--[if IE 6]>
<script type="text/javascript" src="/statics/plugins/iepngfix/iepngfix_tilebg.js"></script>
<link rel="stylesheet" type="text/css" href="/statics/css/fix_ie6.css">
<![endif]-->
	</head>
	<body>
	<div class="head ie6fixedTL">
		<div class="nav">
			<div class="logo">
				<img title="<?php echo Config::model()->get('name')?>logo" alt="<?php echo Config::model()->get('name')?>logo" src="/statics/images/logo.png"/>
				<div class="logo_title">
					<h1><?php echo Config::model()->get('name')?></h1>
					<p><?php echo Config::model()->get('description')?></p>
				</div>
			</div>
			<ul>
				<li><a href="/">首页</a></li>
				<li><a href="/article/service">定制网站</a></li>
				<li><a href="/case">客户案例</a></li>
				<li><a href="/product">快速建站</a></li>
				<li><a href="/contact">联系我们</a></li>
			</ul>
			<div class="phone">
				<span class="phone_icon"></span>
				<h1>咨询电话：<?php echo Config::model()->get('tel');?></h1>
			</div>
			<div class="search"><form method="GET" id="search_form" action="/search"><input class="search_input" name="keyword" value="<?php echo empty($_GET['keyword'])?'':$_GET['keyword']?>" placeholder="您想看的行业、喜欢的颜色" type="text" /><input type="submit" class="search_buttom" value="搜索"></form></div>
		</div>
	</div>

<script type="text/javascript">

$(document).ready(function(){
	
	$(".head").fadeTo("fast", 0.95); // This sets the opacity of the thumbs when the page loads
});

	$("#search_form").keydown(function(event){ 
		//console.log(event.keyCode); 
		if(event.keyCode == 13)
			$(this).submit();
	});
</script>

	<?php echo $content; ?>

<script>
	$(".case .content a").each(function(){
		if($(this).find('img').size() > 1)
		{
			var $this = $(this).find('img');
			var time = 5000+Math.ceil(Math.random()*30000);

			setInterval(function(){
				if($this.eq(0).css('margin-top') == (-$this.size()+1)*140+'px')
					$this.eq(0).animate( { marginTop: '0px'}, { queue: false, duration: 1000 });
				else
					$this.eq(0).animate( { marginTop: '-=140px'}, { queue: false, duration: 1000 });
			},time);
		}
	})
</script>

	<h1 class="addr">公司地址：<?php echo Config::model()->get('addr');?>，咨询电话：<?php echo Config::model()->get('tel');?></h1>
	<p class="footer"><?php echo Config::model()->get('icp')?> © Copyright 2013.<a href="http://wanthings.com">Wanthings.Com</a> All Right Reserved </p>
<div class="hidden">
		<?php echo Config::model()->get('stats');?>
	</div>
		<?php echo Config::model()->get('baidu_share');?>
		<?php echo Config::model()->get('im');?>
	</body>
</html>
