<?php
require_once '../class/Config.php';
require_once '../class/Core.class.php';

Email::check_in_reminder();
Email::upcoming_vicharan();
Email::plan_vicharan_reminder();
Email::process();

function copyLogs($src, $dst){
	$dir = opendir($src); 
	(!file_exists($dst)) ? mkdir($dst) : '';
	while(false !== ($file = readdir($dir))){
		if(($file != '.') && ($file != '..')){
			if(is_dir($src.'/'.$file)){
				recurse_copy($src.'/'.$file, $dst.'/'.$file); 
			}else{ 
				copy($src.'/'.$file, $dst.'/'.$file); 
			} 
		} 
	}
	closedir($dir); 
}

$dir = "/home/kishore";
$path = $dir."/public_html/rcvicharan";

$src = $dir."/logs";
$dst = $path."/logs_backup";

echo copyLogs($src, $dst);
?>