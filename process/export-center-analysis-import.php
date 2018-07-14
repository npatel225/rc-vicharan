<?php
require_once '../class/Config.php';
require_once '../class/Core.class.php';
if($Session->login){
		$filename = 'RcVicharan-Center_Analysis_Import-'.date("Y-m-d");
	if($Session->user_level<=UL_RA){
	
		$where = $Session->filter_gender_mandal("year='".date('Y')."'", '', '');
		$where = !empty($where) ? 'WHERE '.$where : '';
		
		// get data from database
		$q="SELECT project_detail_id, gender, mandal, region, center, year, project_list_id, project_name, actual FROM (
			SELECT pd.project_detail_id, pd.gender, pd.mandal, (SELECT region FROM ".DB_PREFIX."centers WHERE center=pd.center) AS region, pd.center, pd.year, p.project_list_id, (SELECT name FROM ".DB_PREFIX."lists WHERE list_id=p.project_list_id) AS project_name, pd.actual 
		FROM ".DB_PREFIX."project_details AS pd LEFT JOIN ".DB_PREFIX."projects AS p ON p.project_id=pd.project_id) AS z 
		$where 
		ORDER BY year, gender DESC, mandal, region, center, project_name";
		$result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

		if(count($result)>0){
			$excel = array(
				array("ID", "Wing", "Region", "Center", "Year", "Project name", "Actual")
			);
			count($result);
			for($a=0; $a<count($result); $a++){
				$row = $result[$a];
				$excel[$a+1] = array(
					$row["project_detail_id"],
					$Core->mandal_name($row["gender"], $row["mandal"]),
					$row["region"],
					$row["center"],
					$row["year"],
					$row["project_name"],
					$row["actual"]
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