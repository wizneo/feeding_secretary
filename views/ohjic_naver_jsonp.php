<?php

$callback = $_REQUEST['callback'];

// Create the output object.

function createElement($title, $jok) {
	return array('title' => $title, 'jok' => $jok);	
}

$output = array(
	'articles' => array(
		createElement('오직. 업계 최초로 삼성전자 순이익 앞질러.', '머지 않아 그리 될 것임 :D'),
		createElement('대학생이 가장 가고 싶은 회사 1위, 오직', '올 생각만해도 좋네'),
		createElement('IT업계 인력 수급 불균형. 오직에 우수인재 몰려', '아하하하'),
		createElement('평균연봉 2억을 웃도는 신이 울고갈 직장 어디?', '오직이 될 것임'),
		createElement('NHN, 오직에 지분률 51%  매각', '헐'),
		createElement('IT업계 공룡 오직. 사회환원도 공룡', '암..끄덕끄덕')
	)
);

//start output
if ($callback) {
	header('Content-Type: text/javascript; charset=UTF-8');
	echo $callback . '(' . json_encode($output) . ');';
} else {
	header('Content-Type: application/x-json; charset=UTF-8');
	echo json_encode($output);
}
?>

