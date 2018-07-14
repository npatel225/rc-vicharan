<?php
if($Session->login){
  /* ********** ********** ********* ********* ********* ********* ********* */
  if($type=='get-details'){
    $array  = $Core->gender_mandal($mandal);
    $gender = $array['gender'];
    $mandal = $array['mandal'];

    $output .= ',"details": '.json_encode(Sync::centerAnalysis16Detail($center, $year, $gender, $mandal));
    // $output .= Sync::centerAnalysis16Detail($center, $year, $gender, $mandal);
  }

  if($type=='edit-details'){
    $data = (get_magic_quotes_gpc()) ? stripslashes($data) : $data;
    $rows = json_decode($data, true);
    // get the gender and mandal from incoming mandal
    $array  = $Core->gender_mandal($mandal);
    $gender = $array['gender'];
    $mandal = $array['mandal'];
    $by_who = ($Session->user_level==UL_SANCHALAK) ? 'sanchalak' : 'rc';
    $message = '';

    if($year=='2015'){ $year += 1;}

    for ($i=0; $i < count($rows); $i++) { 
      $row                = $rows[$i];
      $goal_id            = $row['goal_id'];
      $goal_name          = $row['goal_name'];
      $center_analysis_id = intval($row['center_analysis_id']);
      $spring_term        = floatval($row['spring_term']);
      $summer_term        = floatval($row['summer_term']);
      $fall_term          = floatval($row['fall_term']);
      $year_goal          = floatval($row['year_goal']);
      $action_item        = $Core->replace_quotes($row['action_item']);
      $who_to_focus_on    = $Core->replace_quotes($row['who_to_focus_on']);
      $pre_summer_lam     = $Core->replace_quotes($row['pre_summer_lam']);
      $pre_fall_lam       = $Core->replace_quotes($row['pre_fall_lam']);

      if($center_analysis_id){
        // update database
        $update = array(
          "spring_term"     => $spring_term,
          "summer_term"     => $summer_term,
          "fall_term"       => $fall_term,
          "year_goal"       => $year_goal,
          "action_item"     => $action_item,
          "who_to_focus_on" => $who_to_focus_on,
          "pre_summer_lam"  => $pre_summer_lam,
          "pre_fall_lam"    => $pre_fall_lam
        );

        if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis_16_detail', $update, array("center_analysis_id" => $center_analysis_id))){
          $message .= $Core->error_message('Error updating '.$goal_name, __FILE__, __LINE__, $Database->error());
        }
      }else{
        // add to database
        if(!$Database->add_center_analysis16_detail(array(__LINE__, __METHOD__, __FILE__), $goal_id, $center, $year, $mandal, $gender, $by_who, $spring_term, $summer_term, $fall_term, $year_goal, $action_item, $who_to_focus_on, $pre_summer_lam, $pre_fall_lam, $Session->profile_id)){
            $line_num=__LINE__;
            $message .= $Core->error_message('Error saving '.$project_name, __FILE__, __LINE__, $Database->error());
        }else{
          // email about the update
          $region = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'region', DB_PREFIX.'centers', "center='$center'");
          $full_name = $Session->first_name.' '.$Session->last_name;
          Email::centerAnalysis16Update($gender, $mandal, $full_name, $region, $center);
        }
      }
    }

    //
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
        "details":'.json_encode(Sync::centerAnalysis16Detail($center, $year, $gender, $mandal)).'
      ';
    }

  }
}

?>