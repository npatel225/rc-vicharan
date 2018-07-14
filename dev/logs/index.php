<?php
require_once '../class/Core.class.php';
$_GET['file'] = empty($_GET['file']) ? '' : $_GET['file'];
if($Session->login && $Session->user_level==UL_SITE_ADMIN){
$log = new logs;
?>

<html>
<head>
	<title>Read Log</title>
	<style>
		table{
			width: 100%;
		}
		table,th,td{
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<div>
		Date: <?php echo $log->file_list('file',$_GET['file']); ?> 
		Order: <select id="order" onchange='load_log();'>
			<option value="">Select Order</option>
			<option value="1">Ascend</option>
			<option value="2">Descend</option>
		</select>
		Type: <select id="type" onchange='load_log();'>
			<option value="">Select Type</option>
			<option value="error">Error</option>
			<option value="log">log</option>
			<option value="success">Success</option>
		</select>
	</div>
	<div><?php echo (isset($_GET["file"]) && ($_GET["file"]!="")) ? $log->read($_GET["file"], $_GET["order"], $_GET["type"]) : ""; ?></div>

	<script type="text/javascript">
		function load_log(){
			var file  = document.getElementById("file");
			var order = document.getElementById("order");
			var type  = document.getElementById("type");
			    file  = file.options[file.selectedIndex].value;
			    order = order.options[order.selectedIndex].value;
			    type  = type.options[type.selectedIndex].value;
			    
			(file!="") ? window.location.href='index.php?file='+file+'&order='+order+'&type='+type : "";
		}
	</script>
</body>
</html>
<?php
}else{
	echo 'Login';
}
?>