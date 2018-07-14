<?php 
if($Session->login){
  
  $name    = $Core->replace_quotes(trim($name));
  $measure = $Core->replace_quotes(trim($measure));

  require_once 'admin-center-analysis16.php';
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Profile - get
  if($type=='get-profile'){
    $result = $Database->get_data(array(__LINE__, __METHOD__, __FILE__), '*', DB_PREFIX.'profiles', "profile_id='$id'");
    if(count($result)>0){
      $data = $result[0];
      $output.=',"info":{
        "first_name":"'.$data["first_name"].'",
        "last_name":"'.$data["last_name"].'",
        "username":"'.$data["username"].'",
        "email":"'.$data["email"].'",
        "user_level":"'.$data["user_level"].'",
        "gender":"'.$data["gender"].'",
        "mandal":"'.$data["mandal"].'",
        "region":"'.$data["region"].'",
        "center":"'.$data["center"].'",
        "active":"'.$data["active"].'"
      }';
    }else{
      $output.='';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Profile - add
  if($type=='add-profile'){
    $active = ($mandal=='C') ? NULL : 'Y';
    if(!$Database->add_profile(array(__LINE__, __METHOD__, __FILE__), strtolower($Core->rand_string(10)), $gender, $first_name, $last_name, $email, $mandal, $region, $region_center, $user_level, $active, $Session->profile_id)){
      $output.=',
        "error":"'.$Core->error_message('Error adding '.$first_name.' profile', __FILE__, __LINE__, $Database->error()).'",
        "status":"error",
        "message":"We had some error adding '.$first_name.' profile."
      ';
    }else{
      $output.=',
        "status":"success",
        "message":"'.$first_name.' profile is added.",
        "data":'.Sync::profiles().'
      ';
    }
  }

/* ********** ********** ********* ********* ********* ********* ********* */
  // Profile - edit
  if($type=='edit-profile'){
    $email    = strtolower($email);
    $username = explode('@', $email);
    $username = $username[0];
    if(!$Database->update(
      array(__LINE__, __METHOD__, __FILE__), 
      DB_PREFIX.'profiles',
      array(
        "first_name" => ucwords(strtolower($first_name)),
        "last_name"  => ucwords(strtolower($last_name)),
        "email"      => $email,
        "username"   => $username,
        "gender"     => $gender,
        "mandal"     => $mandal,
        "region"     => $region,
        "center"     => $region_center,
        "user_level" => $user_level
      ),
      array("profile_id" => $id)
    )){
      $output .= ',
        "status":"error",
        "message":"We had some error updating '.$first_name.' profile.",
        "error":"'.$Core->error_message('Error updating '.$first_name.' profile', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }else{
      $output.=',
        "status":"success",
        "message":"'.$first_name.' profile is updated.",
        "data":'.Sync::profiles().'
      ';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Reset password
  if($type=='reset-password'){
    $db_data  = $Database->get_data(array(__LINE__, __METHOD__, __FILE__), 'first_name,last_name', DB_PREFIX.'profiles', "profile_id='$id'");
    $password = md5(strtolower(str_replace(' ', '', $db_data[0]['last_name'].$db_data[0]['first_name'])));
    if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', array("password" => $password), array("profile_id" => $id))){
      $output.=',
        "error":"'.$Core->error_message('Error reseting password', __FILE__, __LINE__, $Database->error()).'",
        "status":"error",
        "message":"We had some error reseting password."'
      ;
    }else{
      $output.=',
        "status":"success",
        "message":"The new password is lastname and firstname <strong>All lowercase</strong>",
        "data":'.Sync::profiles().'
      ';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Active Profile
  if($type=='active-profile'){
    if(empty($value)){$value=NULL;}
    if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', array("active" => $value), array("profile_id" => $id))){
      if($value==NULL){
        $output.=',
          "status":"error",
          "title":"Error deactivating profile",
          "message":"We had some error deactivating profile.",
          "error":"'.$Core->error_message('Error deactivating profile', __FILE__, __LINE__, $Database->error()).'"'
        ;
      }else{
        $output.=',
          "status":"error",
          "title":"Error activating profile",
          "message":"We had some error activating profile.",
          "error":"'.$Core->error_message('Error activating profile', __FILE__, __LINE__, $Database->error()).'"'
        ;
      }
    }else{
      if($value==NULL){
        $output.=',
          "status":"success",
          "title":"Profile Deactivated",
          "message":"<h3>This user profile is deactivated now.</h3><p>He/She can not login and will not receive any emails from website.</p>",
          "error":"",
          "data":'.Sync::profiles().'
        ';
      }else{
        $output.=',
          "status":"success",
          "title":"Profile Activated",
          "message":"<h3>This user profile is activated now.</h3><p>He/She can login and will receive email updates from website.</p>",
          "error":"",
          "data":'.Sync::profiles().'
        ';
      }
    }
  }

/* ********** ********** ********* ********* ********* ********* ********* */
  // Assign Center - add
  if($type=='add-assign-center'){
    $id = $user;
    $center = $region_center;
    $db_center=$Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'center', DB_PREFIX.'assign_centers', "profile_id='$id' AND center='$center'");
    if(!empty($db_center) AND ($db_center==$center)){
      $output.=',
        "status":"error",
        "message":"'.$center.' is already assign to user.",
        "error":"If you want to update the mandal please edit them by clicking on the edit button next to the center under user name."'
      ;
    }else if(!$Database->add_assign_center(array(__LINE__, __METHOD__, __FILE__), $id, $center, $Session->profile_id)){
      $output.=',
        "status":"error",
        "message":"We had some error saving the center.",
        "error":"'.$Core->error_message('Error saving center', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }else{
      // 3.1 $Database->update(DB_PREFIX.'assign_centers',$mandal,"profile_id='$id' AND center='$center'");
      $Database->add_goal(array(__LINE__, __METHOD__, __FILE__), $id, $center, '0', date("Y"), $Session->profile_id);
      $output.=',
        "status":"success",
        "message":"'.$center.' is assigned to user now.",
        "data":'.Sync::assignedCenters().'
      ';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Assign Center - edit
  if($type=='edit-assign-center'){
    if(!empty($value)){ 
      $value = json_decode($value, true);
      $value["update_datetime"] = $Core->datetime;
      $value["update_profile_id"] = $Session->profile_id;
    }
    if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'assign_centers', $value, array("assign_center_id" => $id))){
      $output.=',
        "status":"error",
        "message":"We had some error updating the center.",
        "error":"'.$Core->error_message('Error updating center', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }else{
      $output.=',
        "status":"success",
        "message":"User center is updated.",
        "data":'.Sync::assignedCenters().'
      ';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Assign Center - remove
  if($type=='remove-assign-center'){
    
    if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'assign_centers', "assign_center_id='$id'")){
      $output.=',
        "status":"error",
        "message":"We had some error removing the center.",
        "error":"'.$Core->error_message('Error removing center', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }else{
      $output.=',
        "status":"success",
        "message":"Center is removed.",
        "data":'.Sync::assignedCenters().'
      ';
    }
  }

/* ********** ********** ********* ********* ********* ********* ********* */
  // Centers - Add
  if($type=='add-centers'){
    $db_center=$Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'center', DB_PREFIX.'centers', "region='$region' AND center='$center'");
    if(!empty($db_center) AND ($db_center==$center)){
      $output.=',
        "status":"error",
        "message":"'.$center.' is already in database.",
        "error":"If you want to update the mandal please edit them by clicking on the edit button next to the center."'
      ;
    }else if(!$Database->add_center(array(__LINE__, __METHOD__, __FILE__), $Session->profile_id, $region, $center, $bm, $km, $bst, $kst, $campus, $goshti, $lam)){
      $output.=',
        "error":"'.$Core->error_message('Error adding: ', __FILE__, __LINE__, $Database->error()).'",
        "status":"error",
        "message":"We had some error adding the center."'
      ;
    }else{
      // add center profile for e/i BK
      $Database->add_profile(array(__LINE__, __METHOD__, __FILE__), strtolower($Core->rand_string(10)), 'M', $center, 'Bal', 'bal.'.$center.'@baps.us', 'B', $region, $center, UL_SANCHALAK, 'Y', $Session->profile_id, SETUP);
      $Database->add_profile(array(__LINE__, __METHOD__, __FILE__), strtolower($Core->rand_string(10)), 'M', $center, 'Kishore', 'kishore.'.$center.'@baps.us', 'K', $region, $center, UL_SANCHALAK, 'Y', $Session->profile_id, SETUP);
      $Database->add_profile(array(__LINE__, __METHOD__, __FILE__), strtolower($Core->rand_string(10)), 'F', $center, 'Balika', 'balika.'.$center.'@baps.us', 'B', $region, $center, UL_SANCHALAK, 'Y', $Session->profile_id, SETUP);
      $Database->add_profile(array(__LINE__, __METHOD__, __FILE__), strtolower($Core->rand_string(10)), 'F', $center, 'Kishori', 'kishori.'.$center.'@baps.us', 'K', $region, $center, UL_SANCHALAK, 'Y', $Session->profile_id, SETUP);
      //
      $output.=',
        "status":"success",
        "message":"'.$center.' is added to database.",
        "data":'.Sync::regionCenter().'
      ';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Centers - edit
  if($type=='edit-centers'){
    if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'centers', array("bm" => $bm, "km" => $km, "bst" => $bst, "kst" => $kst, "campus" => $campus, "goshti" => $goshti, "lam" => $lam), array("center_id" => $id))){
      $output.=',
        "status":"error",
        "message":"We had some error updating the center.",
        "error":"'.$Core->error_message('Error updating: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }else{
      $output.=',
        "status":"success",
        "message":"center is updated.",
        "data":'.Sync::regionCenter().'
      ';
    }
  }
    
/* ********** ********** ********* ********* ********* ********* ********* */
  // Centers - Remove
  if($type=='remove-centers'){
    if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'centers', "center_id='$id'")){
      $output.=',
        "error":"'.$Core->error_message('Error removing: ', __FILE__, __LINE__, $Database->error()).'",
        "status":"error",
        "message":"We had some error removing the center."'
      ;
    }else{
      // Remove profiles
      $Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', "first_name='$center'");
      //
      $output.=',
        "status":"success",
        "message":"Center is removed.",
        "data":'.Sync::regionCenter().'
      ';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Select other option - add
  if($type=='add-other-option'){
    // check if the option is in the list
    $db_check = $Database->get_num_rows(array(__LINE__, __METHOD__, __FILE__), 'name', DB_PREFIX.'lists', "parent='Other Option' AND name='$name'");
    // option is in the database
    if($db_check!=0){
      $output .= ',
        "status":"error",
        "message":"already in database.",
        "error":""'
      ;
    }
    // error adding option in the list
    else if(!$Database->add_list(array(__LINE__, __METHOD__, __FILE__), $Session->profile_id, 'Other Option', $name)){
      $output .= ',
        "status":"error",
        "message":"We had some error adding the new option.",
        "error":"'.$Core->error_message('Error adding: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // option is added in the list
    else{
      $output.=',
        "status":"success",
        "message":"added to option list.",
        "data":'.Sync::select().'
      ';
    }
  }
  
/* ********** ********** ********* ********* ********* ********* ********* */
  // Select other option - remove
  if($type=='remove-other-option'){
    // error removing option from list
    if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'lists', "list_id='$id'")){
      $output .= ',
        "status":"error",
        "message":"We had some error removing.",
        "error":"'.$Core->error_message('Error removing: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // option is removed from list
    else{
      $output.=',
        "status":"success",
        "message":"removed.",
        "data":'.Sync::select().'
      ';
    }
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Active Projects 16 - add
  if($type=='add-active-project16'){

    $gender = $Session->gender;
    $mandal = $Session->mandal;

    // check if the active project is in the list
    $db_check = $Database->get_num_rows(array(__LINE__, __METHOD__, __FILE__), 'list_id', DB_PREFIX.'center_analysis_16_goals', "year='$year' AND list_id='$list_id' AND mandal='$mandal' AND gender='$gender'");
    // active project is not in the project table
    if($db_check!=0){
      $output .= ',
        "status":"error",
        "message":"This goal is already active and can\'t be added again.",
        "error":""'
      ;
    }

    // error adding active project
    else if(!$Database->add_center_analysis16_goal(array(__LINE__, __METHOD__, __FILE__), $list_id, $gender, $mandal, $year, $category, $description, $metric, $metric_max, $Session->profile_id)){
      $output .= ',
        "status":"error",
        "message":"We had some error adding the project.",
        "error":"'.$Core->error_message('Error adding: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // active project is added
    else{
      $output.=',
        "status":"success",
        "message":"added.",
        "data":'.Sync::projects16().'
      ';
    }
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Active Projects 16 - edit
  if($type=='edit-active-project16'){
    // error updateing active project
    if(
      !$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis_16_goals', 
      array(
        "list_id" => $list_id, 
        "year" => $year, 
        "goal_description" => $description,
        "goal_category" => $category,
        "goal_metric" => $metric,
        "goal_metric_max" => $metric_max,
        "update_datetime" => $Core->datetime, 
        "update_profile_id" => $Session->profile_id
      ), array("goal_id" => $id))){
      $output .= ',
        "status":"error",
        "message":"We had some error updating the project ('.$goal_name.').",
        "error":"'.$Core->error_message('Error adding: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // active project is added
    else{
      $output.=',
        "status":"success",
        "message":"updated",
        "data":'.Sync::projects16().'
      ';
    }
  }
  
  /* ********** ********** ********* ********* ********* ********* ********* */
  // Active Projects 16 - remove
  if($type=='remove-active-project16'){
    $db_check = $Database->get_num_rows(
      array(__LINE__, __METHOD__, __FILE__), 
      'goal_id', 
      DB_PREFIX.'center_analysis_16_detail', 
      "goal_id='$id'"
    );
    if($db_check!=0){
      $output .= ',
        "status":"error",
        "message":"We can\'t remove the project because the project is used in center analysis.",
        "error":""'
      ;
    }
    // error removing project
    else if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'center_analysis_16_goals',"goal_id='$id'")){
      $output .= ',
        "status":"error",
        "message":"We had some error removing the project('.$id.').",
        "error":"'.$Core->error_message('Error removing: '.$id, __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // project is removed
    else{
      $output.=',
        "status":"success",
        "message":"removed.",
        "data":'.Sync::projects16().'
      ';
    }
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Projects - add
  if($type=='add-active-project'){
    if($common){
      $goal_a = $goal_b = $goal_c = $goal;
    }
    // check if the active project is in the list
    $db_check = $Database->get_num_rows(array(__LINE__, __METHOD__, __FILE__), 'project_list_id', DB_PREFIX.'projects', "year='$year' AND project_list_id='$list_id' AND mandal='$Session->mandal' AND gender='$Session->gender'");
    // active project is not in the project table
    if($db_check!=0){
      $output .= ',
        "status":"error",
        "message":"This project is already active and can\'t be added again.",
        "error":""'
      ;
    }
    // error adding active project
    else if(!$Database->add_active_project(array(__LINE__, __METHOD__, __FILE__), $Session->profile_id, $list_id, $part_of_10_goals, $measure, $goal_a, $goal_b, $goal_c, $common, $Session->mandal, $Session->gender, $year)){
      $output .= ',
        "status":"error",
        "message":"We had some error adding the project.",
        "error":"'.$Core->error_message('Error adding: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // active project is added
    else{
      $output.=',
        "status":"success",
        "message":"added.",
        "data":'.Sync::projects().'
      ';
    }
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Projects - edit
  if($type=='edit-active-project'){
    if($common){
      $goal_a = $goal_b = $goal_c = $goal;
    }
    // error updateing active project
    if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'projects', array("project_list_id" => $list_id, "part_of_10_goals" => $part_of_10_goals, "measure" => $measure, "goal_a" => $goal_a, "goal_b" => $goal_b, "goal_c" => $goal_c, "goal_common" => $common, "year" => $year, "update_datetime" => $Core->datetime, "update_profile_id" => $Session->profile_id), array("project_id" => $id))){
      $output .= ',
        "status":"error",
        "message":"We had some error updateing the project ('.$project_name.').",
        "error":"'.$Core->error_message('Error adding: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // active project is added
    else{
      $output.=',
        "status":"success",
        "message":"updated",
        "data":'.Sync::projects().'
      ';
    }
  }
  
  /* ********** ********** ********* ********* ********* ********* ********* */
  // Projects - remove
  if($type=='remove-active-project'){
    $db_check = $Database->get_num_rows(array(__LINE__, __METHOD__, __FILE__), 'project_id', DB_PREFIX.'project_details', "project_id='$id'");
    if($db_check!=0){
      $output .= ',
        "status":"error",
        "message":"We can\'t remove the project because the project is used in center analysis.",
        "error":""'
      ;
    }
    // error removing project
    else if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'projects',"project_id='$id'")){
      $output .= ',
        "status":"error",
        "message":"We had some error removing the project('.$id.').",
        "error":"'.$Core->error_message('Error removing: '.$id, __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // project is removed
    else{
      $output.=',
        "status":"success",
        "message":"removed.",
        "data":'.Sync::projects().'
      ';
    }
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Project list - add
  if($type=='add-projects-list'){
    //
    $db_check = $Database->get_num_rows(array(__LINE__, __METHOD__, __FILE__), 'name', DB_PREFIX.'lists', "parent='Projects' AND name='$name'");
    //
    if($db_check!=0){
      $output .= ',
        "status":"error",
        "message":"already in project list.",
        "error":""'
      ;
    }
    //
    else if(!$Database->add_list(array(__LINE__, __METHOD__, __FILE__), $Session->profile_id, 'Projects', $name)){
      $output .= ',
        "status":"error",
        "message":"We had some error adding to project list.",
        "error":"'.$Core->error_message('Error adding: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    //
    else{
      $output .= ',
        "status":"success",
        "message":"added in project list.",
        "data":'.Sync::select().'
      ';
    }
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Project list - edit
  if($type=='edit-projects-list'){
    // error updating the proejct name in the list
    if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'lists', array("name" => $name, "update_datetime" => $Core->datetime, "update_profile_id" => $Session->profile_id), array("list_id" => $id))){
      $output .= ',
        "status":"error",
        "message":"We had some error updating to project list.",
        "error":"'.$Core->error_message('Error updateing: ', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // project is updated
    else{
      $output.=',
        "status":"success",
        "message":"updated in project list.",
        "select":'.Sync::select().',
        "projects":'.Sync::projects().'
      ';
    }
  }
  
  /* ********** ********** ********* ********* ********* ********* ********* */
  // Project list - remove
  if($type=='remove-projects-list'){
    // check if the project is use in active list
    $db_check = $Database->get_num_rows(array(__LINE__, __METHOD__, __FILE__), 'project_list_id', DB_PREFIX.'projects', "project_list_id='$id'");
    // project is use in active list
    if($db_check!=0){
      $output .= ',
        "status":"error",
        "message":"Sorry we can not remove it from project list because this project is still active.",
        "error":""'
      ;
    }
    // error removing the proejct
    else if(!$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'lists',"list_id='$id'")){
      $output.=',
        "status":"error",
        "message":"We had some error removing.",
        "error":"'.$Core->error_message('Error removing option', __FILE__, __LINE__, $Database->error()).'"'
      ;
    }
    // project is removed
    else{
      $output.=',
        "status":"success",
        "message":"removed from project list.",
        "data":'.Sync::select().'
      ';
    }
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Upload - Center analysis import file
  if($type=='upload-center-analysis-import-file'){
    $error = false;
    $file  = '';
    $path  = '../upload';
    // make upload folder if it doen'st exists
    (!file_exists($path)) ? mkdir($path, 0777, true) : '';

    $path .= '/';

    foreach($_FILES as $file){
      (move_uploaded_file($file['tmp_name'], $path.basename($file['name']))) ? $file = $file['name'] : $error = true;
      is_uploaded_file($path.$file) ? chmod($path.$file, 0777) : '';
    }
    $output .= ($error) ? ',"status":"error"' : ',"status":"success", "file":"'.$file.'"';
  }

  /* ********** ********** ********* ********* ********* ********* ********* */
  // Import - Center analysis status
  if($type=='import-center-analysis-status'){
    require_once 'admin-import-center_analysis.php';
  }

}
?>