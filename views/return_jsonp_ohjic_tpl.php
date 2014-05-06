<?php

$callback = $_REQUEST['callback'];

// Create the output object.

// $tpl_file_name = dirname(rtrim(getenv("DOCUMENT_ROOT"), '/')).'/application/views/simple_tpl.php';
$tpl_file_name = dirname(rtrim(getenv("DOCUMENT_ROOT"), '/')).'/application/views/ohjic_tpl.php';
$fp = fopen($tpl_file_name, "r");
$tpl_str = fread($fp, filesize($tpl_file_name));
fclose($fp);

function createElement($title, $jok) {
	return array('title' => $title, 'jok' => $jok);	
}

$output = array(
	"test_tpl" => $tpl_str
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

