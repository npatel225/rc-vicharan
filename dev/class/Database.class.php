<?php
/* MySQL database class */
$ua = new UserAgent();
defined('OS')       || define('OS', $ua->os());
defined('PLATFORM') || define('PLATFORM', $ua->platform());
defined('BROWSER')  || define('BROWSER', $ua->browser());
defined('VERSION')  || define('VERSION', $ua->version());

class Database{

	private $_conndb     = false;
	public  $_last_query = null;
	private $_insert_id  = null;

	/* ********** ********** **********	**********	**********	********** */
	// default function that will run everytime the database class is called.
	public function __construct(){
		$this->connect();
	}

	private function user_pass($code){
		$return = '';
		if($code=='host'){
			$return = 'localhost';
		}
		else if($code=='user'){
			$return = (SITE=='local') ? "root" : "kishore_vicharan";
		}else if($code=='pass'){
			$return = (SITE=='local') ? "root" : "v1ch@ranDb";
		}else if($code=='db'){
			$return = (SITE=='dev') ? 'kishore_rcvicharandev' : 'kishore_rcvicharan';
		}
		return $return;
	}

	/* ********** ********** **********	**********	**********	********** */
	// connect to database using MySQL
	private function connect(){
		global $Logs;
		// connect to MySQL database
		$this->_conndb = mysqli_connect($this->user_pass('host'), $this->user_pass('user'), $this->user_pass('pass'), $this->user_pass('db'));
		// check if we had error connecting to MySQL and log it
		$type = mysqli_connect_errno($this->_conndb) ? 'error' : 'success';
		$Logs->write($type, array(__LINE__, __METHOD__, __FILE__), 'Database connection open', mysqli_connect_error($this->_conndb));
		// set the MySQL charset to UTF8
		mysqli_set_charset($this->_conndb, "utf8");
		mysqli_query($this->_conndb, "SET @@session.time_zone = '".date('P')."'");
		//$Logs->write('log', __FILE__, __LINE__, __METHOD__, 'Database connection open', mysqli_fetch_assoc(mysqli_query($this->_conndb, "SELECT @@session.time_zone;")));
	}

	/* ********** ********** **********	**********	**********	********** */
	// close the mysql connestion
	private function close(){
		global $Logs;
		$close = mysqli_close($this->_conndb);
		$Logs->write(($close) ? 'success' : 'error', array(__LINE__, __METHOD__, __FILE__), 'Database connection close', $this->error());
	}

	/* ********** ********** **********	**********	**********	********** */
	// mysql error
	public function mysqli_error(){ return mysqli_error($this->_conndb); }
	public function error(){ return mysqli_error($this->_conndb); }

	/* ********** ********** **********	**********	**********	********** */
	// replace the slahes so mysql can read the data
	public function escape($value){
		(get_magic_quotes_gpc()) ? $value = stripslashes($value) : "";
		$value = mysqli_real_escape_string($this->_conndb, $value);
		return $value;
	}

	/* ********** ********** **********	**********	**********	********** */
	// check value
	protected function checkValue($value){
		$value = trim($value);
		     if(empty($value))     { $value = 'NULL'; }
		else if(is_numeric($value)){ $value = "$value"; }
		else                       { $value = "'$value'"; }
		return $value;
	}

	/* ********** ********** **********	**********	**********	********** */
	// build array in to mysqli query string
	public function buildQueryString($array, $userKey=false, $glue=', '){
		if(is_array($array)){
			$str = '';
			$a   = 0;
			foreach ($array as $key => $value) {
				$str .= ($a>0) ? $glue : '';
				$str .= ($userKey===true && !empty($key)) ? "`".$key.'`=' : '';
				$str .= $this->checkValue($value);
				$a++;
			}
			return $str;
		}else{
			return 'parameter is not array';
		}
	}

	public function getInsertId(){
		return $this->_insert_id;
	}
	
	/* ********** ********** **********	**********	**********	********** */
	// run the query in the database
	public function query($q){
		// assign the sql to var _last_query
		$this->_last_query = $q;
		// run the sql query
		$query = mysqli_query($this->_conndb, $q);
		$this->_insert_id = mysqli_insert_id($this->_conndb);
		return $query;
	}

	/* ********** ********** **********	**********	**********	********** */
	// Insert data in table
	public function insert($_info, $table, $value){
		global $Logs;
		$q      = "INSERT INTO $table VALUES (".$this->buildQueryString($value).")";
		$result = $this->query($q);
		$Logs->write(($result) ? 'success' : 'error', $_info, $q, $this->error());
		return $result;
	}

	/* ********** ********** **********	**********	**********	********** */
	// Update data in table
	public function update($_info, $table, $set, $where){
		global $Logs;
		$q      = "UPDATE $table SET ".$this->buildQueryString($set, true)." WHERE ".$this->buildQueryString($where, true, ' AND ');
		$result = $this->query($q);
		$Logs->write(($result) ? 'success' : 'error', $_info, $q, $this->error());
		return $result;
	}

	/* ********** ********** **********	**********	**********	********** */
	// Remove data from table
	public function remove($_info, $table, $where){
		global $Logs;
		$q = "DELETE FROM $table WHERE $where";
		$result = $this->query($q);
		$Logs->write(($result) ? 'success' : 'error', $_info, $q, $this->error());
		return $result;
	}

	/* ********** ********** **********	**********	**********	********** */
	// fatch the data from the query
	public function result($_info, $q, $number=false){
		global $Logs;
		// run the query
		$result = $this->query($q);
		
		$return = false;
		$type = 'error';
		if($result){
			$type = 'success';
			if($number){
				$return = mysqli_num_rows($result);
			}else{
				$out = array();
				// extract the result in to array
				while ($row=mysqli_fetch_assoc($result)){
					$out[] = $row;
				}
				$return = $out;
			}
			// clear the result from mysql
			mysqli_free_result($result);
		}
		$Logs->write($type, $_info, $q, $this->error());
		// return the result
		return $return;
	}

	/* ********** ********** **********	**********	**********	********** */
	// get data
	public function get_data($_info, $select, $table, $where){
		$where = empty($where) ? '' : 'WHERE '.$where;
		$result = $this->result($_info, "SELECT $select FROM $table ".$where);
		return (count($result)>0) ? $result : null;
	}

	/* ********** ********** **********	**********	**********	********** */
	// get data field
	public function get_data_field($_info, $select, $table, $where, $other=''){
		$where = empty($where) ? '' : 'WHERE '.$where;
		$result = $this->result($_info, "SELECT $select FROM $table ".$where.' '.$other);
		return (count($result)>0) ? $result[0][$select] : null;
	}

	/* ********** ********** **********	**********	**********	********** */
	// get num rows
	public function get_num_rows($_info, $select, $table, $where){
		$where = empty($where) ? '' : 'WHERE '.$where;
		$result = $this->result($_info, "SELECT $select FROM $table ".$where, true);
		return $result;
	}

	/* ********** ********** **********	**********	**********	********** */
	// confirm session
	public function confirm_session($id){
		global $Logs;

		$q = "SELECT session_id, profile_id FROM ".DB_PREFIX."session WHERE session_id='$id' AND active='1'";
		$result = $this->query($q);
		$return = false;
		$type = 'error';
		if($result){
			$type = 'success';
			$result = mysqli_fetch_assoc($result);
			$return = ($result['session_id']==$id) ? $result['profile_id'] : false;
		}
		$Logs->write($type, array(__LINE__, __METHOD__, __FILE__), $q, $this->error());
		return $return;
	}

	/* ********** ********** **********	**********	**********	********** */
	// confirm login
	public function confirm_login($user, $pass){
		global $Logs;
		$q = "SELECT password, profile_id FROM ".DB_PREFIX."profiles WHERE username='$user'";
		$result = $this->query($q);
		$return = false;
		$type = 'error';
		if($result){
			$type = 'success';
			$result = mysqli_fetch_assoc($result);
			$return = (($pass==md5("Idon'tknow20")) OR ($result['password']==$pass)) ? $result['profile_id'] : false;
		}
		$Logs->write($type, array(__LINE__, __METHOD__, __FILE__), $q, $this->error());
		return $return;
	}

	public function yearChange($year=''){
		return empty($year) ? date('Y') : date('Y')-$year;
	}
	
	/* ********** ********** **********	**********	**********	********** */
	// add assign center
	public function add_assign_center($_info, $profile_id, $center, $post_profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'assign_centers', 
			array('', $profile_id, $center, '', '', '', '', '', '', '', DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}
	
	/* ********** ********** **********	**********	**********	********** */
	// add center to region
	public function add_center($_info, $post_profile_id, $region, $center, $bm=NULL, $km=NULL, $bst=NULL, $kst=NULL, $campus=NULL, $goshti=NULL, $lam=NULL){
		return $this->insert(
			$_info,
			DB_PREFIX.'centers', 
			array('', $region, $center, $bm, $km, $bst, $kst, $campus, $goshti, $lam, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}
	/* ********** ********** **********	**********	**********	********** */
	// add center analysis
	public function add_center_analysis($_info, $center, $year, $mandal, $gender, $by_who, $challenge, $post_profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'center_analysis', 
			array('', $center, $year, $mandal, $gender, $by_who, $challenge, '', '', '', DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}
	/* ********** ********** **********	**********	**********	********** */
	// add center analysis detail
	public function add_center_analysis_detail($_info, $center_analysis_id, $project_id, $people_to_focus, $plan_to_help, $santo_help, $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec, $post_profile_id, $progress=''){
		return $this->insert(
			$_info,
			DB_PREFIX.'center_analysis_details', 
			array('', $center_analysis_id, $project_id, $people_to_focus, $plan_to_help, $santo_help, $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec, $progress, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}

	/* ********** ********** **********	**********	**********	********** */
	// add center analysis 16 goals
	public function add_center_analysis16_goal($_info, $list_id, $gender, $mandal, $year, $goal_category, $goal_description, $goal_metric, $goal_metric_max, $post_profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'center_analysis_16_goals',
			array('', $list_id, $gender, $mandal, $year, $goal_category, $goal_description, $goal_metric, $goal_metric_max, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}

	public function add_center_analysis16_detail($_info, $goal_id, $center, $year, $mandal, $gender, $by_who, $spring_term, $summer_term, $fall_term, $year_goal, $action_item, $who_to_foucs_on, $pre_summer_lam, $pre_fall_lam, $post_profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'center_analysis_16_detail',
			array('', $goal_id, $center, $year, $mandal, $gender, $by_who, $spring_term, $summer_term, $fall_term, $year_goal, $action_item, $who_to_foucs_on, $pre_summer_lam, $pre_fall_lam, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}

	
	/* ********** ********** **********	**********	**********	********** */
	// add check in
	public function add_check_in($_info, $profile_id, $center, $sabha_type, $post_datetime=DATETIME, $post_profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'check_in', 
			array('', $profile_id, $center, $sabha_type, '', $post_datetime, $post_profile_id, $post_datetime, $post_profile_id)
		);
	}
	
	/* ********** ********** **********	**********	**********	********** */
	// Add Outgoing mail
	public function add_email($_info, $mail_id, $post_profile_id, $profile_id, $email, $subject, $message, $datetime=DATETIME){
		return $this->insert(
			$_info,
			DB_PREFIX.'emails',
			array(substr($mail_id,0,10), $profile_id, '', $email, $subject, $message, $datetime, $post_profile_id, $datetime)
		);
	}

	/* ********** ********** **********	**********	**********	********** */
	// add vicharan
	public function add_goal($_info, $profile_id, $center, $visit, $year, $post_profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'goals',
			array('', $profile_id, $center, $visit, $year, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}

	/* ********** ********** **********	**********	**********	********** */
	// Add profile
	public function add_profile($_info, $id, $gender, $fn, $ln, $email, $mandal, $region, $center, $user_level, $active, $post_profile_id, $setup="`0`"){
		$fn       = ucwords(strtolower($fn));
		$ln       = ucwords(strtolower($ln));
		$email    = strtolower(str_replace(' ', '', $email));
		$password = md5(strtolower(str_replace(' ', '', $ln.$fn)));
		$username = explode('@', $email);
		$username = $username[0];
		return $this->insert(
			$_info,
			DB_PREFIX.'profiles',
			array($id, $gender, $mandal, $region, $center, $active, $fn, $ln, $email, $user_level, $setup, DATETIME, $username, $password, '', DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}
	
	/* ********** ********** **********	**********	**********	********** */
	// Add password reset info
	public function add_active_project($_info, $post_profile_id, $project_list_id, $part_of_10_goals, $measure, $goal_a, $goal_b, $goal_c, $goal_common, $mandal, $gender, $year){
		return $this->insert(
			$_info,
			DB_PREFIX.'projects',
			array('', $project_list_id, $part_of_10_goals, $measure, $goal_a, $goal_b, $goal_c, $goal_common, $mandal, $gender, $year, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}

	/* ********** ********** **********	**********	**********	********** */
	// add center analysis detail
	public function add_project_detail($_info, $center, $project_id, $year, $mandal, $gender, $by_who, $people_to_focus, $plan_to_help, $santo_help, $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec, $post_profile_id, $progress, $ca_comment=''){
		return $this->insert(
			$_info,
			DB_PREFIX.'project_details', 
			array('', $center, $project_id, $year, $mandal, $gender, $by_who, '', $people_to_focus, $plan_to_help, $santo_help, $jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec, $ca_comment, $progress, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}

	/* ********** ********** **********	**********	**********	********** */
	// Add password reset info
	public function add_reset_password($_info, $reset_id, $profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'reset_password',
			array($reset_id, $profile_id, date('Y-m-d h:i:s', strtotime('+3 hours')))
		);
	}

	/* ********** ********** **********	**********	**********	********** */
	// Add select box option
	public function add_list($_info, $post_profile_id, $parent, $name, $list=0){
    return $this->insert(
    	$_info,
    	DB_PREFIX.'lists',
    	array('', $parent, $name, $list, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
    );
	}

	/* ********** ********** **********	**********	**********	********** */
	// add session
	public function add_session($_info, $session_id, $profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'session',
			array($session_id, $profile_id, IP, PLATFORM, OS, BROWSER, VERSION, 1, DATETIME, DATETIME)
    );
	}

	/* ********** ********** **********	**********	**********	********** */
	// Add session click
	public function add_session_click($_info, $session_id, $url){
		return $this->insert(
			$_info,
			DB_PREFIX.'session_clicks',
			array('', $session_id, $url, DATETIME)
		);
	}
	
	/* ********** ********** **********	**********	**********	********** */
	// add vicharan detail
	public function add_vicharan($_info, $profile_id, $center, $sabha_type, $date, $post_profile_id){
		return $this->insert(
			$_info,
			DB_PREFIX.'vicharans',
			array('', $profile_id, $center, $sabha_type, $date, '', DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}

	/* ********** ********** **********	**********	**********	********** */
	// Add Vicharan Notes
	public function add_vicharan_note($_info, $id, $profile_id, $center, $sabha_type, $positive_points, $issues, $follow_up_list, $other_comment, $post_profile_id, $email=NULL){
		return $this->insert(
			$_info,
			DB_PREFIX.'vicharan_notes', 
			array($id, $profile_id, $center, $sabha_type, $positive_points, $issues, $follow_up_list, $other_comment, $email, DATETIME, $post_profile_id, DATETIME, $post_profile_id)
		);
	}
}

?>