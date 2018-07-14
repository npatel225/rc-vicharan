<?php
// load all the classes
require_once 'Config.php';
require_once 'Request.php';

if(SITE=='local'){
  $db_old = '`sunil523_rcvicharan2.0`';
  $db_new = '`sunil523_rcvicharan2.1`';
}else{
  $db_old = '`kishore_rcvicharan`';
  $db_new = '`kishore_rcvicharandev`';  
}

$Logs     = new Logs();
$Database = new Database();
$Session  = new Session();

/* core class */
class Core{

  /* ********** ********** ********** **********  **********  ********** */
  public $datetime = null;

  /* ********** ********** ********** **********  **********  ********** */
  public function __construct(){
    $this->datetime = $this->get_datetime();
  }

  /* ********** ********** ********** **********  **********  ********** */
  // load the pages base on the url
  public function run(){
    /*/
    global $Session, $Database;
    // hold the html output
    ob_start();
    if(trim($_GET['url'],'/')=='sign-out'){
      if($Session->logout(2)){ // 2 is for menuly signing out
        header("Location: ".SITE_URL);
      }
    }
    // if Session is not logged in the load the login page
    $page = (!$Session->login) ? 'login' : null;
    // require the curent page
    require_once url::getPage($page);
    // flush the html to browser
    ob_get_flush();*/
  }

  /* ********** ********** ********** **********  **********  ********** */
  /* send mail out - here we use PHP mail function to send the email out to user */
  public function mail_out($email, $subject, $message){
    if(SITE=='local'){$return = 1;}
    else{
      $header = "From: RC Vicharan <no-reply@na.baps.org>\r\n";
      $header.= "Content-Type: text/html\r\n";

      $return = mail($email, $subject, $message, $header);
    }
    return $return;
  }
  
  /* ********** ********** ********** **********  **********  ********** */
  // select option 
  public function select_option($parent, $type, $where=''){
    global $Database;
    if($where!=''){$where=" AND ".$where;}
    $result = $Database->result(array(__LINE__, __METHOD__, __FILE__), "SELECT $type AS alias FROM ".DB_PREFIX."lists WHERE parent='$parent' $where ORDER BY name");
    
    $option='';
    for ($a=0; $a<count($result); $a++) { 
      $row = $result[$a];
      $option .= ($a>0) ? ',' : '';
      $option .= '"'.$row["alias"].'"';
    }
    return $option;
  }
  
  public function microtime_float(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
  }

  /* ********** ********** ********** **********  **********  ********** */
  // convart html to text
  public function html_ecode($html){
    return htmlspecialchars($html, ENT_QUOTES);
  }
  public function html_decode($value){
    $value = htmlspecialchars_decode($value, ENT_QUOTES);
    return str_replace('"', '\\"', $value);
  }
  /* ********** ********** ********** **********  **********  ********** */
  // Error Message
  public function error_message($message, $file, $line, $error=''){
    global $Database;
    $line -= 1;
    $error = empty($error) ? $Database->mysqli_error() : $error;
    return $this->replace_quotes($message.' in <em>'.$file.'</em> on <strong>'.$line.'</strong> ERROR: '.$error.'<br>'."\r\n");
  }
  
  /* ********** ********** ********** **********  **********  ********** */
  // get datetime
  public function get_datetime(){ return date('Y-m-d H:i:s'); }

  /* ********** ********** ********** **********  **********  ********** */
  // remove lines - Remove any tabs, new line, or return from content
  public function remove_line_break($c){ return preg_replace('(\r|\n|\t)','',$c); }

  /* ********** ********** ********** **********  **********  ********** */
  // replace quotes from content
  public function replace_quotes($content){
    return str_replace(array('"',"'"), array('&#34;','&#39;'), $content);
  }
  
  /* ********** ********** ********** **********  **********  ********** */
  // Format DateTime - 
  function format_datetime($datetime, $type='M d, Y h:i A'){
    return date($type, strtotime($datetime));
  }

  /* ********** ********** ********** **********  **********  ********** */
  // Generates a string made up of randomized letters (lower and upper case) and digits, the length is a specified parameter.
  public function rand_string($length){
    $randstr = '';
    for($i=0; $i<$length; $i++){
      $randnum=mt_rand(0,61);
      if($randnum<10){$randstr.=chr($randnum+48);}
      else if($randnum<36){$randstr.=chr($randnum+55);}
      else{$randstr.=chr($randnum+61);}
    }
    return $randstr;
  }

  /* ********** ********** ********** **********  **********  ********** */
  // mandal name - return mandal full name base on the gender and mandal
  public function mandal_name($gender,$mandal){
         if(($gender=='M') && ($mandal=='B')){$mandal='Bal';}
    else if(($gender=='M') && ($mandal=='K')){$mandal='Kishore';}
    else if(($gender=='M') && ($mandal=='C')){$mandal='Sant';}
    else if(($gender=='F') && ($mandal=='B')){$mandal='Balika';}
    else if(($gender=='F') && ($mandal=='K')){$mandal='Kishori';}
    else if(($gender=='F') && ($mandal=='C')){$mandal='RMC';}
    return $mandal;
  }

  /* ********** ********** ********** **********  **********  ********** */
  // mandal name - return mandal full name base on the gender and mandal
  public function gender_mandal($mandal){
    $gender = '';
         if($mandal=='Bal')    {$gender='M'; $mandal='B';}
    else if($mandal=='Kishore'){$gender='M'; $mandal='K';}
    else if($mandal=='Sant')   {$gender='M'; $mandal='C';}
    else if($mandal=='Balika') {$gender='F'; $mandal='B';}
    else if($mandal=='Kishori'){$gender='F'; $mandal='K';}
    else if($mandal=='RMC')    {$gender='F'; $mandal='C';}
    return array('gender'=>$gender, 'mandal'=>$mandal);
  }

  /* ********** ********** ********** **********  **********  ********** */
  // by who name
  public function by_who_name($by_who, $gender){
         if($by_who==1){$by_who = 'RC';}
    else if($by_who==2 && $gender=='M'){$by_who = 'Sanchalak';}
    else if($by_who==2 && $gender=='F'){$by_who = 'Sanchalika';}
    return $by_who;
  }

  public function by_who_id($by_who){
    if($by_who=="RC"){$by_who = 1;}
    else if($by_who=="Sanchalak" || $by_who=='Sanchalika'){$by_who = 2;}
    return $by_who;
  }

}
$Core = new Core();
?>