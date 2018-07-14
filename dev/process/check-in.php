<?php 
if($Session->login){
	/* ********** ********** ********* ********* ********* ********* ********* */
	/* Save */
	if($type=='save'){
		$datetime = $date.' '.date('H:i:s');
		if($center=='other-center'){$center=$region_center;}
		else if($center=='other'){$center=$other;}

		if(!$Database->add_check_in(array(__LINE__, __METHOD__, __FILE__), $Session->profile_id, $center, $sabha, $datetime, $Session->profile_id)){
			$output.=',
				"status":"error",
				"message":"We had some error saving your check-in.",
				"error":"'.$Core->error_message('Error Saving your check in', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$last_check_in_id = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'check_in_id', DB_PREFIX.'check_in', "profile_id='$Session->profile_id' AND center='$center' AND sabha_type='$sabha' AND post_datetime='$datetime'");
			if($vicharan_id!='null'){
				$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'vicharans', array("check_in_id" => $last_check_in_id, "update_datetime" => $Core->datetime), array("vicharan_id" => $vicharan_id));
			}
			$output.=',
				"status":"success",
				"message":"You check-in is saved.",
				"check_in_id":"'.$last_check_in_id.'",
				"myVicharanEvents":'.Sync::myVicharanEvents().',
				"myCheckIn":'.Sync::myCheckIn().'
			';
		}
	}
	/* ********** ********** ********* ********* ********* ********* ********* */
	/* Remove */
	if($type=='remove'){
		// break the check-in link with vicharan
		$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'vicharans', array("check_in_id" => NULL), array("check_in_id" => $id));
		// get vicharan note id
		$vicharan_note_id = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'vicharan_note_id',DB_PREFIX.'check_in', "check_in_id='$id'");
		// remove the vicharan note
		if(!empty($vicharan_note_id)){
			$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'vicharan_notes', "vicharan_note_id='$vicharan_note_id'");
		}
		// remove the check-in
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
				"myVicharanEvents":'.Sync::myVicharanEvents().',
				"myCheckIn":'.Sync::myCheckIn().'
			';
		}
	}
}
?>