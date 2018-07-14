<?php
include_once('../class/index.php');
if($SESSION->login){
	/* Load page */
	if($code=='Analysis-top-links'){include_once('analysis-top-links.php');}
	else if($code=='analysis-'){include_once 'analysis-.php';}
	else{include_once 'analysis.php';}

}
?>