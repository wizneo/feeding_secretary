<?php
$tm1 = strtotime('2012-03-21');
$tm2 = strtotime(date('Y-m-d'));
$dday = ceil(($tm2-$tm1)/(60*60*24) + 1);
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="UTF-8">
		<!-- 앱처럼 보이게 하는 설정 -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />

		<link rel="apple-touch-icon-precomposed" href="http://namune.net/minyoung/img/minyoung_favicon.png"/>
		<link rel="apple-touch-startup-image" href="http://namune.net/minyoung/img/minyoung_favicon.png"/>
		<link rel="apple-touch-icon" href="http://m.mydomain.com/touch-icon-iphone.png" />
		
		<!-- JQuery Mobile 선언 부. 반드시 순서 지킬 것-->
		<link rel="stylesheet" href="http://namune.net/lib/jquery/mobile/jquery.mobile-1.4.0.min.css" />
		<link rel="stylesheet" href="http://namune.net/lib/ios_inspired/styles.css" />
		<!--<link rel="stylesheet" href="http://namune.net/lib/theme-minyoung/minyoung.min.css" />-->
		<script src="http://namune.net/lib/jquery/jquery-2.1.0.min.js" ></script>
		<script src="http://namune.net/lib/jquery/mobile/jquery.mobile-1.4.0.min.js" ></script>
		<script type="text/javascript" language = "javascript">
		<!--
		$(document).ready(function(){ 
			setTimeout(function loaded(){ 
					window.scrollTo(0, 1); 
				}, 100
			)
		});
		//-->
		</script>
	</head>
	<body>
		<div data-role="page" id="index" data-theme="a">
			<div data-role="header" data-theme="a" data-position="fixed">
				<h1>민영이 미니홈</h1>
			</div>
			<div data-role="contents" data-theme="a">
				<ul data-role="listview" data-inset="true">
					<li data-role="list-divider">민영이 공간</li>
					<li><a href="http://cafe.naver.com/remonterrace" target="new" data-ajax="false">레몬테라스</a></li>
					<li><a href="/memo" data-transition="fade">메모장</a></li>

					<li data-role="list-divider">우리 공간</li>
					<li><a href="http://namune.net/datewiki/" target="new" data-ajax="false">우리의 Date 정보</a></li>

					<li data-role="list-divider">뿅뿅 공간</li>
					<li><a href="http://namune.net/wiki/" target="new">잡동사니들...</a></li>
				</ul>
			</div>
			<div data-role="footer" data-theme="b" data-position="fixed">
					<h3><small>우리 만난 지 <?=$dday?>일 째</small></h3>
			</div>
		</div>
	</body>
</html>





