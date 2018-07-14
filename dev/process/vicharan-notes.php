<?php
if($Session->login){
	
	$positive_points=$Core->html_ecode($positive_points);
	$issues=$Core->html_ecode($issues);
	$follow_up_list=$Core->html_ecode($follow_up_list);
	$other_comment=$Core->html_ecode($other_comment);

	/* ********** ********** **********	**********	**********	********** */
	/* Email function */
	function vicharan_note_email($vicharan_note_id, $center, $datetime, $positive_points, $issues, $follow_up_list, $other_comment){
		global $Session, $Database, $Core, $Logs;
		// local var 
		$gender = '';
		$result = '';
		$subject = '';
		$message = '';
		$mail_id = '';
		$row = '';
		$datetime = empty($datetime) ? $Core->datetime : $datetime;

		// result from database
		$q = "SELECT p.email, p.profile_id 
		FROM ".DB_PREFIX."assign_centers AS ac LEFT JOIN ".DB_PREFIX."profiles AS p ON ac.profile_id=p.profile_id 
		WHERE user_level='".UL_RC_SANT."' AND ac.center='$center' AND p.gender='$Session->gender'";
		$result=$Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

		if(count($result)>0){
			for($a=0; $a<count($result); $a++){
				$row = $result[$a];

				if($Session->gender=='M'){$gender='his';}
				else if($Session->gender=='F'){$gender='her';}
				else{$gender='his/her';}

				$subject = $center.' RC Vicharan Note';
				$message = '<div>Jay Swaminarayan,<br><br>
				'.$Session->first_name.' recently visited '.$center.' on '.$Core->format_datetime($datetime,"M, d Y").'.  Here are '.$gender.' notes from that visit.<br>
				<ul>
					<li><strong>Positive Points:</strong> '.$positive_points.'</li>
					<li><strong>Issues:</strong> '.$issues.'</li>
					<li><strong>Follow Up List:</strong> '.$follow_up_list.'</li>
					<li><strong>Other Comment:</strong> '.$other_comment.'</li>
				</ul>
				</div>';

				$message = $Core->remove_line_break($message);
				$mail_id = substr(md5('vicharan-notes-'.$vicharan_note_id),0,10);
				$Database->add_email(array(__LINE__, __METHOD__, __FILE__), $mail_id, $Session->profile_id, $row["profile_id"], $row['email'], $subject, $message, $Core->datetime);
			}
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	/* Save - Comment */
  if($type=='update'){
  	// check the vicharan_note_id in database
  	$db_vicharan_note_id = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'vicharan_note_id',DB_PREFIX.'vicharan_notes', "vicharan_note_id='$vicharan_note_id'");
  	/* Update current note */
  	if(!empty($vicharan_note_id) AND ($db_vicharan_note_id==$vicharan_note_id)){
  		if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'vicharan_notes', array("positive_points" => $positive_points, "issues" => $issues, "follow_up_list" => $follow_up_list, "other_comment" => $other_comment), array("vicharan_note_id" => $vicharan_note_id))){
				$output.=',
					"status":"error",
					"message":"We had some error saving your comment.",
					"error":"'.$Core->error_message('Error saving your comment', __FILE__, __LINE__, $Database->error()).'"'
				;
			}else{
				$output.=',
					"status":"success",
					"message":"You comment is updated.",
					"vicharanNotes":'.Sync::vicharanNotes().',
					"myVicharanEvents":'.Sync::myVicharanEvents().',
					"myCheckIn":'.Sync::myCheckIn().'
				';
			}
  	}
  	// there is no vicharan_not matching in database so add new note
    else{
    	$checkin_datetime = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'post_datetime',DB_PREFIX.'check_in',"check_in_id='$id'");

    	// change time so we can add note
    	$type = 'add';
    	$come_from = 'check-in';
    }
  }

  /* ********** ********** **********	**********	**********	********** */
	/* Save */
	if($type=='add'){
		// get vicharan_note_id
  	$vicharan_note_id = 0;
  	$vicharan_note_id = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'vicharan_note_id', DB_PREFIX.'vicharan_notes', '', "ORDER BY vicharan_note_id DESC LIMIT 1");
  	$vicharan_note_id = $vicharan_note_id + 1;

  	$checkin_datetime = !isset($checkin_datetime) ? $Core->datetime : $checkin_datetime;
  	$come_from        = !isset($come_from) ? '' : $come_from;

		if(!$Database->add_vicharan_note(array(__LINE__, __METHOD__, __FILE__), $vicharan_note_id, $Session->profile_id, $center, $sabha, $positive_points, $issues, $follow_up_list, $other_comment, $Session->profile_id, $email)){
			$output.=',
				"status":"error",
				"message":"We had some error saving your vicharan note.",
				"error":"'.$Core->error_message('Error saving your vicharan note', __FILE__, __LINE__, $Database->error()).'"'
			;
		}else{
			if($email=='Y'){
	    	vicharan_note_email($vicharan_note_id, $center, $checkin_datetime, $positive_points, $issues, $follow_up_list, $other_comment);
			}

			// Update the vicharan note id in the check_in tabel for linking
			if($come_from=='check-in'){
				$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'check_in', array("vicharan_note_id" => $vicharan_note_id), array("check_in_id" => $id));
			}
			$output.=',
				"status":"success",
				"message":"You vicharan note is saved.",
				"vicharanNotes":'.Sync::vicharanNotes().',
				"myVicharanEvents":'.Sync::myVicharanEvents().',
				"myCheckIn":'.Sync::myCheckIn().'
			';
		}
	}
}
?>