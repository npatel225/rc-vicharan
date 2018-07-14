<?php 
if($Session->login){
/* ********** ********** ********* ********* ********* ********* ********* */
/* Save password */
	if($type=='save-password'){
		if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', array("password" => $password), array("profile_id" => $Session->profile_id))){
			$output.=',
				"status":"error",
				"message":"We had some error updating your password.",
				"error":"'.$Core->error_message('Error updating your password', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$output.=',
				"status":"success",
				"message":"You password is updated."
			';
		}
	}
	
/* ********** ********** ********* ********* ********* ********* ********* */
/* Save - profile */
	if($type=='save-profile'){
		$username = explode('@', $email);
		$username = $username[0];
		if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles',
			array("first_name" => $first_name, "last_name" => $last_name, "email" => $email, "username" => $username, "region" => $region, "center" => $region_center),
			array("profile_id" => $Session->profile_id)
		)){
			$output.=',
				"status":"error",
				"message":"We had some error updating your profile.",
				"error":"'.$Core->error_message('Error updating your profile', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$output.=',
				"status":"success",
				"message":"You profile is updated.",
				"data":'.Sync::session().'
			';
		}
	}
	
/* ********** ********** ********* ********* ********* ********* ********* */
/* Save - profile */
	if($type=='remove-check-in'){
		if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'check_in', "check_in_id='$id'")){
			$output.=',
				"status":"error",
				"message":"We had some error removing your check-in.",
				"error":"'.$Core->error_message('Error removing your check-in', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$output.=',
				"status":"success",
				"message":"You check-in is removed.",
				"data":'.Sync::myCheckIn().'
			';
		}
	}
}
?>