<?php
	require('./config.ini.php');
	$key = $_GET['key'] ? $_GET['key'] : 1;
	$username = $_GET['username'] ? $_GET['username'] : '少侠';
	$title = $answerList[$key]['title'];
	$content = $answerList[$key]['content'];
	$content = str_replace('青年', $username, $content);
	
	/* 这里的地址做了相应的修改，避免泄露信息 */
	$accessTokenJson = file_get_contents('http://weixin.xxxx.com/index.php?c=jinggege&a=getAccessToken');
	$accessTokenData = json_decode($accessTokenJson, true);
	$accessToken = $accessTokenData['access_token'];
	
	$jsTicketJson = file_get_contents('./jsticket.cache');
	$tmpJsticketData = json_decode($jsTicketJson, true);
	if (!$jsTicketJson || $tmpJsticketData['end'] <= time()) {
		$jsapiUrl = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $accessToken . '&type=jsapi';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $jsapiUrl);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 25);
		curl_setopt($ch, CURLOPT_TIMEOUT, 25);
		$tmpData = curl_exec($ch);
		curl_close($ch);
		$jsTicketData = json_decode($tmpData, true);
		$jsTicket = $jsTicketData['ticket'];

		$jsTicketData['end'] = time() + 7000;
		file_put_contents('./jsticket.cache', json_encode($jsTicketData));
	} else {
		$jsTicket = $tmpJsticketData['ticket'];
	}

	$readyTime = time();
	$curLink = "http://game.jinggege.com{$_SERVER['REQUEST_URI']}";
	$readyStr = "jsapi_ticket={$jsTicket}&noncestr=jinggege&timestamp={$readyTime}&url={$curLink}";
	$signature = sha1($readyStr);
?>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" id="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/> -->
<meta name="viewport" content = "width=420, user-scalable=no" />
<title><?php echo $username; ?>竟敢如此调戏大师</title>
<script type="text/javascript">
    !function(){     
        //rem  计算方式  px/40 
        function setFontSize(){            	
        	document.documentElement.style.fontSize = document.documentElement.clientWidth /16 +"px";
        }
    	var _t = null;
    	window.addEventListener("resize",function(){
      		clearTimeout(_t);
      		_t = setTimeout(setFontSize,100);
    	},false);
    	setFontSize();
        
    }(window);
</script>
<link rel="stylesheet" style="text/css" href="./common.css"/>
</head>
<body>
	<div class="wrap">
		<section class="header">
			<h1 class="header-h1">禅师有话说</h1>
		</section>
		<section class="content">
			<div class="answer">
				<h2 class="tip"><?php echo $username; ?>竟敢如此调戏大师：</h2> 
				<div class="header-img"><img src="./images/<?php echo $key; ?>.jpg"></div>
				<p class="answer-content"><?php echo $content;?></p>
				<div class="button" onclick="location.href='./join.php'">我也要测试</div>
			</div>
		</section>
		<section class="footer">
			<div class="ad">
				<a href="http://c.jinggege.com/micro_coupon/getticketbymobile/type/shihui" target="_blank"><img src="./images/ad.jpg"></a>
			</div>
			<div class="copy-right">
				<p>靖哥哥半成品食材</p>
			</div>
		</section>
	</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
var imgUrl = 'http://game.jinggege.com/zenmaster/images/<?php echo $key;?>-1.jpg'; 
var lineLink = location.href.split('#')[0]; 
var shareTitle = '<?php echo $username; ?>竟敢如此调戏大师，快来围观，也测测你是哪类2B青年！'; 
var appid = 'wx31320a097c239d4d'; 

wx.config({
	debug: false,
	appId: appid,
	timestamp: <?php echo $readyTime;?>, // 必填，生成签名的时间戳
	nonceStr: 'jinggege',
	signature: '<?php echo $signature;?>',
	jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});

wx.ready(function () {

	wx.onMenuShareTimeline({
		title: shareTitle, // 分享标题
		link: lineLink, // 分享链接
		imgUrl: imgUrl, // 分
		success: function () { 
		},
		cancel: function () { 
		}
	});

	wx.onMenuShareAppMessage({
		title: shareTitle, // 分享标题
		desc: '竟然有人如此调戏大师，想想也是醉了，要不你也来调戏一把', // 分享描述
		link: lineLink, // 分享链接
		imgUrl: imgUrl, // 分
		type: '', // 分享类型,music、video或link，不填默认为link
		dataUrl: '',
		success: function () { 
		},
		cancel: function () { 
		}
	});
});
</script>
</html>
