<?php
if($Session->login){
/* ********** ********** ********* ********* ********* ********* ********* */
	/* Update Setup # */
if($type=='update-setup'){
	$value = intval($value);
	if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', array("setup" => $value), array("profile_id" => $Session->profile_id))){
		$output.=',
			"status":"error",
			"message":"We had some error skiping setup.",
			"error":""
		';
	}else{
		$Session->setup = $value;
		$output.=',
			"status":"success",
			"message":"setup is updated.",
			"session":'.Sync::session().'
		';
	}
}

/* ********** ********** ********* ********* ********* ********* ********* */
/* Save - profile */
	if($type=='save-profile'){
		$center = $region_center;
		$username = explode('@', $email);
		$username = $username[0];
		if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles',
			array("first_name" => $first_name, "last_name" => $last_name, "email" => $email, "region" => $region, "center" => $center, "username" => $username, "setup" => 1),
			array("profile_id" => $Session->profile_id)
		)){
			$output.=',
				"status":"error",
				"message":"We had some error updating your profile.",
				"error":"'.$Core->error_message('Error updating your profile', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$Session->setup = 1;
			$output.=',
				"status":"success",
				"message":"You profile is updated.",
				"session":'.Sync::session().'
			';
		}
	}

/* ********** ********** ********* ********* ********* ********* ********* */
/* Save password */
	if($type=='save-password'){
		$setup = ($Session->user_level==UL_SANCHALAK || $Session->user_level==UL_RA) ? 4 : 2;
		if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', array("password" => $password, "setup" => $setup), array("profile_id" => $Session->profile_id))){
			$output.=',
				"status":"error",
				"message":"We had some error updating your password.",
				"error":"'.$Core->error_message('Error updating your password', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$Session->setup = $setup;
			$output.=',
				"status":"success",
				"message":"You password is updated.",
				"session":'.Sync::session().'
			';
		}
	}

/* ********** ********** ********* ********* ********* ********* ********* */
/* Save - Center */
	if($type=='save-center'){
		$center = $region_center;
		if($Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'id',DB_PREFIX.'assign_centers', "center='$center' AND profile_id='$Session->profile_id'")){
			$output.=',
				"status":"error",
				"message":"'.$center.' is already assigned to you.",
				"error":""
			';
		}else if(!$Database->add_assign_center(array(__LINE__, __METHOD__, __FILE__), $Session->profile_id, $center, $Session->profile_id)){
				$output.=',
					"status":"error",
					"message":"We had some error saving the center.",
					"error":"'.$Core->error_message('Error saving center', __FILE__, __LINE__, $Database->error()).'"
				';
			}else{
				$output.=',
					"status":"success",
					"message":"'.$center.' is assigned to you now.",
					"session":'.Sync::session().'
				';
			}
	}

/* ********** ********** ********* ********* ********* ********* ********* */
/* Remove - Center */
	if($type=='remove-center'){
		if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'assign_centers', "center='$center' AND profile_id='$Session->profile_id'")){
			$output.=',
				"status":"error",
				"message":"We had some error removing the center.",
				"error":"'.$Core->error_message('Error removing center', __FILE__, __LINE__, $Database->error()).'"
			';
		}else{
			$output.=',
				"status":"success",
				"message":"'.$center.' is removed from your list.",
				"session":'.Sync::session().'
			';
		}
	}
	
/* ********** ********** ********* ********* ********* ********* ********* */
}
?>