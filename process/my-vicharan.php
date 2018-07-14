<?php
if($Session->login){
	
	/* ********** ********** **********	**********	**********	********** */
	// Save
	if($type=='save'){

		if($center=='other-center'){$center=$region_center;}
		else if($center=='other'){$center=$other;}
		
		if(!$Database->add_vicharan(array(__LINE__, __METHOD__, __FILE__), $Session->profile_id, $center, $sabha, $date, $Session->profile_id)){
			$output.=',
				"status":"error",
				"message":"We had some error saving your vicharan.",
				"error":"'.$Core->error_message('Error saving your vicharan', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$output.=',
				"status":"success",
				"message":"You vicharan is saved.",
				"myVicharanEvents":'.Sync::myVicharanEvents().',
				"myCheckIn":'.Sync::myCheckIn().'
			';
		}
	}
	/* ********** ********** **********	**********	**********	********** */
	// Remove
	else if($type=='remove'){
		if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'vicharans', "vicharan_id='$id'")){
			$output.=',
				"status":"error",
				"message":"We had some error removing your vicharan.",
				"error":"'.$Core->error_message('Error removing your vicharan', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			$output.=',
				"status":"success",
				"message":"You vicharan is removed.",
				"myVicharanEvents":'.Sync::myVicharanEvents().',
				"myCheckIn":'.Sync::myCheckIn().'
			';
		}
	}
}
?>