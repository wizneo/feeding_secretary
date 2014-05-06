<?php

$callback = $_REQUEST['callback'];

// Create the output object.
$output = array('persons' => array(array('name' => 'CS Lee', 'age' => '34', 'height' => '177')));

//start output
if ($callback) {
	header('Content-Type: text/javascript; charset=UTF-8');
	echo $callback . '(' . json_encode($output) . ');';
} else {
	header('Content-Type: application/x-json; charset=UTF-8');
	echo json_encode($output);
}
?>

