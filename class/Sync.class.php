<?php
/* ********** ********** ********** **********  **********  ********** */
// Sync Class
/* ********** ********** ********** **********  **********  ********** */
class Sync{

  /* ********** ********** ********** **********  **********  ********** */
  // Assigned Cneters
  public static function assignedCenters(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RCL){
      $where = $Session->filter_query('', '', 'pf', 'pf', 'pf', 'pf');
      $where = !empty($where) ? 'WHERE '.$where : '';
      $q     = "SELECT pf.gender, pf.mandal, pf.profile_id, pf.region, CONCAT_WS(' ',pf.first_name,pf.last_name) AS name, pf.user_level, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ac.center) AS center_region, ac.center, ac.assign_center_id, ac.bm, ac.km, ac.bst, ac.kst, ac.campus, ac.goshti, ac.lam  
      FROM ".DB_PREFIX."profiles AS pf LEFT JOIN ".DB_PREFIX."assign_centers AS ac ON pf.profile_id=ac.profile_id  
      $where 
      ORDER BY gender DESC, mandal, region, name, ac.center";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=$e=0;
        $old_gender_mandal=$old_region=$old_user='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];

          // Mandal
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]}]},': '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'",
              "mandal2":"'.$row["mandal"].'",
              "regions":[
            ';
            $b++;
            $c=$d=$e=0;
            $old_region=$old_user='';
          }
          // Region
          if($old_region!=$row["region"]){
            $output .= ($c>0) ? ']}]},' : '';
            $output .= '{"region":"'.$row["region"].'","users":[';
            $c++;
            $d=$e=0;
            $old_user='';
          }
          // User
          if($old_user!=$row["profile_id"]){
            $output .= ($d>0) ? ']},' : '';
            $output .= '{"name":"'.$row["name"].'",
              "id":"'.$row["profile_id"].'",
              "user_level": "'.$row["user_level"].'",
              "centers":[
            ';
            $d++;
            $e=0;
          }
          if(!empty($row["center"])){
            $output .= ($e>0) ? ',' : '';
            $e++;
            $output .= '{
              "id":"'.$row["assign_center_id"].'",
              "region":"'.$row["center_region"].'",
              "center":"'.$row["center"].'",
              "bm":"'.$row["bm"].'",
              "km":"'.$row["km"].'",
              "bst":"'.$row["bst"].'",
              "kst":"'.$row["kst"].'",
              "campus":"'.$row["campus"].'",
              "goshti":"'.$row["goshti"].'",
              "lam":"'.$row["lam"].'"
            }';
          }
          $output           .= ($a==(count($result)-1)) ? ']}]}]}' : '';
          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_region        = $row["region"];
          $old_user          = $row["profile_id"];
        }
      }
    }
    return '['.$output.']';
  }

  public static function centerAnalysis16(){
    global $Database, $Session, $Core, $Logs;

    return '[]';
    $output     = '';
    $year_start = 2015;
    $year_this  = date('Y')+1;
    $year_i     = $year_this-$year_start;
    $genders    = $Session->gender_mandal();
    $by_who     = ($Session->user_level==UL_SANCHALAK) ? 2 : 1;

    $where = $Session->filter_region_center('', '', 'c', 'c');
    $where = !empty($where) ? 'WHERE '.$where : '';
    $q = '';
    for ($a=0; $a<$year_i; $a++){
      $year = date('Y')-$a;
      for($g=0; $g<count($genders); $g++){
        $gender  = key($genders);
        $mandals = $genders[$gender];
        for($b=0; $b<count($mandals); $b++){
          $mandal = $mandals[$b];
          $q .= "SELECT '$year' as year, '$gender' as gender, '$mandal' as mandal, c.region as region, c.center as center, cad.by_rc, cad.spring_term, cad.summer_term, cad.fall_term, cad.year_goal, cad.action_item, cad.who_to_focus_on, cad.center_analysis_id, cad.goal_id, cag.list_id 
            FROM ".DB_PREFIX."centers AS c 
            LEFT JOIN ".DB_PREFIX."center_analysis_16_goals as cag ON (cag.year='$year' AND cag.gender='$gender' AND cag.mandal='$mandal') 
            LEFT JOIN ".DB_PREFIX."center_analysis_16_detail as cad ON c.center=cad.center 
            $where 
            GROUP BY c.center 
          ";
          $q .= (!empty($q) && $b<(count($mandals)-1)) ? " UNION ALL " : '';
        }
        $q .= (!empty($q) && $g<(count($genders)-1)) ? " UNION ALL " : '';
        // 
        ($g<(count($genders)-1)) ? next($genders) : reset($genders);
      }
      $q .= (!empty($q) && $a<($year_i-1)) ? " UNION ALL " : '';
    }
    $q .= !empty($q) ? " ORDER BY gender DESC, mandal, year DESC, region, center " : '';
    return $q;
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      // Reset var
      $b=$c=$d=$e=$f=0;
      $old_gender_mandal=$old_year=$old_region=$old_center='';
      for($a=0; $a<count($result); $a++){
        $row = $result[$a];
        // Groups
        if($old_gender_mandal!=$row["gender"].$row["mandal"]){
          $output .= ($b>0) ? ']}]}]}]},' : '';
          $output .= '{"index":"'.$b.'","mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","years":[';
          $b++;
          $c=$d=$e=$f=0;
          $old_year=$old_region=$old_center='';
        }

        // Year
        if($old_year!=$row["year"]){
          $output .= ($c>0) ? ']}]}]},' : '';
          $output .= '{"index":"'.$c.'","year":"'.$row["year"].'","regions":[';
          $c++;
          $d=$e=$f=0;
          $old_region=$old_center='';
        }

        // Region
        if($old_region!=$row["region"]){
          $output .= ($d>0) ? ']}]},' : '';
          $output .= '{"index":"'.$d.'","region":"'.$row["region"].'","centers":[';
          $d++;
          $e=$f=0;
          $old_center='';
        }

        // Center
        if($old_center!=$row["center"]){
          $output .= ($e>0) ? ']},' : '';
          $output .= '{
            "index":"'.$e.'",
            "center":"'.$row["center"].'",
            "percentage":"'.$row["percentage"].'",
            "progress":"'.$row["progress"].'",
            "total":"'.$row["total"].'",
            "challenges":[
          ';
          $e++;
          $f=0;
        }
        // Challenge
        if(!empty($row["center_analysis_id"])){
          $output .= ($f>0) ? ',' : '';
          $output .= '{
            "index":"'.$f.'",
            "id":"'.$row["center_analysis_id"].'",
            "challenge":"'.$row["challenge"].'",
            "root_cause":"'.$row["root_cause"].'",
            "salutation":"'.$row["salutation"].'"
          }';
          $f++;
        }
        
        $output .= ($a==(count($result)-1)) ? ']}]}]}]}' : '';

        $old_gender_mandal = $row["gender"].$row["mandal"];
        $old_year          = $row["year"];
        $old_region        = $row["region"];
        $old_center        = $row["center"];
      }
    }
    return '['.$output.']';
  }

  // Center Analysis 16 Detail
  public static function centerAnalysis16Detail($center, $year='', $gender='', $mandal='', $by_who=''){
    global $Database, $Session, $Core, $Logs;
    $year   = empty($year) ? date('Y') : $year;
    $gender = empty($gender) ? $Session->gender : $gender;
    $mandal = empty($mandal) ? $Session->mandal : $mandal;
    if(empty($by_who)) $by_who = ($Session->user_level==UL_SANCHALAK) ? 'sanchalak' : 'rc';

    if($year=='2015'){ $year += 1;}

    $q = sprintf("SELECT detail.center_analysis_id, goal.goal_id, goal.gender, goal.mandal, goal.year, detail.region, detail.center, detail.by_who, 
    (SELECT name FROM %slists WHERE list_id = goal.list_id) as goal_name, goal.goal_category, goal.goal_description, goal.goal_metric, goal.goal_metric_max, detail.spring_term, detail.summer_term, detail.fall_term, detail.year_goal, detail.action_item, detail.who_to_focus_on, detail.pre_summer_lam, detail.pre_fall_lam
    FROM %scenter_analysis_16_goals as goal 
    LEFT JOIN (SELECT detail.*, (SELECT region FROM %scenters WHERE center = detail.center) as region
      FROM %scenter_analysis_16_detail as detail
      WHERE detail.gender = '{$gender}' AND detail.mandal = '{$mandal}' AND detail.year = '{$year}' AND (detail.by_who = '{$by_who}' OR detail.by_who IS NULL) AND (detail.center = '{$center}' OR detail.center IS NULL)
      ) as detail 
    ON goal.goal_id = detail.goal_id AND goal.mandal = detail.mandal AND goal.gender = detail.gender AND goal.year = detail.year
    WHERE goal.mandal = '{$mandal}' AND goal.gender = '{$gender}' AND goal.year = '{$year}'
    ORDER BY goal.goal_category
    ", DB_PREFIX, DB_PREFIX, DB_PREFIX, DB_PREFIX);

    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    $data = array();
    if(count($result)>0){
      for ($i=0; $i < count($result); $i++) { 
        $row = $result[$i];
        if($row["goal_metric_max"]<=0){ $row["goal_metric_max"] = ''; }
        if(empty($row["by_who"])) $row["by_who"] = $by_who;
        
        $data[$i] = array(
          "goal_id" => $row["goal_id"],
          "gender"  => $row["gender"],
          "mandal"  => $row["mandal"],
          "year"    => $row["year"],
          "region"  => $row["region"],
          "center"  => $row["center"],
          "by_who"  => $row["by_who"],
          "center_analysis_id" => $row["center_analysis_id"], 
          "category"        => $row["goal_category"],
          "goal_name"       => $row["goal_name"],
          "goal_desc"       => $row["goal_description"],
          "goal_metric"     => $row["goal_metric"],
          "goal_metric_max" => $row["goal_metric_max"],
          "spring_term"     => $row["spring_term"],
          "summer_term"     => $row["summer_term"],
          "fall_term"       => $row["fall_term"],
          "year_goal"       => $row["year_goal"],
          "action_item"     => $row["action_item"],
          "who_to_focus_on" => $row["who_to_focus_on"],
          "pre_summer_lam"  => $row["pre_summer_lam"],
          "pre_fall_lam"    => $row["pre_fall_lam"],
        );
      }
    }
    return $data;
    // $output = ',"query":"'.$q.'"';
    // $output .= ',"details": '.json_encode($data);
    // return $output;
  }
  /* ********** ********** ********** **********  **********  ********** */
  // Center analysis
  public static function centerAnalysis15(){
    global $Database, $Session, $Core, $Logs;

    $output     = '';
    $year_start = 2014;
    $year_this  = date('Y');
    $year_i     = $year_this-$year_start;
    $genders    = $Session->gender_mandal();
    $by_who     = ($Session->user_level==UL_SANCHALAK) ? 2 : 1;

    $where = $Session->filter_region_center('', '', 'c', 'c');
    $where = !empty($where) ? 'WHERE '.$where : '';
    $q = '';
    for ($a=0; $a<$year_i; $a++){
      $year = date('Y')-$a;
      for($g=0; $g<count($genders); $g++){
        $gender = key($genders);
        $mandals = $genders[$gender];
        for($b=0; $b<count($mandals); $b++){
          $mandal = $mandals[$b];
          $q .= "SELECT y.year, y.gender, y.mandal, y.region, y.center, y.by_who, y.percentage, y.progress, y.total, ca.center_analysis_id, ca.challenge, ca.root_cause, ca.salutation FROM 
            (
              SELECT '$year' as year, '$gender' as gender, '$mandal' as mandal, c.region, c.center, z.by_who, ((IF(sum(z.progress)>2,sum(z.progress),0)/count(*))*100) as percentage, sum(z.progress) as progress, count(*) as total FROM 
                (
                  SELECT progress, center, by_who FROM ".DB_PREFIX."center_analysis WHERE gender='$gender' AND mandal='$mandal' AND year='$year' AND by_who='$by_who' 
                  UNION ALL 
                  SELECT cad.progress, ca.center, ca.by_who FROM ".DB_PREFIX."center_analysis_details AS cad LEFT JOIN ".DB_PREFIX."center_analysis AS ca ON cad.center_analysis_id=ca.center_analysis_id WHERE gender='$gender' AND mandal='$mandal' AND year='$year' AND by_who='$by_who' 
                  UNION ALL
                  SELECT progress, center, by_who FROM ".DB_PREFIX."project_details WHERE gender='$gender' AND mandal='$mandal' AND year='$year' AND by_who='$by_who' 
                ) as z RIGHT JOIN ".DB_PREFIX."centers AS c ON z.center=c.center
                $where
                GROUP BY c.center
            ) as y LEFT JOIN ".DB_PREFIX."center_analysis as ca ON (y.center=ca.center AND y.year=ca.year AND y.gender=ca.gender AND y.mandal=ca.mandal AND y.by_who=ca.by_who) 
          ";
          $q .= (!empty($q) && $b<(count($mandals)-1)) ? " UNION ALL " : '';
        }
        $q .= (!empty($q) && $g<(count($genders)-1)) ? " UNION ALL " : '';
        // 
        ($g<(count($genders)-1)) ? next($genders) : reset($genders);
      }
      $q .= (!empty($q) && $a<($year_i-1)) ? " UNION ALL " : '';
    }
    $q .= !empty($q) ? " ORDER BY gender DESC, mandal, year DESC, region, center " : '';
    
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      // Reset var
      $b=$c=$d=$e=$f=0;
      $old_gender_mandal=$old_year=$old_region=$old_center='';
      for($a=0; $a<count($result); $a++){
        $row = $result[$a];
        // Groups
        if($old_gender_mandal!=$row["gender"].$row["mandal"]){
          $output .= ($b>0) ? ']}]}]}]},' : '';
          $output .= '{"index":"'.$b.'","mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","years":[';
          $b++;
          $c=$d=$e=$f=0;
          $old_year=$old_region=$old_center='';
        }

        // Year
        if($old_year!=$row["year"]){
          $output .= ($c>0) ? ']}]}]},' : '';
          $output .= '{"index":"'.$c.'","year":"'.$row["year"].'","regions":[';
          $c++;
          $d=$e=$f=0;
          $old_region=$old_center='';
        }

        // Region
        if($old_region!=$row["region"]){
          $output .= ($d>0) ? ']}]},' : '';
          $output .= '{"index":"'.$d.'","region":"'.$row["region"].'","centers":[';
          $d++;
          $e=$f=0;
          $old_center='';
        }

        // Center
        if($old_center!=$row["center"]){
          $output .= ($e>0) ? ']},' : '';
          $output .= '{
            "index":"'.$e.'",
            "center":"'.$row["center"].'",
            "percentage":"'.$row["percentage"].'",
            "progress":"'.$row["progress"].'",
            "total":"'.$row["total"].'",
            "challenges":[
          ';
          $e++;
          $f=0;
        }
        // Challenge
        if(!empty($row["center_analysis_id"])){
          $output .= ($f>0) ? ',' : '';
          $output .= '{
            "index":"'.$f.'",
            "id":"'.$row["center_analysis_id"].'",
            "challenge":"'.$row["challenge"].'",
            "root_cause":"'.$row["root_cause"].'",
            "salutation":"'.$row["salutation"].'"
          }';
          $f++;
        }
        
        $output .= ($a==(count($result)-1)) ? ']}]}]}]}' : '';

        $old_gender_mandal = $row["gender"].$row["mandal"];
        $old_year          = $row["year"];
        $old_region        = $row["region"];
        $old_center        = $row["center"];
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Center Analysis challenge
  public static function centerAnalysis15Challenges($center, $year='', $gender='', $mandal=''){
    global $Database, $Session, $Core, $Logs;
    $year   = empty($year) ? date('Y') : $year;
    $gender = empty($gender) ? $Session->gender : $gender;
    $mandal = empty($mandal) ? $Session->mandal : $mandal;
    $by_who = ($Session->user_level==UL_SANCHALAK) ? 2 : 1;
    $q = "SELECT center_analysis_id, challenge, root_cause, salutation FROM ".DB_PREFIX."center_analysis WHERE year='$year' AND center='$center' AND gender='$gender' AND mandal='$mandal' AND by_who='$by_who'";
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    $challenges = '';
    if(count($result)>0){
      for ($a=0; $a<count($result); $a++) {
        $row = $result[$a];
        $challenges .= '{
          "challenge":"'.$row['challenge'].'",
          "id":"'.$row["center_analysis_id"].'",
          "root_cause":"'.$row["root_cause"].'",
          "salutation":"'.$row["salutation"].'"
        }';
        $challenges .= ($a<(count($result)-1)) ? ', ' : '';
      }
    }
    return '['.$challenges.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Center Analysis Detail
  public static function centerAnalysisDetail($id='', $mandal='', $year='', $center='', $outside_projects=false, $full_summary=NULL){
    global $Database, $Session, $Core, $Logs;
    $where  = '';
    $output = array();
    $year   = empty($year) ? date('Y') : $year;
    // for full summary show data base on filter.
    if($full_summary===true){
      $where = $Session->filter_gender_mandal("year='$year'", '', '');
      $where = $Session->filter_region_center($where, '', '', '');
    }else{
      $gender = $Session->gender;
      $by_who = ($Session->user_level==UL_SANCHALAK) ? 2 : 1;

      if(!empty($mandal)){
        $array  = $Core->gender_mandal($mandal);
        $gender = $array['gender'];
        $mandal = $array['mandal'];
      }else{
        $mandal = $Session->mandal;
      }
      $where = !empty($id) ? "center_analysis_id='$id'" : "year='$year' AND mandal='$mandal' AND gender='$gender' AND center='$center' AND by_who='$by_who'";
    }
    // add where cause
    $where = !empty($where) ? "WHERE ".$where : '';
    // starting query
    $q = "SELECT ca.gender, ca.mandal, ca.year, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ca.center) AS region, ca.center, ca.by_who, ca.challenge, ca.center_analysis_id, cad.center_analysis_detail_id, cad.project_id, cad.people_to_focus, cad.plan_to_help, cad.santo_help, cad.jan, cad.feb, cad.mar, cad.apr, cad.may, cad.jun, cad.jul, cad.aug, cad.sep, cad.oct, cad.nov, cad.dec FROM ".DB_PREFIX."center_analysis AS ca LEFT JOIN ".DB_PREFIX."center_analysis_details AS cad ON ca.center_analysis_id=cad.center_analysis_id ";
    // join projects for other projects
    $q.= ($outside_projects AND empty($id)) ? " JOIN ".DB_PREFIX."projects AS p ON cad.project_id=p.project_id JOIN ".DB_PREFIX."lists as l ON p.project_list_id=l.list_id WHERE l.name LIKE 'Mentoring outside%'" : "";
    // final query
    $q = "SELECT gender, mandal, year, region, center, by_who, challenge, center_analysis_id, center_analysis_detail_id, project_id, people_to_focus, plan_to_help, santo_help, jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, `dec` FROM ($q) AS z $where ORDER BY gender DESC, mandal, year, region, center, by_who, challenge";
    // query result
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      $row = '';
      for($a=0; $a<count($result); $a++){
        $row = $result[$a];
        $output[$a] = array(
          "gender" => $row["gender"],
          "mandal" => $row["mandal"],
          "year" => $row["year"],
          "region" => $row["region"],
          "center" => $row["center"],
          "by_who" => $row["by_who"],
          "id" => $row["center_analysis_detail_id"],
          "project_id" => $row["project_id"],
          "challenge_name" => $row["challenge"],
          "people_to_focus" => $row["people_to_focus"],
          "plan_to_help" => $row["plan_to_help"],
          "santo_help" => $row["santo_help"],
          "months" => array($row["jan"], $row["feb"], $row["mar"], $row["apr"], $row["may"], $row["jun"], $row["jul"], $row["aug"], $row["sep"], $row["oct"], $row["nov"], $row["dec"])
        );
      }
    }
    return $output;
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Center Analysis Info
  public static function centerAnalysisInfo($project_id, $gender, $mandal, $year, $center, $by_who){
    global $Database, $Logs, $Session, $Core;
    $output = array();
    $pf = $ph = $sh = $jan = $feb = $mar = $apr = $may = $jun = $jul = $aug = $sep = $oct = $nov = $dec = "";

    $q = "SELECT ca.challenge, ca.by_who, cad.* 
    FROM ".DB_PREFIX."center_analysis as ca RIGHT JOIN ".DB_PREFIX."center_analysis_details AS cad ON cad.center_analysis_id=ca.center_analysis_id 
    WHERE project_id='$project_id' AND year='$year' AND mandal='$mandal' AND gender='$gender' AND center='$center' AND by_who='$by_who'";
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      for($a=0; $a<count($result); $a++){
        $row     = $result[$a];
        $pf     .= ($a>0) ? '. ' : '';
        $ph     .= ($a>0) ? '. ' : '';
        $sh     .= ($a>0) ? '. ' : '';

        $output[$a] = array(
          "challenge_id" => $row["center_analysis_id"],
          "challenge_name" => $row["challenge"]
        );

        $pf .= $row["challenge"].': '.(empty($row["people_to_focus"]) ? 'N/A' : $row["people_to_focus"]);
        $ph .= $row["challenge"].': '.(empty($row["plan_to_help"]) ? 'N/A' : $row["plan_to_help"]);
        $sh .= $row["challenge"].': '.(empty($row["santo_help"]) ? 'N/A' : $row["santo_help"]);

        $jan = (empty($jan) && empty($row["jan"])) ? NULL : "Y";
        $feb = (empty($feb) && empty($row["feb"])) ? NULL : "Y";
        $mar = (empty($mar) && empty($row["mar"])) ? NULL : "Y";
        $apr = (empty($apr) && empty($row["apr"])) ? NULL : "Y";
        $may = (empty($may) && empty($row["may"])) ? NULL : "Y";
        $jun = (empty($jun) && empty($row["jun"])) ? NULL : "Y";
        $jul = (empty($jul) && empty($row["jul"])) ? NULL : "Y";
        $aug = (empty($aug) && empty($row["aug"])) ? NULL : "Y";
        $sep = (empty($sep) && empty($row["sep"])) ? NULL : "Y";
        $oct = (empty($oct) && empty($row["oct"])) ? NULL : "Y";
        $nov = (empty($nov) && empty($row["nov"])) ? NULL : "Y";
        $dec = (empty($dec) && empty($row["dec"])) ? NULL : "Y";

      }
    }
    return array(
      "challenges"      => $output,
      "people_to_focus" => $pf,
      "plan_to_help"    => $ph,
      "santo_help"      => $sh,
      "months"          => array($jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec)
    );
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Checked-in by Center
  public static function checkedInCenters(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RA){
      $where = $Session->filter_query("ci.post_datetime BETWEEN '".($Database->yearChange((date('n')<3) ? 1 : 0))."-01-01 00:00:00' AND '".$Core->datetime."'", '', 'pf', 'c', 'c', 'ci');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q="SELECT pf.gender, pf.mandal, c.region, c.center, pf.profile_id, CONCAT_WS(' ',pf.first_name,pf.last_name) AS name, ci.sabha_type, ci.post_datetime, SUBSTRING_INDEX(ci.post_datetime, '-', 1) AS year 
      FROM ".DB_PREFIX."centers AS c LEFT JOIN ".DB_PREFIX."check_in AS ci ON c.center=ci.center LEFT JOIN ".DB_PREFIX."profiles as pf ON pf.profile_id=ci.profile_id
      $where
      ORDER BY gender DESC, mandal, year DESC, region, center, name, ci.post_datetime DESC";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=$e=$f=0;
        $old_gender_mandal=$old_year=$old_region=$old_center='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];
          // Mandal
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]}]}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","years":[';
            $b++;
            $c=$d=$e=$f=0;
            $old_year=$old_region=$old_center='';
          }
          // Year
          if($old_year!=$row["year"]){
            $output .= ($c>0) ? ']}]}]},' : '';
            $output .= '{"year":"'.$row["year"].'","regions":[';
            $c++;
            $d=$e=$f=0;
            $old_region=$old_center='';
          }
          // Region
          if($old_region!=$row["region"]){
            $output .= ($d>0) ? ']}]},' : '';
            $output .= '{"region":"'.$row["region"].'","centers":[';
            $d++;
            $e=$f=0;
            $old_center='';
          }
          // User
          if($old_center!=$row["center"]){
            $output .= ($e>0) ? ']},' : '';
            $output .= '{"center":"'.$row["center"].'","users":[';
            $e++;
            $f=0;
          }
          $output .= ($f>0) ? ',' : '';
          $f++;
          $output .= '{
            "name":"'.$row["name"].'",
            "datetime":"'.$Core->format_datetime($row["post_datetime"]).'",
            "sabha_type":"'.$row["sabha_type"].'",
            "id":"'.$row["profile_id"].'"
          }';
          
          $output .= ($a==(count($result)-1)) ? ']}]}]}]}' : '';

          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_year          = $row["year"];
          $old_region        = $row["region"];
          $old_center        = $row["center"];
        }
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Checked-in by Date
  public static function checkedInDates(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RA){
      $where = $Session->filter_query("ci.post_datetime BETWEEN '".($Database->yearChange(date('n')<3) ? 1 : 0)."-01-01 00:00:00' AND '".$Core->datetime."'", '', 'pf', '', 'ci', 'ci');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q="SELECT pf.gender, pf.mandal, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ci.center) AS region, ci.center, CONCAT_WS(' ',pf.first_name,pf.last_name) AS name, ci.sabha_type, ci.post_datetime, SUBSTRING_INDEX(ci.post_datetime, '-', 1) AS year 
      FROM ".DB_PREFIX."check_in AS ci LEFT JOIN ".DB_PREFIX."profiles AS pf ON pf.profile_id=ci.profile_id 
      $where
      ORDER BY gender DESC, mandal, post_datetime DESC, name, region, center";
      
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=$e=0;
        $old_gender_mandal=$old_date='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];

          // Mandal
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","years":[';
            $b++;
            $c=$d=$e  = 0;
            $old_date = '';
            $old_year = '';
          }
          // Year
          if($old_year!=$row["year"]){
            $output .= ($c>0) ? ']}]},' : '';
            $output .= '{"year":"'.$row["year"].'","dates":[';
            $c++;
            $d=$e     = 0;
            $old_date = '';
          }
          // Date
          if($old_date!=$Core->format_datetime($row["post_datetime"],"Y-m-d")){
            $output .= ($d>0) ? ']},' : '';
            $output .= '{"date":"'.$Core->format_datetime($row["post_datetime"],"M d, Y").'","users":[';
            $d++;
            $e=0;
          }
          $output .= ($e>0) ? ',' : '';
          $e++;
          $output .= '{
            "name":"'.$row["name"].'",
            "region":"'.$row["region"].'",
            "center":"'.$row["center"].'",
            "sabha_type":"'.$row["sabha_type"].'",
            "date":"'.$row["post_datetime"].'"
          }';
          
          $output           .= ($a==(count($result)-1)) ? ']}]}]}' : '';
          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_year          = $row["year"];
          $old_date          = $Core->format_datetime($row["post_datetime"],"Y-m-d");
        }
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Checked-in by User
  public static function checkedInUsers(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RA){
      $where = $Session->filter_query("ci.post_datetime BETWEEN '".($Database->yearChange(date('n')<3) ? 1 : 0)."-01-01 00:00:00' AND '".$Core->datetime."'", '', 'pf', 'pf', 'ci', 'ci');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q="SELECT pf.gender, pf.mandal, pf.profile_id, CONCAT_WS(' ',pf.first_name, pf.last_name) AS name, pf.region, ci.check_in_id, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ci.center) AS center_region, ci.center, ci.sabha_type, ci.post_datetime 
      FROM ".DB_PREFIX."check_in AS ci LEFT JOIN ".DB_PREFIX."profiles AS pf ON pf.profile_id=ci.profile_id 
      $where 
      ORDER BY gender DESC, mandal, region, name, ci.post_datetime DESC, center_region, center, ci.sabha_type";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=$e=0;
        $old_gender_mandal=$old_region=$old_user='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];
          // Mandal
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","regions":[';
            $b++;
            $c=$d=$e=0;
            $old_region=$old_user='';
          }
          // Region
          if($old_region!=$row["region"]){
            $output .= ($c>0) ? ']}]},' : '';
            $output .= '{"region":"'.$row["region"].'","users":[';
            $c++;
            $d=$e=0;
            $old_user='';
          }
          // User
          if($old_user!=$row["profile_id"]){
            $output .= ($d>0) ? ']},' : '';
            $output .= '{
              "user":"'.$row["name"].'",
              "id":"'.$row["profile_id"].'",
              "centers":[
            ';
            $d++;
            $e=0;
          }
          $output .= ($e>0) ? ',' : '';
          $e++;
          $output .= '{
            "region":"'.$row["region"].'",
            "center":"'.$row["center"].'",
            "sabha_type":"'.$row["sabha_type"].'",
            "id":"'.$row["check_in_id"].'",
            "datetime":"'.$Core->format_datetime($row["post_datetime"]).'"
          }';

          $output .= ($a==(count($result)-1)) ? ']}]}]}' : '';
          
          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_region        = $row["region"];
          $old_user          = $row["profile_id"];
        }
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // My Check-in
  public static function myCheckIn($vicharan_check_in=false){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    $select = '';
    if($Session->user_level<=UL_RC && $Session->user_level!=UL_RA && $Session->user_level!=UL_SANCHALAK){
      
      if(!$vicharan_check_in){
        $select = ", (SELECT positive_points FROM ".DB_PREFIX."vicharan_notes WHERE vicharan_note_id=ci.vicharan_note_id) AS positive_points, (SELECT issues FROM ".DB_PREFIX."vicharan_notes WHERE vicharan_note_id=ci.vicharan_note_id) AS issues, (SELECT follow_up_list FROM ".DB_PREFIX."vicharan_notes WHERE vicharan_note_id=ci.vicharan_note_id) AS follow_up_list, (SELECT other_comment FROM ".DB_PREFIX."vicharan_notes WHERE vicharan_note_id=ci.vicharan_note_id) AS other_comment";
      }
      $q = "SELECT ci.check_in_id, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ci.center) AS region, ci.center, ci.sabha_type, (SELECT vicharan_id FROM ".DB_PREFIX."vicharans WHERE check_in_id=ci.check_in_id) AS vicharan_id, ci.vicharan_note_id, ci.post_datetime $select FROM ".DB_PREFIX."check_in AS ci WHERE profile_id='$Session->profile_id' ORDER BY post_datetime DESC";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);
      
      if(count($result)>0){
        for($a=0; $a<count($result); $a++){ 
          $row = $result[$a];
          $output .= '{
            "index":'.$a.',

            "region":"'.$row["region"].'",
            "center":"'.$row["center"].'",
            "sabha":"'.$row["sabha_type"].'",

            "vicharan_id":"'.$row["vicharan_id"].'",
            "vicharan_note_id":"'.$row["vicharan_note_id"].'"
            ';
            if($vicharan_check_in){
              $output .= ',
              "id":"'.$row["check_in_id"].'",
              "date":"'.$Core->format_datetime($row["post_datetime"], "Y-m-d").'",
              "classes":"check_in",
              "note":"Checked-in"
              ';
            }else{
              $output .= ',
              "check_in_id":"'.$row["check_in_id"].'",
              "datetime":"'.$Core->format_datetime($row["post_datetime"]).'",
              "positive_points":"'.$row["positive_points"].'",
              "issues":"'.$row["issues"].'",
              "follow_up_list":"'.$row["follow_up_list"].'",
              "other_comment":"'.$row["other_comment"].'"
              ';
            }
          $output .= '}';
          $output .= ($a<(count($result)-1)) ? ',' : '';
        }
      }
    }
    return ($vicharan_check_in) ? $output : '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // My Goals
  public static function myGoals(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RC && $Session->user_level!=UL_SANCHALAK){
      $result = '';
      $where  = $Session->filter_query("g.year>='".date('Y')."'", '', 'pf', 'pf', 'g', 'pf');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q = "SELECT pf.gender, pf.mandal, pf.region, pf.profile_id, CONCAT_WS(' ',pf.first_name,pf.last_name) AS name, g.year, (SELECT region FROM ".DB_PREFIX."centers WHERE center=g.center) AS center_region, g.center, g.goal_id, g.goal, (SELECT count(*) FROM ".DB_PREFIX."check_in WHERE profile_id=pf.profile_id AND center=g.center AND post_datetime BETWEEN concat(g.year, '-01-01 00:00:00') AND concat(g.year, '-12-31 23:59:59')) AS visit 
      FROM ".DB_PREFIX."profiles AS pf LEFT JOIN ".DB_PREFIX."goals AS g ON pf.profile_id=g.profile_id 
      $where 
      ORDER BY gender DESC, mandal, g.year DESC, region, name, center_region, center
      LIMIT 10000";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        // Reset var
        $b=$c=$d=$e=$f=0;
        $old_gender_mandal=$old_year=$old_region=$old_user='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];
          // Groups
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]}]}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","years":[';
            $b++;
            $c=$d=$e=$f=0;
            $old_year=$old_region=$old_user='';
          }

          // Year
          if($old_year!=$row["year"]){
            $output .= ($c>0) ? ']}]}]},' : '';
            $output .= '{"year":"'.$row["year"].'","regions":[';
            $c++;
            $d=$e=$f=0;
            $old_region=$old_user='';
          }
          // Region
          if($old_region!=$row["region"]){
            $output .= ($d>0) ? ']}]},' : '';
            $output .= '{"region":"'.$row["region"].'","users":[';
            $d++;
            $e=$f=0;
            $old_user='';
          }
          // User
          if($old_user!=$row["profile_id"]){
            $output .= ($e>0) ? ']},' : '';
            $output .= '{"name":"'.$row["name"].'","profile_id":"'.$row["profile_id"].'","centers":[';
            $e++;
            $f=0;
          }
          $output .= ($f>0) ? ',' : '';
          $f++;
          $output .= '{
            "region":"'.$row["center_region"].'",
            "center":"'.$row["center"].'",
            "goal":"'.$row["goal"].'",
            "visited":"'.$row["visit"].'",
            "year":"'.$row["year"].'",
            "id":"'.$row["goal_id"].'"
          }';
          
          $output .= ($a==(count($result)-1)) ? ']}]}]}]}' : '';

          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_year          = $row["year"];
          $old_region        = $row["region"];
          $old_user          = $row["profile_id"];
        }
      }
    }

    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // My Vicharan Events
  public static function myVicharanEvents(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RC && $Session->user_level!=UL_RA && $Session->user_level!=UL_SANCHALAK){
      $q = "SELECT v.vicharan_id, (SELECT region FROM ".DB_PREFIX."centers WHERE center=v.center) AS region, v.center, v.sabha_type, v.date 
      FROM ".DB_PREFIX."vicharans AS v 
      WHERE v.profile_id='$Session->profile_id' AND v.check_in_id IS NULL 
      ORDER BY v.date, region, v.center";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      $check_in = self::myCheckIn(true);
      $output = (!empty($check_in)) ? $check_in : '';

      if(count($result)>0){
        $output .= (!empty($check_in)) ? ',' : '';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];

          $output .= '{
            "index":'.$a.',
            "id":"'.$row["vicharan_id"].'",

            "date":"'.$row["date"].'",
            "region":"'.$row["region"].'",
            "center":"'.$row["center"].'",
            "sabha":"'.$row["sabha_type"].'",
            "vicharan_id":"'.$row["vicharan_id"].'",
            "classes":"vicharan",
            "note":"Vicharan"
          }';
          $output .= ($a<(count($result)-1)) ? ',' : '';
        }
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Vicharan planned by user
  public static function plannedUsers(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RCL){
      $where = $Session->filter_query("v.date>='".date('Y-m-d')."'", '', 'pf', 'pf', 'v', 'pf');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q="SELECT pf.gender, pf.mandal, pf.region, pf.profile_id, CONCAT_WS(' ',pf.first_name,pf.last_name) AS name, (SELECT region FROM ".DB_PREFIX."centers WHERE center=v.center) AS center_region, v.center, v.sabha_type, v.date
      FROM ".DB_PREFIX."profiles AS pf LEFT JOIN ".DB_PREFIX."vicharans AS v ON pf.profile_id=v.profile_id 
      $where 
      ORDER BY gender DESC, mandal, region, name, v.date, center_region, center, v.sabha_type";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=$e=0;
        $old_gender_mandal=$old_region=$old_user='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];
          // Mandal
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","regions":[';
            $b++;
            $c=$d=$e=0;
            $old_region=$old_user='';
          }
          // Region
          if($old_region!=$row["region"]){
            $output .= ($c>0) ? ']}]},' : '';
            $output .= '{"region":"'.$row["region"].'","users":[';
            $c++;
            $d=$e=0;
            $old_user='';
          }
          // User
          if($old_user!=$row["profile_id"]){
            $output .= ($d>0) ? ']},' : '';
            $output .= '{"name":"'.$row["name"].'","planes":[';
            $d++;
            $e=0;
          }
          $output .= ($e>0) ? ',' : '';
          $e++;
          $output .= '{
            "region":"'.$row["center_region"].'",
            "center":"'.$row["center"].'",
            "date":"'.$Core->format_datetime($row["date"],"M d, Y").'",
            "sabha_type":"'.$row["sabha_type"].'"
          }';
          
          $output           .= ($a==(count($result)-1)) ? ']}]}]}' : '';
          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_region        = $row["region"];
          $old_user          = $row["profile_id"];
        }
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Vicharan planned by date
  public static function plannedDates(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RCL){
      $where = $Session->filter_query("v.date>='".date('Y-m-d')."'", '', 'pf', '', 'v', 'v');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q="SELECT pf.gender, pf.mandal, pf.region AS user_region, CONCAT_WS(' ',pf.first_name,pf.last_name) AS name, (SELECT region FROM ".DB_PREFIX."centers WHERE center=v.center) AS region, v.center, v.sabha_type, v.date
      FROM ".DB_PREFIX."vicharans AS v LEFT JOIN ".DB_PREFIX."profiles AS pf ON pf.profile_id=v.profile_id 
      $where 
      ORDER BY gender DESC, mandal, v.date, name, region, center";
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=0;
        $old_gender_mandal=$old_date='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];
          // Mandal
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","dates":[';
            $b++;
            $c=$d=0;
            $old_date='';
          }
          // Region
          if($old_date!=$row["date"]){
            $output .= ($c>0) ? ']},' : '';
            $output .= '{"date":"'.$Core->format_datetime($row["date"],"M d, Y").'","users":[';
            $c++;
            $d=0;
          }
          $output .= ($d>0) ? ',' : '';
          $d++;

          $output .= '{
            "user_region":"'.$row["user_region"].'",
            "name":"'.$row["name"].'",
            "region":"'.$row["region"].'",
            "center":"'.$row["center"].'",
            "sabha_type":"'.$row["sabha_type"].'"
          }';
          
          $output           .= ($a==(count($result)-1)) ? ']}]}' : '';
          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_date          = $row["date"];
        }
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Profiles
  public static function profiles(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RCL){
      $where = $Session->filter_query('', '', 'pf', 'pf', 'pf', 'pf');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q = "SELECT gender, mandal, region, center, CONCAT_WS(' ',first_name,last_name) AS name, user_level, profile_id 
      FROM ".DB_PREFIX."profiles as pf
      $where 
      ORDER BY gender DESC, mandal, region, user_level, name";
      
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=0;
        $old_gender_mandal=$old_region='';
        for($a=0; $a<count($result); $a++){
          $row = $result[$a];
          // Mandal
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","regions":[';
            $b++;
            $c=$d=0;
            $old_region='';
          }
          // Region
          if($old_region!=$row["region"]){
            $output .= ($c>0) ? ']},' : '';
            $output .= '{"region":"'.$row["region"].'","users":[';
            $c++;
            $d=0;
          }
          $output .= ($d>0) ? ',' : '';
          $d++;
          $output .= '{
            "name":"'.$row["name"].'",
            "user_level":'.$row["user_level"].',
            "id":"'.$row["profile_id"].'"
          }';
          $output           .= ($a==(count($result)-1)) ? ']}]}' : '';
          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_region        = $row["region"];
        }
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Projects
  public static function projects(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    $where  = $Session->filter_gender_mandal('', '', 'p');
    $where = !empty($where) ? 'WHERE '.$where : '';

    $q = "SELECT p.gender, p.mandal, p.year, (SELECT name FROM ".DB_PREFIX."lists WHERE list_id=p.project_list_id) AS project_name, p.part_of_10_goals, p.measure, p.goal_a, p.goal_b, p.goal_c, (SELECT region FROM ".DB_PREFIX."centers WHERE center=pd.center) AS region, pd.center, pd.actual, p.goal_common, p.project_list_id, p.project_id, pd.project_detail_id 
    FROM ".DB_PREFIX."projects AS p LEFT JOIN ".DB_PREFIX."project_details AS pd ON p.project_id=pd.project_id 
    $where 
    ORDER BY gender DESC, mandal, p.year DESC, project_name, center";
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      $b=$c=$d=$e=0;
      $old_gender_mandal=$old_year=$old_project=$projects_name=$projects_value='';

      for ($a=0; $a<count($result); $a++){ 
        $row = $result[$a];
        // Mandal
        if($old_gender_mandal!=$row["gender"].$row["mandal"]){
          $output .= ($b>0) ? ']},{"name":['.$projects_name.'],"value":['.$projects_value.']}]}]},' : '';
          $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","years":[';
          $b++;
          $c=$d=$e=0;
          $old_year=$old_project=$projects_name=$projects_value='';
        }
        // Year
        if($old_year!=$row["year"]){
          $output .= ($c>0) ? ']},{"name":['.$projects_name.'],"value":['.$projects_value.']}]},' : '';
          $output .= '{"year":"'.$row["year"].'","projects":[';
          $c++;
          $d=$e=0;
          $projects_name=$projects_value=$old_project='';
        }
        // Project
        if($old_project!=$row["project_id"]){
          $projects_name  .= ($d>0) ? ',' : '';
          $projects_value .= ($d>0) ? ',' : '';
          $output         .= ($d>0) ? ']},' : '';
          $output .= '{
            "id":"'.$row["project_id"].'",
            "name":"'.$row["project_name"].'",
            "project_id":"'.$row["project_list_id"].'",
            "part_of_10_goals":"'.$row["part_of_10_goals"].'",
            "measure":"'.$row["measure"].'",
            "goal_a":"'.$row["goal_a"].'",
            "goal_b":"'.$row["goal_b"].'",
            "goal_c":"'.$row["goal_c"].'",
            "goal_common":"'.$row["goal_common"].'",
            "year":"'.$row["year"].'",
            "details":[
          ';
          $d++;
          $e=0;
          $projects_name  .= '"'.$row["project_name"].'"';
          $projects_value .= '"'.$row["project_id"].'"';
        }
        // details
        $output .= ($e>0) ? ',' : '';
        $e++;
        $output .= '{
          "detail_id":"'.$row["project_detail_id"].'",
          "region":"'.$row["region"].'",
          "center":"'.$row["center"].'",
          "actual":"'.(empty($row["actual"]) ? "N/A" : $row["actual"]).'"
        }';

        $output           .= ($a==(count($result)-1)) ? ']},{"name":['.$projects_name.'],"value":['.$projects_value.']}]}]}' : '';
        $old_project       = $row['project_id'];
        $old_year          = $row['year'];
        $old_gender_mandal = $row['gender'].$row['mandal'];
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Projects 2016
  public static function projects16(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    $where  = $Session->filter_gender_mandal('', '', 'goal');
    $where = !empty($where) ? 'WHERE '.$where : '';

    $q = sprintf("SELECT goal.goal_id, goal.list_id, goal.gender, goal.mandal, goal.year, (SELECT name FROM %slists WHERE list_id=goal.list_id) AS goal_name, goal.goal_category, goal.goal_description, goal.goal_metric, goal.goal_metric_max 
    FROM %scenter_analysis_16_goals AS goal
    $where 
    ORDER BY goal.gender DESC, goal.mandal, goal.year DESC, goal_name", DB_PREFIX, DB_PREFIX);
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      $b=$c=$d=0;
      $old_gender_mandal=$old_year='';

      for ($a=0; $a<count($result); $a++){ 
        $row = $result[$a];
        // Mandal
        if($old_gender_mandal!=$row["gender"].$row["mandal"]){
          $output .= ($b>0) ? ']}]},' : '';
          $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'","years":[';
          $b++;
          $old_year='';
          $c=$d=0;
        }

        if($old_year!=$row['year']){
          $output .= ($c>0) ? ']},' : '';
          $output .= '{"year":"'.$row["year"].'", "goals":[';
          $c++;
          $d=0;
        }

        $output .= ($d>0) ? ',' : '';
        $d++;
        $output .= '{
          "goal_id": '.$row["goal_id"].',
          "list_id": '.$row["list_id"].',
          "goal_name": "'.$row["goal_name"].'",
          "goal_category": "'.$row["goal_category"].'",
          "goal_description": "'.$row["goal_description"].'",
          "goal_metric": "'.$row["goal_metric"].'",
          "goal_metric_max": "'.$row["goal_metric_max"].'",
          "year": '.$row["year"].',
          "gender": "'.$row["gender"].'",
          "mandal": "'.$row["mandal"].'"
        }';

        $output           .= ($a==(count($result)-1)) ? ']}]}' : '';
        $old_gender_mandal = $row["gender"].$row["mandal"];
        $old_year          = $row['year'];

      }
    }
    return '['.$output.']';
  }
  
  /* ********** ********** ********** **********  **********  ********** */
  // Projects details
  public static function projectsDetails($mandal, $year, $center, $full_summary=NULL){
    global $Database, $Session, $Core, $Logs;
    /* // Note //
    If center is empty then function will export all the center with every comment by all users
    */
    $message = '';
    $where   = '';
    $row     = '';
    $output  = array();
    $year    = empty($year) ? date('Y') : $year;
    $full_summary = NULL;
    // for full summary show data base on filter.
    if($full_summary===true){
      $where = $Session->filter_gender_mandal("p.year='$year'", '', 'p');
      $where = $Session->filter_region_center($where, '', 'pd', 'pd');
    }
    // show data only base on passed param 
    else{
      $mandal = $Core->gender_mandal($mandal);
      $gender = $mandal['gender'];
      $mandal = $mandal['mandal'];
      $by_who = ($Session->user_level==UL_SANCHALAK) ? 2 : 1;
    }

    $q = "SELECT gender, mandal, year, region, ca_center AS center, by_who, project_id, project_name, project_detail_id, measure, 
      (CASE 
        WHEN ((mandal='B' && bm='A') || (mandal='K' && km='A')) THEN goal_a 
        WHEN ((mandal='B' && bm='B') || (mandal='K' && km='B')) THEN goal_b 
        ELSE goal_c 
      END) AS goal, 
      ca_comment, 
      IF(challenges IS NULL, 'N/A', challenges) AS challenges, 
      (CASE WHEN ca_comment=1 THEN ca_people_to_focus WHEN pd_people_to_focus<>'' THEN pd_people_to_focus ELSE NULL END) AS people_to_focus, 
      (CASE WHEN ca_comment=1 THEN ca_plan_to_help    WHEN pd_plan_to_help<>''    THEN pd_plan_to_help    ELSE NULL END) AS plan_to_help, 
      (CASE WHEN ca_comment=1 THEN ca_santo_help      WHEN pd_santo_help<>''      THEN pd_santo_help      ELSE NULL END) AS santo_help, 
      (CASE WHEN ca_comment=1 THEN IF(ca_jan>0, 'Y', NULL) WHEN pd_jan>0 THEN 'Y' ELSE NULL END) AS jan,
      (CASE WHEN ca_comment=1 THEN IF(ca_feb>0, 'Y', NULL) WHEN pd_feb>0 THEN 'Y' ELSE NULL END) AS feb,
      (CASE WHEN ca_comment=1 THEN IF(ca_mar>0, 'Y', NULL) WHEN pd_mar>0 THEN 'Y' ELSE NULL END) AS mar,
      (CASE WHEN ca_comment=1 THEN IF(ca_apr>0, 'Y', NULL) WHEN pd_apr>0 THEN 'Y' ELSE NULL END) AS apr,
      (CASE WHEN ca_comment=1 THEN IF(ca_may>0, 'Y', NULL) WHEN pd_may>0 THEN 'Y' ELSE NULL END) AS may,
      (CASE WHEN ca_comment=1 THEN IF(ca_jun>0, 'Y', NULL) WHEN pd_jun>0 THEN 'Y' ELSE NULL END) AS jun,
      (CASE WHEN ca_comment=1 THEN IF(ca_jul>0, 'Y', NULL) WHEN pd_jul>0 THEN 'Y' ELSE NULL END) AS jul,
      (CASE WHEN ca_comment=1 THEN IF(ca_aug>0, 'Y', NULL) WHEN pd_aug>0 THEN 'Y' ELSE NULL END) AS aug,
      (CASE WHEN ca_comment=1 THEN IF(ca_sep>0, 'Y', NULL) WHEN pd_sep>0 THEN 'Y' ELSE NULL END) AS sep,
      (CASE WHEN ca_comment=1 THEN IF(ca_oct>0, 'Y', NULL) WHEN pd_oct>0 THEN 'Y' ELSE NULL END) AS oct,
      (CASE WHEN ca_comment=1 THEN IF(ca_nov>0, 'Y', NULL) WHEN pd_nov>0 THEN 'Y' ELSE NULL END) AS nov,
      (CASE WHEN ca_comment=1 THEN IF(ca_dec>0, 'Y', NULL) WHEN pd_dec>0 THEN 'Y' ELSE NULL END) AS `dec`
      FROM (
        SELECT p.project_id, p.gender, p.mandal, p.year, IF(ca.center IS NULL, '$center', ca.center) AS ca_center, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ca_center) as region, (SELECT bm FROM ".DB_PREFIX."centers WHERE center=ca_center) AS bm, (SELECT km FROM ".DB_PREFIX."centers WHERE center=ca_center) AS km, ca.by_who, (SELECT name FROM ".DB_PREFIX."lists WHERE list_id=p.project_list_id) AS project_name, project_detail_id, part_of_10_goals, measure, goal_a, goal_b, goal_c,  

        GROUP_CONCAT(ca.challenge SEPARATOR \",\n\") AS challenges, 
        GROUP_CONCAT(CONCAT(ca.challenge, ': ', IF(ca.people_to_focus IS NULL, 'N/A', ca.people_to_focus)) SEPARATOR \";\n\") AS ca_people_to_focus, 
        GROUP_CONCAT(CONCAT(ca.challenge, ': ', IF(ca.plan_to_help IS NULL, 'N/A', ca.plan_to_help)) SEPARATOR \";\n\") AS ca_plan_to_help, 
        GROUP_CONCAT(CONCAT(ca.challenge, ': ', IF(ca.santo_help IS NULL, 'N/A', ca.santo_help)) SEPARATOR \";\n\") AS ca_santo_help,

        IF((
          GROUP_CONCAT(CONCAT(ca.challenge, ca.people_to_focus) SEPARATOR '')<>'' || 
          GROUP_CONCAT(CONCAT(ca.challenge, ca.plan_to_help)    SEPARATOR '')<>'' || 
          GROUP_CONCAT(CONCAT(ca.challenge, ca.santo_help)      SEPARATOR '')<>''
        ), 1, NULL) AS ca_comment,

        pd.people_to_focus AS pd_people_to_focus, pd.plan_to_help AS pd_plan_to_help, pd.santo_help AS pd_santo_help,

        COUNT(ca.jan) AS ca_jan, COUNT(ca.feb) AS ca_feb, COUNT(ca.mar) AS ca_mar, COUNT(ca.apr) AS ca_apr, COUNT(ca.may) AS ca_may, COUNT(ca.jun) AS ca_jun, COUNT(ca.jul) AS ca_jul, COUNT(ca.aug) AS ca_aug, COUNT(ca.sep) AS ca_sep, COUNT(ca.oct) AS ca_oct, COUNT(ca.nov) AS ca_nov, COUNT(ca.`dec`) AS ca_dec, COUNT(pd.jan) AS pd_jan,COUNT(pd.feb) AS pd_feb,COUNT(pd.mar) AS pd_mar,COUNT(pd.apr) AS pd_apr,COUNT(pd.may) AS pd_may,COUNT(pd.jun) AS pd_jun,COUNT(pd.jul) AS pd_jul,COUNT(pd.aug) AS pd_aug,COUNT(pd.sep) AS pd_sep,COUNT(pd.oct) AS pd_oct,COUNT(pd.nov) AS pd_nov,COUNT(pd.`dec`) AS pd_dec

        FROM ".DB_PREFIX."projects AS p LEFT JOIN (
          SELECT gender, mandal, year, (SELECT region FROM ".DB_PREFIX."centers WHERE center=ca.center) as region, center, by_who, project_id, challenge, people_to_focus, plan_to_help, santo_help, jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, `dec` 
          FROM ".DB_PREFIX."center_analysis_details as cad LEFT JOIN ".DB_PREFIX."center_analysis as ca ON cad.center_analysis_id=ca.center_analysis_id
          WHERE gender='$gender' AND mandal='$mandal' AND year='$year' AND center='$center' AND by_who='$by_who'
        ) AS ca ON p.project_id = ca.project_id AND p.gender = ca.gender AND p.mandal = ca.mandal AND p.year = ca.year LEFT JOIN(
          SELECT gender, mandal, year, (SELECT region FROM ".DB_PREFIX."centers WHERE center=pd.center) as region, center, by_who, project_id, project_detail_id, people_to_focus, plan_to_help, santo_help, jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, `dec` 
          FROM ".DB_PREFIX."project_details as pd 
          WHERE gender='$gender' AND mandal='$mandal' AND year='$year' AND center='$center' AND by_who='$by_who'
        ) AS pd ON p.project_id = pd.project_id AND p.gender = pd.gender AND p.mandal = pd.mandal AND p.year = pd.year 
        WHERE p.gender='$gender' AND p.mandal='$mandal' AND p.year='$year' AND p.part_of_10_goals='Y' 
        GROUP BY p.gender, p.mandal, p.year, region, ca_center, by_who, p.project_id
        ORDER BY p.gender, p.mandal, p.year, region, ca_center, p.project_id, by_who
      ) AS a
    ";

    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      for($a=0; $a<count($result); $a++){
        $row = $result[$a];
        $row["progress"] = (!empty($row["people_to_focus"]) || !empty($row["plan_to_help"]) || !empty($row["santo_help"])) ? 1 : NULL;
        // update the database only when $summary is not true and project_detail_id is not empty (cus we need to update the db) and db was update
        if(
          $full_summary===NULL && 
          !empty($row["project_detail_id"]) && 
          !$Database->update(
            array(__LINE__, __METHOD__, __FILE__), 
            // table
            DB_PREFIX.'project_details', 
            // set
            array(
              "people_to_focus"   => $row["people_to_focus"], 
              "plan_to_help"      => $row["plan_to_help"], 
              "santo_help"        => $row["santo_help"], 
              "jan"               => $row["jan"], 
              "feb"               => $row["feb"], 
              "mar"               => $row["mar"], 
              "apr"               => $row["apr"], 
              "may"               => $row["may"], 
              "jun"               => $row["jun"], 
              "jul"               => $row["jul"], 
              "aug"               => $row["aug"], 
              "sep"               => $row["sep"], 
              "oct"               => $row["oct"], 
              "nov"               => $row["nov"], 
              "`dec`"             => $row["dec"],
              "progress"          => $row["progress"], // to see if user enter anyone of the comment
              "ca_comment"        => $row["ca_comment"], // to see if comment is from center analysis or from project
              "update_datetime"   => $Core->datetime,
              "update_profile_id" => $Session->profile_id
            ),
            // where
            array("project_detail_id" => $row["project_detail_id"])
          )
        ){
          $message .= $Core->error_message('Error updating '.$row["project_detail_id"], __FILE__, __LINE__, $Database->error());
        }
        // add in the database
        else if(
          $full_summary===NULL &&
          empty($row["project_detail_id"]) && 
          !empty($row["challenges"]) && 
          !$Database->add_project_detail(array(__LINE__, __METHOD__, __FILE__), $row["center"], $row["project_id"], $row["year"], $row["mandal"], $row["gender"], $row["by_who"], $row["people_to_focus"], $row["plan_to_help"], $row["santo_help"], $row["jan"], $row["feb"], $row["mar"], $row["apr"], $row["may"], $row["jun"], $row["jul"], $row["aug"], $row["sep"], $row["oct"], $row["nov"], $row["dec"], $Session->profile_id, $row["progress"], $row["ca_comment"])
        ){
          $message .= $Core->error_message('Error adding '.$row["project_detail_id"], __FILE__, __LINE__, $Database->error());
        }
        // get new project detail id
        else if(empty($row["project_detail_id"])){
          $row["project_detail_id"] = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'project_detail_id', DB_PREFIX.'project_details', "center='".$row["center"]."' AND year='".$row["year"]."' AND mandal='".$row["mandal"]."' AND gender='".$row["gender"]."' AND by_who='".$row["by_who"]."' AND project_id='".$row["project_id"]."'");
        }

        $output[$a] = array(
          "gender"               => $row["gender"],
          "mandal"               => $row["mandal"],
          "year"                 => $row["year"],
          "center"               => $row["center"],
          "by_who"               => $row["by_who"],
          "id"                   => $row["project_detail_id"],
          "project_id"           => $row["project_id"],
          "project_name"         => $row["project_name"],
          "measure"              => $row["measure"],
          "goal"                 => $row["goal"],
          "actual"               => (empty($row["actual"]) ? "N/A" : $row["actual"]),
          "addressing_challenge" => $row["challenges"],
          "ca_comment"           => $row["ca_comment"],
          "people_to_focus"      => $row["people_to_focus"],
          "plan_to_help"         => $row["plan_to_help"],
          "santo_help"           => $row["santo_help"],
          "months"               => array($row["jan"], $row["feb"], $row["mar"], $row["apr"], $row["may"], $row["jun"], $row["jul"], $row["aug"], $row["sep"], $row["oct"], $row["nov"], $row["dec"])
        );
      }
    }
    return $output;
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Region and center
  public static function regionCenter(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    $where  = $Session->filter_region_center('','','','');
    $where = !empty($where) ? 'WHERE '.$where : '';

    $q      = "SELECT * FROM ".DB_PREFIX."centers $where ORDER BY region, center";
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      $b=$c=0;
      $old_region='';
      for($a=0; $a<count($result); $a++){
        $row = $result[$a];
        // Region
        if($old_region!=$row["region"]){
          $output .= ($b>0) ? ']},' : '';
          $output .= '{"region":"'.$row["region"].'","centers":[';
          $b++;
          $c=0;
        }
        $output .= ($c>0) ? ',' : '';
        $c++;

        $output .= '{
          "name":"'.$row["center"].'",
          "bm":"'.$row["bm"].'",
          "km":"'.$row["km"].'",
          "bst":"'.$row["bst"].'",
          "kst":"'.$row["kst"].'",
          "campus":"'.$row["campus"].'",
          "goshti":"'.$row["goshti"].'",
          "lam":"'.$row["lam"].'",
          "id":"'.$row["center_id"].'"
        }';
        
        $output .= ($a==(count($result)-1)) ? ']}' : '';
        $old_region=$row["region"];
      }
    }
    return '['.$output.']';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Select
  public static function select(){
    global $Database, $Session, $Core, $Logs;

    $output = '
      "user_level_name":["Site Admin","National Sant","National RC Lead","Regional Lead Sant/RMC","Regional Lead RC","Regional Admin","Vicharan Sant","RC","Sanchalak/Sanchalik"],
      "user_level_value":[101,102,103,104,105,106,107,108,109],
      "user_level":{"admin":101, "na_sant":102, "na_rc":103, "rcl_sant":104, "rcl":105, "ra":106, "rc_sant":107, "rc":108, "sanchalak":109},
      "region":["Canada","Midwest","Northeast","Southeast","Southwest","West"],
      "sabha_type":["BM Sabha","BST","KM Sabha","KST","Campus Sabha","Goshti","LAM"],
      "gender_name":["Male","Female"],
      "gender_value":["M","F"],
      "mandal_name":["Bal/Balika","Kishore/Kishori","P. Sant/RMC"],
      "mandal_value":["B","K","C"],
      "status_name":["None","A","B","C","R"],
      "status_value":["","A","B","C","R"],
      "other_option_id":['.$Core->select_option('Other Option','list_id').'],
      "other_option":['.$Core->select_option('Other Option','name').'],
      "projects_list_id":['.$Core->select_option('Projects','list_id').'],
      "projects_list":['.$Core->select_option('Projects','name').']
    ';
    
    /* Region and Center array */
    $output .= ',"region_center":[';
    $q = "SELECT * FROM ".DB_PREFIX."centers ORDER BY region, center";
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      $b=0;
      $c=0;
      $old_region = '';
      for($a=0; $a<count($result); $a++){
        $row = $result[$a];

        if($old_region!=$row["region"]){
          $output .= ($b>0) ? ']},' : '';
          $output .= '{"region":"'.$row["region"].'","centers":[';
          $b++;
          $c=0;
        }
        $output .= ($c>0) ? ',' : '';
        $output .= '{
          "name":"'.$row["center"].'",
          "bm":"'.$row["bm"].'",
          "km":"'.$row["km"].'",
          "bst":"'.$row["bst"].'",
          "kst":"'.$row["kst"].'",
          "campus":"'.$row["campus"].'",
          "goshti":"'.$row["goshti"].'",
          "lam":"'.$row["lam"].'",
          "id":"'.$row["center_id"].'"
        }';
        $c++;
        
        $output .= ($a==(count($result)-1)) ? ']}' : '';
        $old_region=$row["region"];
      }
    }
    $output.=']';
    return '{'.$output.'}';
  }
  
  /* ********** ********** ********** **********  **********  ********** */
  // Session
  public static function session(){
    global $Database, $Session, $Core, $Logs;

    // Assign Center
    $q = "SELECT c.region, c.center, c.bm, c.km, c.bst, c.kst, c.campus, c.goshti, c.lam 
    FROM ".DB_PREFIX."assign_centers AS ac LEFT JOIN ".DB_PREFIX."centers AS c ON ac.center=c.center
    WHERE profile_id='$Session->profile_id' 
    ORDER BY c.region, c.center";

    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    $assign_center = '';
    for($a=0; $a<count($result); $a++){
      $row = $result[$a];
      $assign_center .= ($a>0) ? ',' : '';
      $assign_center.='{
        "name":"'.$row["center"].'",
        "bm":"'.$row["bm"].'",
        "km":"'.$row["km"].'",
        "bst":"'.$row["bst"].'",
        "kst":"'.$row["kst"].'",
        "campus":"'.$row["campus"].'",
        "goshti":"'.$row["goshti"].'",
        "lam":"'.$row["lam"].'"
      }';
    }

    // check if user is using auto password
    $db_password = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'password',DB_PREFIX.'profiles', "profile_id='$Session->profile_id'");
    $auto_pass   = ($db_password==md5(strtolower($Session->first_name.$Session->last_name))) ? 'Y' : 'N';
    
    return '{
      "sid":"'.$Session->session_id.'",
      "uid":"'.$Session->profile_id.'",
      "acronym":"'.ucwords(substr($Session->first_name,0,1)).ucwords(substr($Session->last_name,0,1)).'",
      "fn":"'.$Session->first_name.'",
      "ln":"'.$Session->last_name.'",
      "gender":"'.$Session->gender.'",
      "mandal":"'.$Session->mandal.'",
      "mandal_full":"'.$Core->mandal_name($Session->gender, $Session->mandal).'",
      "e":"'.$Session->email.'",
      "ul":'.$Session->user_level.',
      "region":"'.$Session->region.'",
      "center":"'.$Session->center.'",
      "setup":'.$Session->setup.',
      "auto_pass":"'.$auto_pass.'",
      "assign_center":['.$assign_center.'],
      "syncTime":"'.$Core->format_datetime($Core->datetime).'"
    }';
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Vicharan Notes
  public static function vicharanNotes(){
    global $Database, $Session, $Core, $Logs;

    $output = '';
    if($Session->user_level<=UL_RC && $Session->user_level!=UL_RA){
      $where = $Session->filter_query("(sabha_type<>'' OR sabha_type IS NOT NULL) AND (SELECT region FROM ".DB_PREFIX."centers WHERE center=vn.center) IS NOT NULL", '', 'pf', '', 'vn', 'vn');
      $where = !empty($where) ? 'WHERE '.$where : '';

      $q="SELECT pf.gender, pf.mandal, CONCAT_WS(' ',pf.first_name,pf.last_name) AS name, (SELECT region FROM ".DB_PREFIX."centers WHERE center=vn.center) AS region, vn.center, vn.sabha_type, vn.positive_points, vn.issues, vn.follow_up_list, vn.other_comment, vn.post_datetime, vn.vicharan_note_id, vn.profile_id 
      FROM ".DB_PREFIX."vicharan_notes as vn LEFT JOIN ".DB_PREFIX."profiles as pf ON vn.profile_id=pf.profile_id 
      $where 
      ORDER BY gender DESC, mandal, region, center, vn.sabha_type, post_datetime DESC";
      
      $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        $b=$c=$d=$e=$f=0;
        $old_gender_mandal=$old_region=$old_center=$old_sabha_type='';

        for($a=0; $a<count($result); $a++){
          $row = $result[$a];
          $row["region"]     = empty($row["region"]) ? 'Other' : $row["region"];
          $row["sabha_type"] = empty($row["sabha_type"]) ? 'Unknown' : $row["sabha_type"];
          // Group
          if($old_gender_mandal!=$row["gender"].$row["mandal"]){
            $output .= ($b>0) ? ']}]}]}]},' : '';
            $output .= '{"mandal":"'.$Core->mandal_name($row["gender"],$row["mandal"]).'", "regions":[';
            $b++;
            $c=$d=$e=$f=0;
            $old_region=$old_center=$old_sabha_type='';
          }
          // Region
          if($old_region!=$row["region"]){
            $output .= ($c>0) ? ']}]}]},' : '';
            $output .= '{"region":"'.$row["region"].'","centers":[';
            $c++;
            $d=$e=$f=0;
            $old_center=$old_sabha_type='';
          }
          // Center
          if($old_center!=$row["center"]){
            $output .= ($d>0) ? ']}]},' : '';
            $output .= '{"center":"'.$row["center"].'","sabha_types":[';
            $d++;
            $e=$f=0;
            $old_sabha_type='';
          }
          // Mandal
          if($old_sabha_type!=$row["sabha_type"]){
            $output .= ($e>0) ? ']},' : '';
            $output .= '{"sabha_type":"'.$row["sabha_type"].'","comments":[';
            $e++;
            $f=0;
          }
          $output .= ($f>0) ? ',' : '';
          $f++;
          
          $row['positive_points'] = empty($row['positive_points']) ? '' : $Core->html_decode($row['positive_points']);
          $row['issues']          = empty($row['issues']) ? '' : $Core->html_decode($row['issues']);
          $row['follow_up_list']  = empty($row['follow_up_list']) ? '' : $Core->html_decode($row['follow_up_list']);
          $row['other_comment']   = empty($row['other_comment']) ? '' : $Core->html_decode($row['other_comment']);

          $output .= '{
            "id":"'.$row["vicharan_note_id"].'",
            "name":"'.$row["name"].'",
            "positive_points":"'.$row["positive_points"].'",
            "issues":"'.$row["issues"].'",
            "follow_up_list":"'.$row["follow_up_list"].'",
            "other_comment":"'.$row["other_comment"].'",
            "date":"'.$Core->format_datetime($row["post_datetime"],"M, d Y").'",
            "datetime":"'.$Core->format_datetime($row["post_datetime"]).'"
          }';
          
          $output .= ($a==(count($result)-1)) ? ']}]}]}]}' : '';

          $old_gender_mandal = $row["gender"].$row["mandal"];
          $old_region        = $row["region"];
          $old_center        = $row["center"];
          $old_sabha_type    = $row["sabha_type"];
        }
      }
    }
    return '['.$output.']';
  }

} // end of class Sync
?>