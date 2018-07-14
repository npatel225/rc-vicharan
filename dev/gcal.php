<?php
require_once 'class/Config.php';
require_once 'class/Core.class.php';
$id = empty($_GET['id']) ? NULL : $_GET["id"];
// Variables used in this script:
//   $summary     - text title of the event
//   $datestart   - the starting date (in seconds since unix epoch)
//   $dateend     - the ending date (in seconds since unix epoch)
//   $address     - the event's address
//   $uri         - the URL of the event (add http://)
//   $description - text description of the event
//   $filename    - the name of this file for saving (e.g. my-event-name.ics)
//

	$filename = 'rcVicharan.ics';
	// 1. Set the correct headers for this file
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$filename);
		
function dateToCal($timestamp){return date('Ymd\Tgis\Z', $timestamp);}
// Escapes a string of characters
function escapeString($string){return preg_replace('/([\,;])/','\\\$1', $string);}

$id=substr($id,10,19);
if(!empty($id)){
	$q = "SELECT vicharan_id, `date`, (SELECT region FROM ".DB_PREFIX."centers WHERE center=v.center) AS region, center, sabha_type FROM ".DB_PREFIX."vicharans AS v WHERE profile_id='$id' AND `date` LIKE '".date("Y")."%' ORDER BY `date`, region, center";
	$result = $Database->result($q);
	$Logs->write('log', __FILE__, __LINE__, 'gcal', $q, $Database->mysqli_error());

	if(count($result)>0){
		$ical='';
		for ($a=0; $a<count($result); $a++) { 
			$row = $result[$a];
			$date = explode('-', $row["date"]);
			$dateStart = $date[0].$date[1].$date[2];
			$dateEnd = $date[0].$date[1].($date[2]+1);
			$address = 'BAPS Swaminarayan Mandir, '.$row["center"];
			$description = '';
			$uri = 'http://kishore.na.baps.org/rcvicharan/#my-vicharan/?'.$row["date"];
			$summary = $row["center"].'('.$row["sabha_type"].') - '.$row["region"];

			$ical.="
	BEGIN:VEVENT
	UID:".$row['vicharan_id']."@kishore.na.baps.org
	DTSTART;VALUE=DATE:".$dateStart."
	DTEND;VALUE=DATE:".$dateEnd."
	DESCRIPTION:
	SUMMARY:".escapeString($summary)."
	BEGIN:VALARM
	TRIGGER:-PT12H
	ACTION:DISPLAY
	DESCRIPTION:Reminder
	END:VALARM
	END:VEVENT
	";

		}
	// echo the output 
	echo "BEGIN:VCALENDAR
	PRODID:-//Mozilla.org/NONSGML Mozilla Calendar V1.1//EN
	VERSION:2.0
	METHOD:PUBLISH
	X-MS-OLK-FORCEINSPECTOROPEN:TRUE";
	echo $ical;
	echo "END:VCALENDAR";
	}
}
?>