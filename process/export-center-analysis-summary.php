<?php
require_once '../class/Config.php';
require_once '../class/Core.class.php';
if($Session->login){
		$filename = 'RcVicharan-Center_Analysis_Summary-'.date("Y-m-d");
	if($Session->user_level<=UL_SANCHALAK){

		// month loop
		function months($selected){
			$months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			$output = '';
			for ($a=0; $a<count($selected); $a++) { 
				if($selected[$a]=='Y'){
					$output .= ($a>0 && !empty($output)) ? ', ' : '';
					$output .= $months[$a];
				}
			}
			return $output;
		}

		// export projects and challenges
		$result = Sync::projectsDetails($mandal, $year, $center, false);
		// make file only if the result have data
		if(count($result)>0){
			$excel = array(
				array("10 in ".$year." Action Items"),
				array("Projects", "What's being measured", "Goal", "Actual", "Addressing which mandal challenges", "What people do we need to focus on?", "What's my plan to help this move forward?(What am I going to do? What's my mentoring plan for the people I listed? How often will I be working on this?)", "P. Santo/Senior Karyakars - How do we need their help?", "Month(s) in which you will work on this.")
			);
			// build array for export
			for($a=0; $a<count($result); $a++){
				$row  = $result[$a];
				$excel[count($excel)] = array(
					$row["project_name"],
					$row["measure"],
					$row["goal"],
					$row["actual"],
					$row["addressing_challenge"],
					$row["people_to_focus"],
					$row["plan_to_help"],
					$row["santo_help"],
					months($row["months"])
				);
			}

			// export challenges
			$challenges = Sync::centerAnalysisDetail('', $mandal, $year, $center, true, false);
			// make file only if the result have data
			if(count($challenges)>0){
				$excel[count($excel)] = array('');
				$excel[count($excel)] = array("Mentoring Outside of Projects");
				$excel[count($excel)] = array("Challenges", "What people do we need to focus on?", "What's my plan to help this move forward?(What am I going to do? What's my mentoring plan for the people I listed? How often will I be working on this?)", "P. Santo/Senior Karyakars - How do we need their help?", "Month(s) in which you will work on this.");

				// build array for export
				for($a=0; $a<count($challenges); $a++){
					$row = $challenges[$a];
					$excel[count($excel)] = array(
						$row["challenge_name"],
						$row["people_to_focus"],
						$row["plan_to_help"],
						$row["santo_help"],
						months($row["months"])
					);
				}
			}
			// echo json_encode($excel);
			// generate file (constructor parameters are optional)
			$xls = new ExcelWriter('UTF-8', false, 'Export');
			$xls->addArray($excel);
			$xls->generateXML($filename);
			exit;
		}

	}else{echo 'You do not have access to this page';}
}else{echo "You are not logged-in.";}
?>