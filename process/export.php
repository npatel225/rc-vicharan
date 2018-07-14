<?php
require_once '../class/Core.class.php';

if($Session->login){
	if(file_exists('export-'.$type.'.php')){require_once 'export-'.$type.'.php';}
}
?>