<?php
/* ********** ********** ********** **********  **********  ********** */
// Email Class
/* ********** ********** ********** **********  **********  ********** */
class Email{

  /* ********** ********** ********** **********  **********  ********** */
  // delever email - here we use PHP mail function to send the email out to user
  public static function delevery($email, $subject, $message){
    if(SITE=='local'){$return = 1;}
    else{
      $header = "From: RC Vicharan <no-reply@na.baps.org>\r\n";
      $header.= "Content-Type: text/html\r\n";

      $return = mail($email, $subject, $message, $header);
    }
    return $return;
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Process email - send email which are not send
  public static function process(){
    global $Database, $Core, $Logs;
    $q      = "SELECT email_id, email, subject, message FROM ".DB_PREFIX."emails WHERE sent IS NULL AND post_datetime<='$Core->datetime' LIMIT 200";
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      for($a=0; $a<count($result); $a++){
        $row  = $result[$a];
        $mail = self::delevery($row["email"], $row["subject"], $row["message"]);
        // mail is sent then mark it as sent
        if($mail==1){
          $Database->update(
            array(__LINE__, __METHOD__, __FILE__),
            DB_PREFIX.'emails', 
            array("sent" => 1, "update_datetime" => $Core->datetime),
            array("email_id" => $row["email_id"])
          );
        }
      }
    }
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Send reminder if RC didn't check-in over weekend
  public static function check_in_reminder(){
    global $Database, $Core, $Logs;
    if(date('D')=='Mon'){
      $date_start = date('Y-m-d', strtotime('-2 day'));
      $date_end   = date('Y-m-d', strtotime('-1 day'));
      $q          = sprintf("SELECT z.email_id, z.profile_id, z.name, z.email, z.region, z.center, z.sabha_type, z.date, z.format_date, z.check_in_id FROM (
                      SELECT SUBSTRING(MD5(CONCAT('check-in-reminder-', v.date, v.profile_id, v.center)), 1, 10) AS email_id, v.profile_id, CONCAT_WS(' ', pf.first_name, pf.last_name) as name, pf.email, (SELECT region FROM %scenters WHERE center=v.center) AS region, v.center, v.sabha_type, v.date, DATE_FORMAT(v.date, '%b %d, %Y') AS format_date, v.check_in_id 
                      FROM %svicharans as v LEFT JOIN %sprofiles as pf ON v.profile_id=pf.profile_id) AS z LEFT JOIN %semails AS em ON z.email_id=em.email_id 
                    WHERE em.email_id IS NULL AND check_in_id IS NULL AND date BETWEEN '$date_start' AND '$date_end'
                    ORDER BY region, center, date, name", DB_PREFIX, DB_PREFIX, DB_PREFIX, DB_PREFIX);
      $result     = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        for($a=0; $a<count($result); $a++){
          $row     = $result[$a];
          $subject = 'Did you forget to check in over the weekend?';
          $message = 'Jay Swaminarayan '.$row["name"].'!,<br><br>
          Our records indicate that you have not checked in at <strong>'.$row["center"].'('.$row["sabha_type"].')</strong> on <strong>'.$row["format_date"].'</strong>. If you forgot to check in, please visit <a href="'.SITE_URL.'#check-in/">'.SITE_URL.'#check-in/</a> to check-in.';
          // save the mail in database
          $Database->add_email(array(__LINE__, __METHOD__, __FILE__), $row['email_id'], 'eccd8c0dde', $row['profile_id'], $row['email'], $subject, $message, date('Y-m-d').' 11:00:00');
        }
      }
    }
  }

  /* ********** ********** ********** **********  **********  ********** */
  // upcoming vicharan - Send reminder to RC for upcoming vicharan
  public static function upcoming_vicharan(){
    global $Database, $Core, $Logs;
    $date   = date('Y-m-d',strtotime('+5 day'));
    $q      = "SELECT z.email_id, z.profile_id, z.name, z.email, z.region, z.center, z.sabha_type, z.date, z.format_date, z.check_in_id FROM (
                SELECT SUBSTRING(MD5(CONCAT('upcoming-vicharan-', v.date, v.profile_id, v.center)), 1, 10) AS email_id, v.profile_id, CONCAT_WS(' ', pf.first_name, pf.last_name) as name, pf.email, (SELECT region FROM ".DB_PREFIX."centers WHERE center=v.center) AS region, v.center, v.sabha_type, v.date, DATE_FORMAT(v.date, '%b %d, %Y') AS format_date, v.check_in_id 
                FROM ".DB_PREFIX."vicharans as v LEFT JOIN ".DB_PREFIX."profiles as pf ON v.profile_id=pf.profile_id) AS z LEFT JOIN ".DB_PREFIX."emails AS em ON z.email_id=em.email_id 
              WHERE em.email_id IS NULL AND check_in_id IS NULL AND date='$date' 
              ORDER BY region, center, date, name";
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      for($a=0; $a<count($result); $a++){
        $row     = $result[$a];

        $subject = 'Vicharan Reminder';
        $message = 'Jay Swaminarayan '.$row["name"].'!,<br><br>
        This is an automated reminder. You have scheduled a visit to <strong>'.$row["center"].'('.$row["sabha_type"].')</strong> on <strong>'.$row["format_date"].'</strong>.<br><br>
        Enjoy your visit!';
        // save the mail in database
        $Database->add_email(array(__LINE__, __METHOD__, __FILE__), $row['email_id'], 'eccd8c0dde', $row['profile_id'], $row['email'], $subject, $message, date('Y-m-d').' 16:00:00');
      }
    }
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Send reminder if RC didn't plan vicharan over weekend
  public static function plan_vicharan_reminder(){
    global $Database, $Core, $Logs;
    if(date('D')=='Wed'){
      $date_start = date('Y-m-d',strtotime('+3 day'));
      $date_end   = date('Y-m-d',strtotime('+4 day'));
      $q          = sprintf("SELECT z.email_id, z.profile_id, z.name, z.email FROM (
                      SELECT SUBSTRING(MD5(CONCAT('vicharan-reminder-', profile_id, $date_start)), 1, 10) AS email_id, profile_id, CONCAT_WS(' ', first_name, last_name) as name, email, (SELECT count(vicharan_id) FROM %svicharans WHERE profile_id=pf.profile_id AND (date BETWEEN '$date_start' AND '$date_end')) AS vicharan
                      FROM %sprofiles as pf 
                      WHERE active='Y' AND (user_level BETWEEN %d AND %d)
                      ORDER BY gender DESC, mandal, region, center, name) AS z LEFT JOIN %semails AS em ON z.email_id=em.email_id 
                    WHERE em.email_id IS NULL AND z.vicharan=0
                    LIMIT 10000", DB_PREFIX, DB_PREFIX, UL_NA_SANT, UL_RC, DB_PREFIX);
      $result     = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

      if(count($result)>0){
        for($a=0; $a<count($result); $a++){
          $row     = $result[$a];

          $subject = 'Vicharan plans for this weekend is missing';
          $message = 'Jay Swaminarayan '.$row["name"].'!,<br><br>
          We&#39;ve noticed that you haven&#39;t made any vicharan plans for this weekend. Please log into <a href="'.SITE_URL.'#my-vicharan/">'.SITE_URL.'#my-vicharan/</a> as soon as possible to plan your mandal visits for this weekend. If you&#39;re not making any mandal visits or not attending any meetings/shibirs this weekend, please be sure to select &#34;Personal&#34; for this Saturday/Sunday.<br><br>Thanks!';
          // save the mail in database
          $Database->add_email(array(__LINE__, __METHOD__, __FILE__), $row['email_id'], 'eccd8c0dde', $row['profile_id'], $row['email'], $subject, $message, date('Y-m-d').' 10:00:00');
        }
      }
    }
  }

  /* ********** ********** ********** **********  **********  ********** */
  public static function centerAnalysis16Update($gender, $mandal, $full_name, $region, $center){
    global $Database, $Core, $Logs;

    $q = sprintf("SELECT z.email_id, z.profile_id, z.name, z.email FROM (
      SELECT SUBSTRING(MD5(CONCAT('center-analysis-16-update-', pf.profile_id, '$center')), 1, 10) AS email_id, pf.profile_id, CONCAT_WS(' ', pf.first_name, pf.last_name) as name, pf.email, pf.active, pf.user_level, pf.gender, pf.mandal  
      FROM %sprofiles AS pf) as z 
      LEFT JOIN %semails as em ON em.email_id = z.email_id
      WHERE z.active = 'Y' AND z.user_level = 103 AND z.gender = '$gender' AND z.mandal = '$mandal' AND em.email_id IS NULL", DB_PREFIX, DB_PREFIX);
    
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);

    if(count($result)>0){
      $mandal_name = $Core->mandal_name($gender, $mandal);
      $subject = 'Center Analysis Update';
      for ($i=0; $i < count($result); $i++) { 
        $row = $result[$i];

        $message = 'Jay Swaminarayan '.$row["name"].',<br><br>
        This is a notification that '.$mandal_name.' RC '.$full_name.' has completed the center analysis for '.$region.' '.$center.'.<br><br>
        Please log into <a href="'.SITE_URL.'#center-analysis/">'.SITE_URL.'#center-analysis/</a> to view the completed analysis.';
        // save the mail in database
        $Database->add_email(array(__LINE__, __METHOD__, __FILE__), $row['email_id'], 'eccd8c0dde', $row['profile_id'], $row['email'], $subject, $message, date('Y-m-d').' 11:00:00');

      }
    }
  }
  /* ********** ********** ********** **********  **********  ********** */

} // end of class Email
?>