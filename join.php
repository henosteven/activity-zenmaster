<?php
	$key = rand(1, 30);
?>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" id="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/> -->
<meta name="viewport" content = "width=420, user-scalable=no" />
<title>靖哥哥半成品菜出品 - 调戏大师</title>
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
		<!--<section class="header">
			<h1 class="header-h1">我要问问禅师</h1>
		</section>
		-->
		<section class="content">
			<div class="header-img join-header-img"><img src="./images/banner.jpg"></div>
			<div class="answer">
				<h2 class="answer-title">问问禅师人生真理</h2>
				<form id="userform" action="./show.php" action="post">
					<input type="hidden" name="key" value="<?php echo $key;?>">
					<input class="username" id="username" name="username" value="" placeholder="填入您的尊姓大名">
				</form>
				<div class="button" onclick="if(!document.getElementById('username').value) {alert('填入您的大名'); return false;} document.getElementById('userform').submit(); ">填好了，现在就问</div>
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
</html>

