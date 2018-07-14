<?php
require_once '../class/Config.php';
require_once '../class/Core.class.php';
if($Session->login){
    $filename = 'RcVicharan-Center_Analysis16_Summary-'.date("Y-m-d");
  if($Session->user_level<=UL_SANCHALAK){

    $regionCenter = json_decode(Sync::regionCenter(), true);
    $excel = array();

    if(count($regionCenter)>0){
      for ($i=0; $i < count($regionCenter); $i++) { 
        for ($j=0; $j < count($regionCenter[$i]['centers']); $j++) {
          $region = $regionCenter[$i]['region']; 
          $center = $regionCenter[$i]['centers'][$j]['name'];
          // export projects and challenges
          $result = Sync::centerAnalysis16Detail($center, $year, '', '');
          // make file only if the result have data
          if(count($result)>0){
            if(empty($excel)){
              $excel = array(
                array("10 in 2016 Center Analysis"),
                array("Wing", "Region", "Center", "Category", "Goal Name", "Goal Description", "Goal Metric", "Sprint Term (Jan-Apr)", "Summer Term (May-Aug)", "Fall Term (Sept-Dec)", "Yearly Goal", "Action Item", "Who to Focus On", "Pre-Summer LAM Update", "Pre-Fall LAM Update")
              );
            }
            // build array for export
            for($a=0; $a<count($result); $a++){
              $row  = $result[$a];
              $wing = $Core->mandal_name($row['gender'], $row['mandal']);
              $excel[count($excel)] = array(
                $wing,
                $region,
                $center,
                $row["category"],
                $row["goal_name"],
                $row["goal_desc"],
                $row["goal_metric"],
                $row["spring_term"],
                $row["summer_term"],
                $row["fall_term"],
                $row["year_goal"],
                $row["action_item"],
                $row["who_to_focus_on"],
                $row["pre_summer_lam"],
                $row["pre_fall_lam"]
              );
            }
          }
        }
      }
      // echo json_encode($excel);
      // generate file (constructor parameters are optional)
      $xls = new ExcelWriter('UTF-8', false, 'Export');
      $xls->addArray($excel);
      $xls->generateXML($filename);
      exit;
    }

  }else{echo 'You do not have access to this page';}
}else{echo "You are not logged-in.";}
?>