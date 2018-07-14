<?php
require_once '../class/Core.class.php';
$start_time = $Core->microtime_float();
// Pause the output - wait for the file to render fully
ob_start();
// set return file header
header('Content-Type: application/json; charset=utf-8');

$output = '';

// Logout Code
if($code=='logout'){
	$Session->logout(2);
	$output='
		"login":false,
		"session":{"t":null,"u":null}
	';
}

// Click Code
else if($code=='click'){
	$output = '"click":"'.((!$Database->add_session_click(array(__LINE__, __METHOD__, __FILE__), $Session->session_id, Url::param('hash'))) ? 'not saved<br>'.mysql_error() : 'saved').'"';
}

// Reset-Password Code
else if($code=='reset-password'){
	$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'reset_password', "datetime<='$Core->datetime'");
	$data = $Database->get_data(array(__LINE__, __METHOD__, __FILE__), '*', DB_PREFIX.'reset_password', "reset_id='$id'");
	if(!empty($id) && $data[0]['reset_id']==$id){
		$output='
			"login":false,
			"setup":true,
			"uid":"'.$data[0]["profile_id"].'"
		';
	}else{
		$output='
			"login":false,
			"setup":false
		';
	}
}

// Login Code
else if($code=='login'){require_once 'login.php';}

// Loaded page
else if($Session->login){
	if(file_exists($code.'.php')){require_once $code.'.php';}
	if($output){
		$output='
			"login":true,
			"sid":"'.$Session->session_id.'",
			"uid":"'.$Session->profile_id.'"
			'.$output
		;
	}
}else{
	$output = '
		"login":false,
		"session":{"sid":null,"uid":null}
	';
}

$output=$Core->remove_line_break($output);

ob_end_flush();
$end_time   = $Core->microtime_float();
$total_time = ($end_time-$start_time);
$output    .= empty($output) ? '' : ',';
$output    .= '"total_time":"'.$total_time.' sec"';
$output    .= ',"datetime_post":"'.$datetime_post.'"';
$output    .= ',"datetime":["'.date('Y-m-d h:i:s').'","'.$Core->format_datetime(date('Y-m-d h:i:s')).'"]';
echo '{'.$output.'}';
?>