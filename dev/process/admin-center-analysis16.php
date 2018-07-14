<?php

if($type=='center-analysis16-upload'){
  $error = false;
  $file  = '';
  $path  = '../upload';
  // make upload folder if it doen'st exists
  (!file_exists($path)) ? mkdir($path, 0777, true) : '';

  $path .= '/';

  foreach($_FILES as $file){
    if(move_uploaded_file($file['tmp_name'], $path.basename($file['name']))){
      $file = $file['name'];
    }else{
      $error = true;
    }
    is_uploaded_file($path.$file) ? chmod($path.$file, 0777) : '';
  }
  $output .= ($error) ? ',"status":"error"' : ',"status":"success", "file":"'.$file.'"';
}

if($type=='center-analysis16-import'){
  if(count($file)>0){
    $excel = new ExcelReader('../upload/'.$file, false);
    $data = array();
    $rows  = $excel->rowcount(0);
    // skip the 1st row b/c it's title row and we don't want it.
    for ($a=1; $a<=$rows; $a++){
      // copy the data from excel to loop var.
      $center_analysis_id = intval($excel->val($a, "A"));
      $goal_id            = intval($excel->val($a, "B"));
      $by_who             = trim($excel->val($a, "C"));
      $wing               = trim($excel->val($a, "D"));
      $region             = trim($excel->val($a, "E"));
      $center             = trim($excel->val($a, "F"));
      $year               = trim($excel->val($a, "G"));
      $category           = trim($excel->val($a, "H"));
      $goal_name          = trim($excel->val($a, "I"));
      // $goal_desc          = trim($excel->val($a, "J"));
      // $goal_metric        = trim($excel->val($a, "K"));
      $spring_term        = intval($excel->val($a, "L"));
      $summer_term        = intval($excel->val($a, "M"));
      $fall_term          = intval($excel->val($a, "N"));
      $year_goal          = intval($excel->val($a, "O"));
      $year_goal          = abs($spring_term + $summer_term + $fall_term);
      $action_item        = trim($excel->val($a, "P"));
      $who_to_focus_on    = trim($excel->val($a, "Q"));
      $pre_summer_lam     = trim($excel->val($a, "R"));
      $pre_fall_lam       = trim($excel->val($a, "S"));
      $stats              = array("status"=>"","message"=>"");


      $mandal = $Core->gender_mandal($wing);
      $gender = $mandal['gender'];
      $mandal = $mandal['mandal'];

      // find the ID
      if(empty($center_analysis_id)){
        $where = array(
          'year' => $year,
          'mandal' => $mandal,
          'gender' => $gender,
          'by_who' => $by_who,
          'center' => $center,
          'goal_id' => $goal_id
        );
        if($id = $Database->get_data_field(
          array(__LINE__, __METHOD__, __FILE__), 
          'center_analysis_id', 
          DB_PREFIX.'center_analysis_16_detail', 
          $Database->buildQueryString($where, true, ' AND ')
        )){
          $center_analysis_id = $id;
        }
      }

      // ID is not empty
      if(!empty($center_analysis_id) && is_numeric($center_analysis_id)){
        // update database
        $result = $Database->update(
          array(__LINE__, __METHOD__, __FILE__),
          DB_PREFIX.'center_analysis_16_detail', 
          array(
            'spring_term' => $spring_term,
            'summer_term' => $summer_term,
            'fall_term'   => $fall_term,
            'year_goal'   => $year_goal,
            'update_datetime' => $Core->get_datetime(),
            'update_profile_id' => $Session->profile_id,
          ),
          array(
            "center_analysis_id" => $center_analysis_id
          )
        );
        if(!$result){
          $line_num = __LINE__;
          $status = array(
            "status" => "error",
            "message" => $Core->error_message('Error updating ', $_SERVER['PHP_SELF'], $line_num, $Database->mysqli_error())
          );
        }else{
          $status = array(
            "status" => "success",
            "message" => "Update successfuly."
          );
        }
      }
      // Add new Entry
      else{
        // add to database
        if(!$Database->add_center_analysis16_detail(array(__LINE__, __METHOD__, __FILE__), $goal_id, $center, $year, $mandal, $gender, $by_who, $spring_term, $summer_term, $fall_term, $year_goal, $action_item, $who_to_focus_on, $pre_summer_lam, $pre_fall_lam, $Session->profile_id)){
            $status = array(
            "status" => "error",
            "message" => $Core->error_message('Error updating ', __FILE__, __LINE__, $Database->mysqli_error())
          );
        }else{
          $center_analysis_id = $Database->getInsertId();
          $status = array(
            "status" => "success",
            "message" => "Update successfuly."
          );
        }
      }
      // add for output
      array_push($data, array($center_analysis_id, $by_who, $wing, $region, $center, $year, $category, $goal_name, $spring_term, $summer_term, $fall_term, $year_goal, $status));
    }
    array_shift($data);
    array_unshift($data, array("ID", "By Who", "Wing", "Region", "Center", "Year", "Category", "Goal Name", "Sprint Term (Jan-Apr)", "Summer Term (May-Aug)", "Fall Term (Sept-Dec)", "Yearly Goal", "Status"));
    $output .= ',"data": '.json_encode($data);
  }
}
?>