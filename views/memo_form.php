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
			);

			$("#title").keydown(function (e) {
				if (e.which == 13) {
					$("#contents").focus();
					e.preventDefault();
				}
			});

			$("#memo_input_data").submit(function(e) {
				if ($("#contents").val() === "") {
					alert("내용이 비어있습니다.");
						e.preventDefault();
				}
			});
		});

		//-->
		</script>
	</head>
	<body>		
		<div data-role="page" id="memo" data-theme="a">
			<div data-role="header" data-theme="a" data-position="fixed">
				<a href="/minyoung" data-icon="home" id= "home" data-transition="fade" data-direction="reverse">홈</a>
				<a href="/memo" data-icon="back" id= "back" data-transition="fade" data-direction="reverse">뒤로</a>
				<h1>민영이의 메모장</h1>
			</div>
			<div data-role="contents" data-theme="a">
				<form name="memo_input_data" id="memo_input_data" data-ajax="false" method="post" action="/memo/save">
				    <label for="name">제목 (비우면 글 앞부분으로 자동 저장)</label>
					<input type="text" name="title" id="title"></input>
					<label for="textarea">내용</label>
					<textarea cols="40" rows="8" name="contents" id="contents"></textarea>
					<input type="submit" id="btn_save" value="저장"></input>
				</form>
			</div>
			<div data-role="footer" data-theme="b" data-position="fixed">
				<h3><small>우리 만난 지 <?=$dday?>일 째</small></h3>
			</div>
		</div>
	</body>
</html>		


