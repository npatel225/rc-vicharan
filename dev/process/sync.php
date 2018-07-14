<?php

if($Session->login){
	$sync_start = $Core->microtime_float();
	$output .= ($current=='1' OR $type=='select')           ? ',"select":'.           Sync::select() : '';
 	$output .= ($current=='1' OR $type=='session')          ? ',"session":'.          Sync::session() : '';
	$output .= ($current=='1' OR $type=='regioncenter')     ? ',"regionCenter":'.     Sync::regionCenter() : '';
	$output .= ($current=='1' OR $type=='mycheckin')        ? ',"myCheckIn":'.        Sync::myCheckIn() : '';
	$output .= ($current=='1' OR $type=='centeranalysis15') ? ',"centerAnalysis15":'. Sync::centerAnalysis15() : '';
	$output .= ($current=='2' OR $type=='centeranalysis16') ? ',"centerAnalysis16":'. Sync::centerAnalysis16() : '';
	$output .= ($current=='2' OR $type=='mygoals')          ? ',"myGoals":'.          Sync::myGoals() : '';
	$output .= ($current=='2' OR $type=='projects')         ? ',"projects":'.         Sync::projects() : '';
	$output .= ($current=='2' OR $type=='projects16')       ? ',"projects16":'.         Sync::projects16() : '';
	$output .= ($current=='3' OR $type=='myvicharanevents') ? ',"myVicharanEvents":'. Sync::myVicharanEvents() : '';
	$output .= ($current=='3' OR $type=='vicharannotes')    ? ',"vicharanNotes":'.    Sync::vicharanNotes() : '';
	$output .= ($current=='4' OR $type=='assignedcenters')  ? ',"assignedCenters":'.  Sync::assignedCenters() : '';
	$output .= ($current=='4' OR $type=='checkedincenters') ? ',"checkedInCenters":'. Sync::checkedInCenters() : '';
	$output .= ($current=='5' OR $type=='checkedindates')   ? ',"checkedInDates":'.   Sync::checkedInDates() : '';
	$output .= ($current=='5' OR $type=='plannedusers')     ? ',"plannedUsers":'.     Sync::plannedUsers() : '';
	$output .= ($current=='6' OR $type=='planneddates')     ? ',"plannedDates":'.     Sync::plannedDates() : '';
	$output .= ($current=='6' OR $type=='profiles')         ? ',"profiles":'.         Sync::profiles() : '';
	$output .= ($current=='6' OR $type=='checkedinusers')   ? ',"checkedInUsers":'.   Sync::checkedInUsers() : '';
	if(empty($type)){
		$output .= ',"loop":"6"';
		$output .= ',"current":"'.($current+1).'"';
		$output .= ',"type":"'.$type.'"';
	}
	$sync_end = $Core->microtime_float();
	$sync_time = $sync_end-$sync_start;
	$output .= ',"sync_time":"'.$sync_time.' seconds"';

} /* End of Session->login */
?>