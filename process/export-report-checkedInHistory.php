<?php
require_once '../class/Config.php';
require_once '../class/Core.class.php';
if($Session->login){
	$filename = "RcVicharan-Report_Checkedin_History-".date('Y-m-d');
	if($Session->user_level<=UL_RA){	
		$where = $Session->filter_query("ci.post_datetime BETWEEN '".($Database->yearChange(date('n')<3) ? 1 : 0)."-01-01 00:00:00' AND '".$Core->datetime."'", '', 'pf', '', 'ci', 'ci');
		$where = !empty($where) ? 'WHERE '.$where : '';
		
		$q="SELECT pf.gender, pf.mandal, pf.region as user_region, pf.first_name, pf.last_name, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ci.center) AS region, ci.center, ci.sabha_type, ci.post_datetime 
    FROM ".DB_PREFIX."check_in AS ci LEFT JOIN ".DB_PREFIX."profiles AS pf ON pf.profile_id=ci.profile_id 
    $where 
    ORDER BY pf.gender DESC, pf.mandal, user_region, pf.first_name, pf.last_name, region, ci.center, ci.post_datetime DESC";
		$result=$Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

		if(count($result)>0){
			$content='';
			$excel = array(
				array("Wing", "Region(Center)", "Center", "Sabha type", "Region(User)", "First name", "Last name", "Date Time")
			);
			for($a=0; $a<count($result); $a++){
				$row = $result[$a];
				$excel[$a+1] = array(
					$Core->mandal_name($row["gender"],$row["mandal"]),
					$row["user_region"],
					$row['first_name'],
					$row['last_name'],
					$row["region"],
					$row["center"],
					$row["sabha_type"],
					$Core->format_datetime($row["post_datetime"])
				);
			}
			// generate file (constructor parameters are optional)
			$xls = new ExcelWriter('UTF-8', false, 'Export');
			$xls->addArray($excel);
			$xls->generateXML($filename);
			exit;
		}else{echo 'There is no content';}
	}else{echo 'You do not have access to this page';}
}else{echo "You are not logged-in.";}
?>