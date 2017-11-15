<?php

include_once('functions.php');
include_once ('classes.php');

//$arr = array('Ленинградское шоссе 12', 'Крепостная 20', 'Prim_27');
//$getPost = sendPost("yandex", $arr, null);

//print_r(getPosition($getPost));


$zabbix = new Zabbix("fedorov25", "10Fil08F1995");
$host = $zabbix->getHosts();

$arrH = array();

for ($i=0; $i < 5; $i++) { 
	$arrH[] = $host[$i];
}

$ya = sendPost("yandex", $arrH, null);

$pos = getPosition($ya);

print_r($ya);