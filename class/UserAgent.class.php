<?php
class UserAgent{

	private $_agent           = "Unknown";
	private $_platform        = "Unknown";
	private $_os              = "Unknown";
	private $_browser         = "Unknown";
	private $_version         = "Unknown";
	private $_browser_version = "Unknown";

	public function __construct(){
		$this->_agent = $_SERVER['HTTP_USER_AGENT'];
	}
	public function platform(){
		$os_array = array(
		'/windows|win/i'     => 'Windows',
		'/macintosh|mac os x|mac_powerpc/i' => 'Mac',
		'/linux/i'              => 'Linux',
		'/ubuntu/i'             => 'Ubuntu',
		'/iphone/i'             => 'iPhone',
		'/ipod/i'               => 'iPod',
		'/ipad/i'               => 'iPad',
		'/android/i'            => 'Android',
		'/blackberry/i'         => 'BlackBerry',
		'/webos/i'              => 'WebOS'
		);

		foreach ($os_array as $regex => $value) { 
			if (preg_match($regex, $this->_agent)) {
				$this->_os = $value;
			}
		}
		return $this->_os;
	}

	public function os(){
		$os_array = array(
		'/windows nt 6.3/i'                => 'Windows 8.1',
		'/windows nt 6.2/i'                => 'Windows 8',
		'/windows nt 6.1/i'                => 'Windows 7',
		'/windows nt 6.0/i'                => 'Windows Vista',
		'/windows nt 5.2/i'                => 'Windows Server 2003/XP x64',
		'/windows nt 5.1|windows xp/i'     => 'Windows XP',
		'/windows nt 5.0/i'                => 'Windows 2000',
		'/windows me/i'                    => 'Windows ME',
		'/win98/i'                         => 'Windows 98',
		'/win95/i'                         => 'Windows 95',
		'/win16/i'                         => 'Windows 3.11',
		'/macintosh|mac os x/i'            => 'Mac OS X',
		'/mac_powerpc/i'                   => 'Mac OS 9',
		'/linux/i'                         => 'Linux',
		'/ubuntu/i'                        => 'Ubuntu',
		'/iphone/i'                        => 'iPhone',
		'/ipod/i'                          => 'iPod',
		'/ipad/i'                          => 'iPad',
		'/android/i'                       => 'Android',
		'/blackberry/i'                    => 'BlackBerry',
		'/webos/i'                         => 'Mobile'
		);

		foreach ($os_array as $regex => $value) { 
			if (preg_match($regex, $this->_agent)) {
				$this->_os = $value;
			}
		}
		return $this->_os;
	}

	public function browser(){
		$browsers = array(
			'/msie/i'      => 'Internet Explorer',
			'/firefox/i'   => 'Firefox',
			'/safari/i'    => 'Safari',
			'/chrome/i'    => 'Chrome',
			'/opera/i'     => 'Opera',
			'/netscape/i'  => 'Netscape',
			'/maxthon/i'   => 'Maxthon',
			'/konqueror/i' => 'Konqueror',
			'/mobile/i'    => 'Mobile'
		);

		foreach($browsers as $regex => $browser){
			if(preg_match($regex, $this->_agent)){
				$this->_browser = $browser;
			}
		}
		return $this->_browser;
	}

	public function version(){
		$versions = array(
			'MSIE\s([0-9\.]*)'   => 'MSIE',
			'Firefox/([0-9\.]*)' => 'Firefox',
			'Version/([0-9\.]*)' =>	'Safari',
			'Chrome/(.*)\s'      => 'Chrome',
			'Version/([0-9\.]*)' => 'Opera'
		); 
		foreach ($versions as $regex => $browser){
			if (preg_match('@'.$browser.'@i', $this->_agent)){
				preg_match('@'.$regex.'@i', $this->_agent, $version);
				$this->_browser_version = $version[1];
			}
		}
		return $this->_browser_version;
	}
}
?>