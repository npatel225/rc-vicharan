<?php
require_once '../class/Config.php';
require_once '../class/Core.class.php';
if($Session->login){
		$filename = 'RcVicharan-Center_Analysis_Summary-'.date("Y-m-d");
	if($Session->user_level<=UL_SANCHALAK){

		// addressing_challenge loop
		function addressing_challenge($challenges){
			$output = '';
			for($a=0; $a<count($challenges); $a++){
				$output .= $challenges[$a]["challenge_name"];
			}
			return empty($output) ? 'N/A' : $output;
		}
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
		$result = Sync::projectsDetails($mandal, $year, $center, true);
		// make file only if the result have data
		if(count($result)>0){
			$excel = array(
				array("10 in 2015 Action Items"),
				array("Wing", "Year", "Region", "Center", "By who", "Projects", "What's being measured", "Goal", "Actual", "Addressing which mandal challenges", "What people do we need to focus on?", "What's my plan to help this move forward?(What am I going to do? What's my mentoring plan for the people I listed? How often will I be working on this?)", "P. Santo/Senior Karyakars - How do we need their help?", "Month(s) in which you will work on this.")
			);
			// build array for export
			for($a=0; $a<count($result); $a++){
				$row  = $result[$a];
				$goal = '';
				     if(($row['bm']=='A' && $row["mandal"]=='B') || ($row['km']=='A' && $row["mandal"]=='K')){ $goal = $row["goal_a"];}
				else if(($row['bm']=='B' && $row["mandal"]=='B') || ($row['km']=='B' && $row["mandal"]=='K')){ $goal = $row["goal_b"];}
				else                                                                                         { $goal = $row["goal_c"];}
				$excel[count($excel)] = array(
					$Core->mandal_name($row["gender"], $row["mandal"]),
					$row["year"],
					$row["region"],
					$row["center"],
					$Core->by_who_name($row["by_who"], $row["gender"]),
					$row["project_name"],
					$row["measure"],
					$goal,
					$row["actual"],
					addressing_challenge($row["addressing_challenge"]),
					$row["people_to_focus"],
					$row["plan_to_help"],
					$row["santo_help"],
					months($row["months"])
				);
			}

			// export challenges
			$challenges = Sync::centerAnalysisDetail('', $mandal, $year, $center, true, true);
			// make file only if the result have data
			if(count($challenges)>0){
				$excel[count($excel)] = array('');
				$excel[count($excel)] = array("Mentoring Outside of Projects");
				$excel[count($excel)] = array("Wing", "Year", "Region", "Center", "By who", "Challenges", "What people do we need to focus on?", "What's my plan to help this move forward?(What am I going to do? What's my mentoring plan for the people I listed? How often will I be working on this?)", "P. Santo/Senior Karyakars - How do we need their help?", "Month(s) in which you will work on this.");

				// build array for export
				for($a=0; $a<count($challenges); $a++){
					$row = $challenges[$a];
					$excel[count($excel)] = array(
						$Core->mandal_name($row["gender"], $row["mandal"]),
						$row["year"],
						$row["region"],
						$row["center"],
						$Core->by_who_name($row["by_who"], $row["gender"]),
						$row["challenge_name"],
						$row["people_to_focus"],
						$row["plan_to_help"],
						$row["santo_help"],
						months($row["months"])
					);
				}
			}
			// echo json_encode($excel);
			
			//generate file (constructor parameters are optional)
			$xls = new ExcelWriter('UTF-8', false, 'Export');
			$xls->addArray($excel);
			$xls->generateXML($filename);
			exit;
		}

	}else{echo 'You do not have access to this page';}
}else{echo "You are not logged-in.";}
?>