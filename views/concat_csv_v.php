<?php

$file_arr = array("20120101.IN.csv", "20120108.IN.csv");

$total_file_str = "";

$outputFile = fopen(dirname(rtrim(getenv("DOCUMENT_ROOT"), '/')) . '/application/views/csv/' . "total.csv", "w+");
foreach ($file_arr as $file_one)
{
	$tpl_file_name = dirname(rtrim(getenv("DOCUMENT_ROOT"), '/')) . '/application/views/csv/' . $file_one;
	// $fp = fopen($tpl_file_name, "r");
	// $tpl_str = fread($fp, filesize($tpl_file_name));

	$fp = fopen($tpl_file_name, "r") or die("error");
	$lineNum = 1;
	$tpl_str = "";
	while (!feof($fp))
	{
		if ($lineNum != 1)
		{
			$tpl_str .= fgets($fp);
			$encoded_str = "";
			if (mb_detect_encoding($tpl_str, "UTF-8") == false)
			{
				$encoded_str = mb_convert_encoding($tpl_str, "UTF-8", "EUC-KR");
			}
			else
			{
				$encoded_str = $tpl_str;
			}

			
			fwrite($outputFile, $encoded_str);
		}
	}
	$lineNum = 1;
	fclose($fp);

	

}

fclose($outputFile);
?>