<?php
/* session class */
class Session{

	public $login           = null;
	public $session_id      = null;
	public $session_id_long = null;
	public $profile_id      = null;
	public $first_name      = null;
	public $last_name       = null;
	public $gender          = null;
	public $user_level      = 0;
	public $email           = null;
	public $mandal          = null;
	public $region          = null;
	public $center          = null;
	public $setup           = 0;

	/* ********** ********** **********	**********	**********	********** */
	function __construct(){
		$this->login = $this->check_login();
	}

	/* ********** ********** **********	**********	**********	********** */
	// check login - check if user is logged in with valid session_id
	public function check_login(){
		global $Database, $Logs;

		if(!isset($_SESSION[SESSION_NAME])){
			$Logs->write('log', array(__LINE__, __METHOD__, __FILE__), 'session_id: '.$this->session_id, 'session id is not set.');
			return false;
		}else{
			$this->session_id_long = $_SESSION[SESSION_NAME];
			$this->session_id = substr($this->session_id_long, 0, 10);

			// confirm the session_id in the Database
			$confirmed = $Database->confirm_session($this->session_id);
			if($confirmed==false){
				$Logs->write('log', array(__LINE__, __METHOD__, __FILE__), 'session_id: '.$this->session_id, 'session id is not confirmed');
				return false;
			}else{
				// assign the value of confirmed to profile_id
				$this->profile_id = $confirmed;
				// get user basic info
				$data = $Database->result(array(__LINE__, __METHOD__, __FILE__), "SELECT first_name, last_name, gender, user_level, email, mandal, region, center, setup FROM ".DB_PREFIX."profiles WHERE profile_id='$this->profile_id'");
				if(!empty($data)){
					$data = $data[0];
					$this->first_name = $data['first_name'];
					$this->last_name  = $data['last_name'];
					$this->gender     = $data['gender'];
					$this->user_level = $data['user_level'];
					$this->email      = $data['email'];
					$this->mandal     = $data['mandal'];
					$this->region     = $data['region'];
					$this->center     = $data['center'];
					$this->setup      = $data['setup'];
				}

				$Logs->write('log', array(__LINE__, __METHOD__, __FILE__), 'session_id: '.$this->session_id, 'session id is confirmed');
				return true;
			}
		}
	}

	/* ********** ********** **********	**********	**********	********** */
	// confirm login - confirm user login info
	public function confirm_login($user,$pass){
		global $Database, $Logs;
		$user = stripslashes($user);
		// Checks that username is in Database and password is correct
		$confirmed = $Database->confirm_login($user, $pass);
		// Username and password are incorrect
		if($confirmed==false){
			$Logs->write('log', array(__LINE__, __METHOD__, __FILE__), 'login: '.$user, 'login is not confirmed');
			return false;
		}
		// Username and password are correct, register session variables
		else{
			// assign the value of confirmed to profile_id
			$this->profile_id = $confirmed;
			// add the session in the session table
			$Database->add_session(array(__LINE__, __METHOD__, __FILE__), $this->session_id, $this->profile_id);
			$this->login;
			$Logs->write('log', array(__LINE__, __METHOD__, __FILE__), 'login: '.$this->session_id, 'login is confirmed');
			return true;
		}
	}

	/* ********** ********** **********	**********	**********	********** */
	// logout - logout user from site
	public function logout($logout=NULL){
		// logout 1=menulay or click on the link to signout
		global $Database, $Logs;

		$logout = ($logout==NULL) ? 'NULL' : $logout;
		$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', array("session_id" => ""), array("profile_id" => $this->profile_id));
		$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'session', array("active" => $logout, "update_datetime" => DATETIME), array("session_id" => $this->session_id));
		unset($_SESSION);
		session_regenerate_id();
		session_destroy();
		$Logs->write('log', array(__LINE__, __METHOD__, __FILE__), 'Logout', $this->profile_id.'-'.$this->session_id);
		return true;
	}

	/* ********** ********** **********	**********	**********	********** */
	// filter query - filter query base on the user_level
	public function filter_query($where='', $ul='', $mandalTbl='', $regionTbl='', $centerTbl='', $profileIdTbl=''){
		global $Database;

		$ul           = empty($ul)           ? (($this->user_level<UL_SITE_ADMIN) ? UL_NA_SANT : $this->user_level) : $ul;
		$mandalTbl    = empty($mandalTbl)    ? '' : $mandalTbl.'.';
		$regionTbl    = empty($regionTbl)    ? '' : $regionTbl.'.';
		$centerTbl    = empty($centerTbl)    ? '' : $centerTbl.'.';
		$profileIdTbl = empty($profileIdTbl) ? '' : $profileIdTbl.'.';

		$output = '';
		if($ul==UL_SITE_ADMIN){
			$output = " pf.user_level>='$ul' ";
		}
		else if($ul==UL_NA_SANT){
			$output = " pf.user_level>='$ul' AND {$mandalTbl}gender='$this->gender' ";
		}
		else if($ul==UL_NA_RC){
			$output = " pf.user_level>='$ul' AND {$mandalTbl}gender='$this->gender' AND {$mandalTbl}mandal='$this->mandal' ";
		}
		else if($ul==UL_RCL_SANT){
			$output = " pf.user_level>='$ul' AND {$mandalTbl}gender='$this->gender' AND {$regionTbl}region='$this->region' AND pf.active='Y' ";
		}
		else if($ul==UL_RCL){
			$output = " pf.user_level>='$ul' AND {$mandalTbl}gender='$this->gender' AND {$regionTbl}region='$this->region' AND {$mandalTbl}mandal='$this->mandal' AND pf.active='Y' ";
		}
		else if($ul==UL_RA){
			$output = " pf.user_level>='$ul' AND {$mandalTbl}gender='$this->gender' AND {$regionTbl}region='$this->region' AND {$mandalTbl}mandal='$this->mandal' ";
		}
		else if($ul==UL_RC_SANT || $ul==UL_RC){
			$result = $Database->result(array(__LINE__, __METHOD__, __FILE__), "SELECT center FROM ".DB_PREFIX."assign_centers WHERE profile_id='$this->profile_id'");
			$centers = '';
			if(count($result)>0){
				$centers = "{$centerTbl}center IN(";
				for ($a=0; $a<count($result); $a++) {
					$centers .= "'".$result[$a]['center']."'".(($a<(count($result)-1)) ? ', ' : '');
				}
				$centers .= ')';
			}else{
				$centers = "{$centerTbl}center='$this->center'";
			}
			$output = " pf.user_level>='$ul' AND {$mandalTbl}gender='$this->gender' AND {$regionTbl}region='$this->region' AND $centers AND pf.active='Y' ";
			$output.= ($ul==UL_RC) ? " AND {$mandalTbl}mandal='$this->mandal' " : "";
		}
		else{
			$output = " {$profileIdTbl}profile_id='$this->profile_id' AND {$mandalTbl}gender='$this->gender' AND pf.active='Y' ";
		}

		$return = (!empty($where)) ? $where : '';
		$return.= (!empty($where) AND (!empty($output))) ? ' AND '.$output : $output;
		return $return;
	}

	/* ********** ********** **********	**********	**********	********** */
	// region center filter
	public function filter_region_center($where='', $ul='', $regionTbl='', $centerTbl=''){
		global $Database;

		$ul        = empty($ul)        ? $this->user_level : $ul;
		$regionTbl = empty($regionTbl) ? '' : $regionTbl.'.';
		$centerTbl = empty($centerTbl) ? '' : $centerTbl.'.';

		$output = '';
		switch ($ul) {
			case UL_SITE_ADMIN:
			case UL_NA_SANT:
			case UL_NA_RC:
				$output = "";
				break;
			case UL_RCL_SANT:
			case UL_RCL:
			case UL_RA:
				$output = " {$regionTbl}region='$this->region' ";
				break;
			case UL_RC_SANT:
			case UL_RC:
			case UL_SANCHALAK:
			default:
				$output = " {$regionTbl}region='$this->region' AND {$centerTbl}center in(".$this->assign_centers().") ";
				break;
		}

		$return = !empty($where) ? $where : '';
		$return.= (!empty($where) AND !empty($output)) ? ' AND '.$output : $output;
		return $return;
	}

	/* ********** ********** **********	**********	**********	********** */
	// filter gender & mandal - filter query base on the gender mandal
	public function filter_gender_mandal($where='', $ul='', $mandalTbl=''){
		global $Database;

		$ul        = empty($ul)           ? $this->user_level : $ul;
		$mandalTbl = empty($mandalTbl)    ? '' : $mandalTbl.'.';

		$output = '';
		switch ($ul) {
			case UL_SITE_ADMIN:
				$output = '';
				break;
			case UL_NA_SANT:
			case UL_RCL_SANT:
			case UL_RC_SANT:
				$output = " {$mandalTbl}gender='$this->gender' ";
				break;
			case UL_NA_RC:
			case UL_RCL:
			case UL_RA:
			case UL_RC:
			case UL_SANCHALAK:
			default:
				$output = " {$mandalTbl}gender='$this->gender' AND {$mandalTbl}mandal='$this->mandal' ";
				break;
		}

		$return = !empty($where) ? $where : '';
		$return.= (!empty($where) AND !empty($output)) ? ' AND '.$output : $output;
		return $return;
	}

	/* ********** ********** **********	**********	**********	********** */
	// assign center
	public function assign_centers(){
		global $Database, $Logs;
		$centers = '';
		$q       = "SELECT center FROM ".DB_PREFIX."assign_centers WHERE profile_id='$this->profile_id'";
		if($this->user_level!=UL_SANCHALAK){
			$result  = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);
			$Logs->write('log', array(__LINE__, __METHOD__, __FILE__), 'Logout', $Database->mysqli_error());

			if(count($result)>0){
				for ($a=0; $a<count($result); $a++) {
					$row = $result[$a];
					$centers .= "'".$row['center']."'";
					$centers .= ($a<(count($result)-1)) ? ', ' : '';
				}
			}else{
				$centers = "'$this->center'";
			}
		}else{
			$centers = "'$this->center'";
		}
		return $centers;
	}

	/* ********** ********** **********	**********	**********	********** */
	// gender_mandal = gender and mandal base on user_level
	public function gender_mandal($ul='', $gender='', $mandal=''){
		$array    = '';
		$ul       = empty($ul) ? $this->user_level : $ul;
		$gender   = empty($gender) ? $this->gender : $gender;
		$mandal   = empty($mandal) ? $this->mandal : $mandal;
		$mandal_d = array('B', 'K');
		// $ul is less then site admin so show the filterd gender and madal
		if($ul>UL_SITE_ADMIN){
			// if $ul is NA_SANT then show both mandal to NA_SANT else show only the mandal which is passed 
			$mandals = ($ul==UL_NA_SANT) ? $mandal_d : array($mandal);
			// if gender is male then show the male array else show the female array
			$array = ($gender=='M') ? array('M' => $mandals) : array('F' => $mandals);
		}
		// $ul is site_admin so show all the mandal and gender
		else{
			$array = array('M' => $mandal_d, 'F' => $mandal_d);
		}
		return $array;
	}

	/* ********** ********** **********	**********	**********	********** */
	// Get name from select box
	public function select_box_name($value){
		global $Database;
		$name = $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), 'name', DB_PREFIX.'select_box', "value='$value'");
    return ($name) ? $name : '';
	}
}
?>