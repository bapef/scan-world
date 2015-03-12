<?php

include("SxGeo.php");

if(!isset($argv[1]) || !file_exists($argv[1])) {
   var_dump("Not found file");die;
}
$file = $argv[1];

$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH | SXGEO_MEMORY);

#var_dump($file);die;

$port = preg_replace('/.+ports_([0-9]+)\..+/', '$1', $file);
$port = (integer) $port;
if($port == 0){
    var_dump("Not found port in file name");die;
}

$folder = dirname($file) . '/' . $port;
if(!file_exists($folder)){
    mkdir(dirname($file) . '/' . $port);
}

$ips = file($file);

$pool = array();

foreach($ips as $ip)
{
	$ip = trim($ip);
	$country = $SxGeo->getCountry($ip);
	if(!empty($country)) {
		
		if(!isset($pool[$country])){
                    $pool[$country] = fopen($folder . '/' . $country . ".lst", "w+");
                }
		
		fwrite($pool[$country], "{$ip}\n");
	}
}

foreach($pool as $fp){
    fclose($fp);
}

echo "Geocoding stop";
