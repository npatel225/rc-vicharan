<?php
if($Session->login){
	$by_who = ($Session->user_level==UL_SANCHALAK) ? 2 : 1;
	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge - get
	if($type=='get-challenges'){
		$array  = $Core->gender_mandal($mandal);
		$gender = $array['gender'];
		$mandal = $array['mandal'];
		$output .= ',"challenges":'.Sync::centerAnalysis15Challenges($center, $year, $gender, $mandal);
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge - add
	if($type=='add-challenge'){
		$value    = $Core->replace_quotes(trim($value));
    $db_value = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'challenge', DB_PREFIX.'center_analysis', "year='".date('Y')."' AND center='$center' AND challenge='$value' AND by_who='$by_who'");
		if(!empty($db_value) AND ($db_value==$value)){
			$output.=',
				"status":"error",
				"message":"'.$value.' is already in database.",
				"error":""'
			;
		}else if(!$Database->add_center_analysis(array(__LINE__, __METHOD__, __FILE__), $center, date('Y'), $Session->mandal, $Session->gender, $by_who, $value, $Session->profile_id)){
			$output.=',
				"status":"error",
				"message":"We had some error adding the new option.",
				"error":"'.$Core->error_message('Error adding new option', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$output.=',
				"status":"success",
				"message":"'.$value.' challenge is added to list.",
				"challenges":'.Sync::centerAnalysis15Challenges($center, date('Y'), $Session->gender, $Session->mandal).'
			';
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge - edit
	if($type=='edit-challenge'){
		$value = $Core->replace_quotes(trim($value));
		if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis', array("challenge" => $value, "update_datetime" => $Core->datetime, "update_profile_id" => $Session->profile_id), array("center_analysis_id" => $id))){
			$output.=',
				"status":"error",
				"message":"We had some error updating the '.$value.'('.$id.').",
				"error":"'.$Core->error_message('Error removing option', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			// get the gender and mandal from incoming mandal
			$array  = $Core->gender_mandal($mandal);
			$gender = $array['gender'];
			$mandal = $array['mandal'];
			$output.=',
				"status":"success",
				"message":"'.$name.' is updated.",
				"challenges":'.Sync::centerAnalysis15Challenges($center, $year, $gender, $mandal).'
			';
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge - remove
	if($type=='remove-challenge'){
		// challenge is saved in center_analysis
		// remove the center analysis id foreign key constraint from center_analysis_details then remove the center_analysis_id from center_analysis
		if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis_details', "center_analysis_id='$id'")){
			$output .= ',
				"status":"error",
				"message":"We had some error removing the '.$name.'('.$id.').",
				"error":"'.$Core->error_message('Error removing option', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis', "center_analysis_id='$id'")){
				$output.=',
					"status":"error",
					"message":"We had some error removing the '.$name.'('.$id.').",
					"error":"'.$Core->error_message('Error removing option', __FILE__, __LINE__, $Database->error()).'"'
				;
			}else{
				// get the gender and mandal from incoming mandal
				$array  = $Core->gender_mandal($mandal);
				$gender = $array['gender'];
				$mandal = $array['mandal'];
				$output.=',
					"status":"success",
					"message":"'.$name.' is removed.",
					"challenges":'.Sync::centerAnalysis15Challenges($center, $year, $gender, $mandal).'
				';
			}
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge - edit root_cause and salutation
	if($type=='edit-challenge-info'){
		$data       = (get_magic_quotes_gpc()) ? stripslashes($data) : $data;
		$rows       = json_decode($data, true);
		$row        = '';
		$message    = '';
		$id         = '';
		$challenge  = '';
		$root_cause = '';
		$salutation = '';
		
		for($a=0; $a<count($rows); $a++){
			$row        = $rows[$a];
			$id         = $row['id'];
			$challenge  = $Core->replace_quotes($row['challenge']);
			$root_cause = $Core->replace_quotes($row['root_cause']);
			$salutation = $Core->replace_quotes($row['salutation']);
			$progress   = (!empty($root_cause) OR !empty($salutation)) ? 1 : "";
			if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis', array("root_cause" => $root_cause, "salutation" => $salutation, "update_datetime" => $Core->datetime, "update_profile_id" => $Session->profile_id, "progress" => ((!empty($root_cause) OR !empty($salutation)) ? 1 : "")), array("center_analysis_id" => $id))){
				$message .= $Core->error_message('Error saving '.$challenge, __FILE__, __LINE__, $Database->error());
			}
		}

		if($message){
			$output.=',
				"status":"error",
				"message":"We had some error saving challenge information.",
				"error":"'.$message.'"
			';
		}else{
			// get the gender and mandal from incoming mandal
			$array  = $Core->gender_mandal($mandal);
			$gender = $array['gender'];
			$mandal = $array['mandal'];
			$output.=',
				"status":"success",
				"message":"challenge information are saved.",
				"challenges":'.Sync::centerAnalysis15Challenges($center, $year, $gender, $mandal).'
			';
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge detail - get changllenge details from challenge id
	if($type=='get-challenge-details'){
		$output .= ',"details":'.json_encode(Sync::centerAnalysisDetail($id));
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge detail - get changllenge details from challenge id
	if($type=='edit-challenge-details'){
		$data               = (get_magic_quotes_gpc()) ? stripslashes($data) : $data;
		$rows               = json_decode($data, true);
		$id                 = '';
		$center_analysis_id = '';
		$project_id         = '';
		$people_to_focus    = '';
		$plan_to_help       = '';
		$santo_help         = '';
		$jan                = '';
		$feb                = '';
		$mar                = '';
		$apr                = '';
		$may                = '';
		$jun                = '';
		$jul                = '';
		$aug                = '';
		$sep                = '';
		$oct                = '';
		$nov                = '';
		$dec                = '';
		// get the gender and mandal from incoming mandal
		$array  = $Core->gender_mandal($mandal);
		$gender = $array['gender'];
		$mandal = $array['mandal'];

		for($a=0; $a<count($rows); $a++){
			$row                = $rows[$a];
			$id                 = $row['id'];
			$center_analysis_id = $row['center_analysis_id'];
			$project_id         = $row['project_id'];
			$project_name       = $row['project_name'];
			$people_to_focus    = $Core->replace_quotes($row['people_to_focus']);
			$plan_to_help       = $Core->replace_quotes($row['plan_to_help']);
			$santo_help         = $Core->replace_quotes($row['santo_help']);
			$jan                = (isset($row['jan']) && !empty($row['jan'])) ? $row['jan'] : NULL;
			$feb                = (isset($row['feb']) && !empty($row['feb'])) ? $row['feb'] : NULL;
			$mar                = (isset($row['mar']) && !empty($row['mar'])) ? $row['mar'] : NULL;
			$apr                = (isset($row['apr']) && !empty($row['apr'])) ? $row['apr'] : NULL;
			$may                = (isset($row['may']) && !empty($row['may'])) ? $row['may'] : NULL;
			$jun                = (isset($row['jun']) && !empty($row['jun'])) ? $row['jun'] : NULL;
			$jul                = (isset($row['jul']) && !empty($row['jul'])) ? $row['jul'] : NULL;
			$aug                = (isset($row['aug']) && !empty($row['aug'])) ? $row['aug'] : NULL;
			$sep                = (isset($row['sep']) && !empty($row['sep'])) ? $row['sep'] : NULL;
			$oct                = (isset($row['oct']) && !empty($row['oct'])) ? $row['oct'] : NULL;
			$nov                = (isset($row['nov']) && !empty($row['nov'])) ? $row['nov'] : NULL;
			$dec                = (isset($row['dec']) && !empty($row['dec'])) ? $row['dec'] : NULL;
			$message            = '';
			//print_r($row);
			$db_check = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'center_analysis_detail_id', DB_PREFIX.'center_analysis_details', "center_analysis_detail_id='$id'");
			// detail already in database so update the database
			if($db_check==$id){
				$update = array();
				foreach ($row as $key=>$value){
					if(($key!='project_name') AND ($key!='id')){
						$update["$key"] = $Core->replace_quotes($value);
					}
				}
				
				$update["progress"]          = (!empty($people_to_focus) OR !empty($plan_to_help) OR !empty($santo_help)) ? 1 : NULL;
				$update["update_datetime"]   = $Core->datetime;
				$update["update_profile_id"] = $Session->profile_id;

				if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis_details', $update, array("center_analysis_detail_id" => $id))){
					$message .= $Core->error_message('Error updating '.$project_name, __FILE__, __LINE__, $Database->error());
				}
			}
			// detail is not in database so add new one
			else{
				$progress = (!empty($people_to_focus) OR !empty($plan_to_help) OR !empty($santo_help)) ? '1' : "";
				if(!$Database->add_center_analysis_detail(array(__LINE__, __METHOD__, __FILE__), $center_analysis_id, $project_id, $people_to_focus, $plan_to_help, $santo_help, $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec, $Session->profile_id, $progress)){
						$line_num=__LINE__;
						$message .= $Core->error_message('Error saving '.$project_name, __FILE__, __LINE__, $Database->error());
				}
			}
		}

		if($message){
			$output.=',
				"status":"error",
				"message":"We had some error saving challenge information.",
				"error":"'.$message.'"
			';
		}else{
			$output.=',
				"status":"success",
				"message":"challenge information are saved.",
				"data":'.json_encode(Sync::centerAnalysisDetail($center_analysis_id)).'
			';
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge detail - remove challenge detail
	if($type=='remove-challenge-detail'){
		if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis_details', "center_analysis_detail_id='$id'")){
			$line_num=__LINE__;
			$output.=',
				"status":"error",
				"message":"We had some error removing the detail.",
				"error":"'.$Core->error_message('Error removing detail', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$output.=',
				"status":"success",
				"message":"detail is removed.",
				"data":'.Sync::centerAnalysisDetail($parent).'
			';
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Projects detail - Get projects details
	if($type=='get-projects-details'){
		$output .= ',"details":'.json_encode(Sync::projectsDetails($mandal, $year, $center));
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge detail - get projects details
	if($type=='edit-projects-details'){
		$data              = (get_magic_quotes_gpc()) ? stripslashes($data) : $data;
		$rows              = json_decode($data, true);
		$project_detail_id = '';
		$project_name      = '';
		$gender            = '';
		$mandal            = '';
		$year              = '';
		$center            = '';
		$message           = '';

		// for($a=0; $a<count($rows); $a++){
		// 	$row               = $rows[$a];
		// 	$project_detail_id = $row['id'];
		// 	$year              = $row['year'];
		// 	$mandal            = $row['mandal'];
		// 	$gender            = $row['gender'];
		// 	$center            = $row['center'];
		// 	$project_id        = $row['project_id'];
		// 	$project_name      = $row['project_name'];
		// 	$people_to_focus   = (isset($row["people_to_focus"]) && !empty($row["people_to_focus"])) ? $Core->replace_quotes($row['people_to_focus']) : NULL;
		// 	$plan_to_help      = (isset($row["plan_to_help"]) && !empty($row["plan_to_help"])) ? $Core->replace_quotes($row['plan_to_help']) : NULL;
		// 	$santo_help        = (isset($row["santo_help"]) && !empty($row["santo_help"])) ? $Core->replace_quotes($row['santo_help']) : NULL;
		// 	$jan               = (isset($row['jan']) && !empty($row['jan'])) ? $row['jan'] : NULL;
		// 	$feb               = (isset($row['feb']) && !empty($row['feb'])) ? $row['feb'] : NULL;
		// 	$mar               = (isset($row['mar']) && !empty($row['mar'])) ? $row['mar'] : NULL;
		// 	$apr               = (isset($row['apr']) && !empty($row['apr'])) ? $row['apr'] : NULL;
		// 	$may               = (isset($row['may']) && !empty($row['may'])) ? $row['may'] : NULL;
		// 	$jun               = (isset($row['jun']) && !empty($row['jun'])) ? $row['jun'] : NULL;
		// 	$jul               = (isset($row['jul']) && !empty($row['jul'])) ? $row['jul'] : NULL;
		// 	$aug               = (isset($row['aug']) && !empty($row['aug'])) ? $row['aug'] : NULL;
		// 	$sep               = (isset($row['sep']) && !empty($row['sep'])) ? $row['sep'] : NULL;
		// 	$oct               = (isset($row['oct']) && !empty($row['oct'])) ? $row['oct'] : NULL;
		// 	$nov               = (isset($row['nov']) && !empty($row['nov'])) ? $row['nov'] : NULL;
		// 	$dec               = (isset($row['dec']) && !empty($row['dec'])) ? $row['dec'] : NULL;
		// 	$message           = '';

		// 	$db_check = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'project_detail_id', DB_PREFIX.'project_details', "project_detail_id='$project_detail_id'");
		// 	// detail already in database so update the database
		// 	if(!empty($project_detail_id) && ($db_check==$project_detail_id)){
		// 		$update = array();
		// 		foreach ($row as $key=>$value){
		// 			if(($key!='project_name') AND ($key!='id')){
		// 				$update["$key"] = $Core->replace_quotes($value);
		// 			}
		// 		}
				
		// 		$update["progress"]          = (!empty($people_to_focus) OR !empty($plan_to_help) OR !empty($santo_help)) ? 1 : NULL;
		// 		$update["update_datetime"]   = $Core->datetime;
		// 		$update["update_profile_id"] = $Session->profile_id;

		// 		if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'project_details', $update, array("project_detail_id" => $project_detail_id))){
		// 			$message .= $Core->error_message('Error updating '.$project_name, __FILE__, __LINE__, $Database->error());
		// 		}
		// 	}
		// 	// detail is not in database so add new one
		// 	else{
		// 		$progress = (!empty($people_to_focus) OR !empty($plan_to_help) OR !empty($santo_help)) ? '1' : "";
		// 		if(!$Database->add_project_detail(array(__LINE__, __METHOD__, __FILE__), $center, $project_id, $year, $mandal, $gender, $by_who, $people_to_focus, $plan_to_help, $santo_help, $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec, $Session->profile_id, $progress)){
		// 				$message .= $Core->error_message('Error saving '.$project_name, __FILE__, __LINE__, $Database->error());
		// 		}
		// 	}
		// }

		for($a=0; $a<count($rows); $a++){
			$row               = $rows[$a];
			$project_detail_id = $row['id'];
			$project_name      = $row['project_name'];
			$gender            = $row["gender"];
			$mandal            = $row["mandal"];
			$year              = $row["year"];
			$center            = $row["center"];
			$update            = array();
			foreach ($row as $key=>$value){
				if(($key!='project_name') AND ($key!='id')){
					$update["$key"] = $Core->replace_quotes($value);
				}
			}
			// copy update array to row array
			$row = $update;
			// add progress of detail
			$row["progress"] = (!empty($row["people_to_focus"]) OR !empty($row["plan_to_help"]) OR !empty($row["santo_help"])) ? 1 : NULL;

			$db_check = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'project_detail_id', DB_PREFIX.'project_details', "project_detail_id='$project_detail_id'");
			// detail already in database so update the database
			if(!empty($project_detail_id) && ($db_check==$project_detail_id)){
				$row["update_datetime"]   = $Core->datetime;
				$row["update_profile_id"] = $Session->profile_id;

				if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'project_details', $row, array("project_detail_id" => $project_detail_id))){
					$message .= $Core->error_message('Error updating '.$project_name, __FILE__, __LINE__, $Database->error());
				}
			}
			// detail is not in database so add new one
			else{
				if(!empty($row["progress"]) && !$Database->add_project_detail(array(__LINE__, __METHOD__, __FILE__), $row["center"], $row["project_id"], $row["year"], $row["mandal"], $row["gender"], $by_who, $row["people_to_focus"], $row["plan_to_help"], $row["santo_help"], $row["jan"], $row["feb"], $row["mar"], $row["apr"], $row["may"], $row["jun"], $row["jul"], $row["aug"], $row["sep"], $row["oct"], $row["nov"], $row["dec"], $Session->profile_id, $row["progress"])){
						$message .= $Core->error_message('Error saving '.$project_name, __FILE__, __LINE__, $Database->error());
				}
			}
		}

		if($message){
			$output.=',
				"status":"error",
				"message":"We had some error saving project detail information.",
				"error":"'.$message.'"
			';
		}else{
			$output.=',
				"status":"success",
				"message":"project detail information are saved.",
				"data":'.json_encode(Sync::projectsDetails($Core->mandal_name($gender, $mandal), $year, $center)).'
			';
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	// Challenge detail - get summary
	if($type=='get-summary'){
		$output .= ',"projects":'.json_encode(Sync::projectsDetails($mandal, $year, $center, false));
		$output .= ',"challenges":'.json_encode(Sync::centerAnalysisDetail('', $mandal, $year, $center, true, false));
		$output .= ',"centerAnalysis":'.Sync::centerAnalysis15();
	}

}
?>