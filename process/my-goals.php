<?php 
if($Session->login){
/* ********** ********** ********* ********* ********* ********* ********* */
	/* Save */
	if($type=='save'){
		$db_goal=$Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'goal',DB_PREFIX.'goals', "profile_id='$Session->profile_id' AND center='$center' AND year='$year'");

		// goal is already set for this center so update it
		if(!empty($db_goal)){
			if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'goals', array("goal" => $goal), array("profile_id" => $Session->profile_id, " AND ", "center" => $center, " AND ", "year" => $year))){
				$output.=',
					"status":"error",
					"message":"We had some error updating your goal.",
					"error":"'.$Core->error_message('Error updating your goal', __FILE__, __LINE__, $Database->error()).'"'
				;
			}else{
				$output.=',
					"status":"success",
					"message":"You goal is updated.",
					"data":'.Sync::myGoals().'
				';
			}
		}
		/* Add goal in database */
		else{
			// set the default value for profile_id if there is none
			$profile_id = (empty($profile_id)) ? $Session->profile_id : $profile_id;
			// error adding to database
			if(!$Database->add_goal(array(__LINE__, __METHOD__, __FILE__), $profile_id, $center, $goal, $year, $Session->profile_id)){
				$output.=',
					"status":"error",
					"message":"We had some error saving your goal.",
					"error":"'.$Core->error_message('Error saving your goal', __FILE__, __LINE__, $Database->error()).'"'
				;
			}
			// output the success message
			else{
				$output.=',
					"status":"success",
					"message":"You goal is saved.",
					"data":'.Sync::myGoals().'
				';
			}
		}
	}
/* ********** ********** ********* ********* ********* ********* ********* */
	/* Save: Edit */
	if($type=='save-edit'){
		if(($goal==0) OR ($goal=='0')){
			if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'goals', "goal_id='$id'")){
				$output.=',
					"status":"error",
					"message":"We had some error removing your goal.",
					"error":"'.$Core->error_message('Error updating your goal', __FILE__, __LINE__, $Database->error()).'"'
				;
			}else{
				$output.=',
					"status":"success",
					"message":"You goal is removed.",
					"data":'.Sync::myGoals().'
				';
			}
		}else{
			if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'goals', array("goal" => $goal), array("goal_id" => $id))){
				$output.=',
					"status":"error",
					"message":"We had some error updating your goal.",
					"error":"'.$Core->error_message('Error updating your goal', __FILE__, __LINE__, $Database->error()).'"'
				;
			}else{
				$output.=',
					"status":"success",
					"message":"You goal is updated.",
					"data":'.Sync::myGoals().'
				';
			}
		}
	}
}
?>