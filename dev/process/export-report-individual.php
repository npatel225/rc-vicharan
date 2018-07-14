<?php
require_once '../class/Config.php';
require_once '../class/Core.class.php';
if($Session->login){
	$filename = 'RcVicharan-Report_Individual_Summary-'.date("Y-m-d");
	if($Session->user_level<=UL_RCL){
		$where = $Session->filter_query("g.year='".date('Y')."'", '', '');
		$where = !empty($where) ? 'WHERE '.$where : '';

		$q="SELECT pf.gender, pf.mandal, pf.region AS user_region, pf.first_name, pf.last_name, (SELECT region FROM ".DB_PREFIX."centers WHERE center=g.center) AS region, g.center, g.year, g.goal, (SELECT count(*) FROM ".DB_PREFIX."check_in WHERE profile_id=pf.profile_id AND center=g.center AND post_datetime BETWEEN concat(g.year, '-01-01 00:00:00') AND concat(g.year, '-12-31 23:59:59')) AS visit 
		FROM ".DB_PREFIX."profiles AS pf LEFT JOIN ".DB_PREFIX."goals AS g ON pf.profile_id=g.profile_id 
		$where 
		ORDER BY pf.gender DESC, pf.mandal, user_region, pf.first_name, pf.last_name, g.year DESC, region, g.center 
		LIMIT 10000";
		$result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

		if(count($result)>0){
			$excel = array(
				array("Wing", "Region(User)", "First name", "Last name", "Region(Center)", "Center", "Year", "Goal", "Visited", "Remaining")
			);
			for($a=0; $a<count($result); $a++){
				$row = $result[$a];
				$remain = (($row['goal']>0) AND ($row['goal']-$row['visit'])>0) ? $row['goal']-$row['visit'] : 0;
				$excel[$a+1] = array(
					$Core->mandal_name($row["gender"], $row["mandal"]),
					$row["user_region"],
					$row["first_name"],
					$row["last_name"],
					$row["region"],
					$row["center"],
					$row["year"],
					$row["goal"],
					$row["visit"],
					$remain
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