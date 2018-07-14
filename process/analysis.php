<?php
require_once '../class/Core.class.php';
/* Analysis */
if($Session->login && ($Session->user_level<=UL_NA_RC)){

	function week_range($date,$format=null){
		$ts = strtotime($date);
		$start = (date('w', $ts) == 1) ? $ts : strtotime('last monday', $ts);
		if($format=='short'){
			return array(date('m/d', $start), date('m/d', strtotime('next sunday', $start)));
		}else{
			return array(date('Y-m-d', $start), date('Y-m-d 23:59:59', strtotime('next sunday', $start)));
		}
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	/* Select other option - remove */
	if($type=='top-links'){
		$q       = "SELECT hash, count(hash) as clicks FROM session_clicks GROUP BY hash ORDER BY clicks DESC";
		$result  = $Database->result(array(__LINE__, __METHOD__, __FILE__), $q);
		$output .= ',"top_links":[';
		if(count($result)>0){
			for($a=0; $a<count($result); $a++){
				$row    = $result[$a];
				$output.='{
					"hash":"'.$row["hash"].'",
					"clicks":'.$row["clicks"].'
				}';
				$output .= ($a<(count($result)-1)) ? ',' : '';
			}
		}
		$output.=']';
	}

	/* ********** ********** ********* ********* ********* ********* ********* */
	else{
		$year = (!isset($type)) ? date('Y') : $type;
		$week_number = ($year>=date('Y')) ? date('W') : 52;
		$week_start_date = $year.'-01-01';
		$date_range = Array();
		$categories = '';
		$logged_in = 0;
		$checked_in = 0;
		$planned = 0;
		$vicharan_notes = 0;

		for($a=0; $a<$week_number; $a++){
			list($start_date, $end_date) = week_range($week_start_date);
			list($short_start_date, $short_end_date) = week_range($week_start_date,'short');
			$week_start_date = date('Y-m-d', strtotime('+7 days', strtotime($week_start_date)));

			$categories .= "'".$short_start_date."-".$short_end_date."'";

			/* Logged-in this week */
			$logged_in .= $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), "count(ss.profile_id)", DB_PREFIX."session AS ss, ".DB_PREFIX."profiles AS pf", "ss.post_datetime BETWEEN '$start_date' AND '$end_date' AND pf.profile_id=ss.profile_id AND pf.gender='".$Session->gender."' AND pf.mandal='".$Session->mandal."'");

			/* Checked-in week */
			$result='';
			$checked_in .= $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), "count(check_in_id)", DB_PREFIX."check_in AS ci, ".DB_PREFIX."profiles as pf", "ci.post_datetime BETWEEN '$start_date' AND '$end_date' AND pf.profile_id=ci.profile_id AND pf.gender='".$Session->gender."' AND pf.mandal='".$Session->mandal."'");

			/* Vicharan planned this week */
			$result='';
			$planned .= $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), "count(vicharan_id)", DB_PREFIX."vicharans AS vn, ".DB_PREFIX."profiles AS pf", "vn.date BETWEEN '$start_date' AND '$end_date' AND pf.profile_id=vn.profile_id AND pf.gender='".$Session->gender."' AND pf.mandal='".$Session->mandal."'");

			/* Vicharan notes this week */
			$result='';
			$vicharan_notes .= $Database->get_data_field(array(__LINE__, __METHOD__, __FILE__), "count(vicharan_note_id)", DB_PREFIX."vicharan_notes as vnt, ".DB_PREFIX."profiles AS pf", "vnt.post_datetime BETWEEN '$start_date' AND '$end_date' AND pf.profile_id=vnt.profile_id AND pf.gender='".$Session->gender."' AND pf.mandal='".$Session->mandal."'");

			$cama = ($a!=($week_number-1)) ? "," : "";
			$categories .= $cama;
			$logged_in .= $cama;
			$checked_in .= $cama;
			$planned .= $cama;
			$vicharan_notes .= $cama;
		}

		echo "<div id=\"analysis\"></div>
		<script>$(function(){
			$('#analysis').highcharts({
				chart: {
					type: 'column'
				},
				credits: {
					enabled: false
				},
				exporting: {
					enabled: true,
					sourceWidth: 1500,
					sourceHeight: 700,
					scale: 1
				},
				title: {
					text: 'Analysis - ".$year." - ".$Session->gender." - ".$Session->mandal."'
				},
				xAxis: {
					categories: [".$categories."],
					labels: {
						rotation: 300
					}
				},
				plotOptions: {
					column: {
						dataLabels: {enabled: true},
						enableMouseTracking: false
					}
				},
				series: [
					{
						name: 'Logged-in',
						data: [".$logged_in."]
					}, {
						name: 'Planned Vicharan',
						data: [".$planned."]
					}, {
						name: 'Checked-in',
						data: [".$checked_in."]
					}, {
						name: 'Vicharan Notes',
						data: [".$vicharan_notes."]
					}
				]
		});
		});</script>";
	}
}
?>