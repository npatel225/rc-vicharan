<?php

class Url{
	public static $_folder = PAGES_DIR;
	public static $params = array();

	public function __construct(){
		self::getAll();
	}

	public static function cPage($page=null){
		// trim the last shals from url
		$_GET['url'] = trim($_GET['url'],'/');
		// start the url from folder
		$cUrl = '';
		// assign the page which was passed
		if($page!=null){
			$cUrl .= $page;
		}
		// there is no url so default is index
		else if(empty($_GET["url"])){
			$cUrl .= "index";
		}
		// 
		else{
			$url = explode('/', $_GET['url']);
			$cUrl .= (isset($url[0]) && !empty($url[0])) ? $url[0].DS : "";
			$cUrl .= (isset($url[1]) && !empty($url[1])) ? $url[1] : "index";

			for($a=2;$a<count($url); $a++){
				$_GET['param'][$a-2] = $url[$a];
			}
		}

		self::getAll();
		
		return $cUrl;
	}

	public static function getPage($page){
		$page = self::$_folder.DS.self::cPage($page).'.php';
		$error = LAYOUT_DIR.DS."error.php";
		return is_file($page) ? $page : $error;
	}

	
	public static function getAll($return=false){
		if(!empty($_GET)){
			foreach ($_GET as $key => $value) {
				self::$params[$key] = $value;
			}
		}
		if(!empty($_POST)){
			foreach ($_POST as $key => $value) {
				self::$params[$key] = $value;
			}
		}
		return ($return) ? self::$params : '';
	}
	
	public static function param($par){
		return (isset(self::$params[$par]) && !empty(self::$params[$par])) ? self::$params[$par] : null;
	}
	
}
?>