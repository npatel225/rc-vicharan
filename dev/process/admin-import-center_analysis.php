<?php
if($Session->login){
  if(count($file)>0){
    $excel = new ExcelReader('../upload/'.$file, false);
    $data  = array();
    $rows  = $excel->rowcount(0);
    // skip the 1st row b/c it's title row and we don't want it.
    for ($a=1; $a<=$rows; $a++){
      // copy the data from excel to loop var.
      $id           = trim($excel->val($a, "A"));
      $mandal       = trim($excel->val($a, "B"));
      $region       = trim($excel->val($a, "C"));
      $center       = trim($excel->val($a, "D"));
      $year         = trim($excel->val($a, "E"));
      $project_name = trim($excel->val($a, "F"));
      $by_who       = trim($excel->val($a, "G"));
      $actual       = trim($excel->val($a, "H"));
      $status       = array("status"=>"","message"=>"");

      // if(empty($id)){
      //   // find the id when it's empty
      //   $mandal = $Core->gender_mandal($mandal);
      //   $gender = $mandal['gender'];
      //   $mandal = $mandal['mandal'];
      //   $by_who_id = $Core->by_who_id($by_who);
      //   $project_id = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'list_id', DB_PREFIX.'lists', 'name="'.$project_name.'"');

      //   $q = sprintf("SELECT project_detail_id FROM %sproject_details WHERE year='%s' AND gender='%s' AND mandal='%s' AND center='%s' AND by_who='%s' AND project_list_id='%s'", DB_PREFIX, $year, $gender, $mandal, $center, $by_who_id, $project_id);
      //   $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);
      //   if(!empty($result) && !empty($result[0])){
      //     $id = $result[0]['project_detail_id'];
      //   }
      // }
      
      // ID is not empty
      if(!empty($id) && is_numeric($id)){
      // update database
        $result = $Database->update(DB_PREFIX.'project_details', "actual=".(empty($actual) ? "NULL" : "'$actual'").", update_datetime='$Core->datetime', update_profile_id='$Session->profile_id'", "project_detail_id='$id'");
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
      // add for output
      $data[$a-1] = array($id, $mandal, $region, $center, $year, $project_name, $by_who, $actual, $status);
    }
    $output .= ',"data": '.json_encode($data);
  }
}
?>