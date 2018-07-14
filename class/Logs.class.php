<?php
define('FILE_EXT', '_'.SITE.'.log');
define('FOLDER_PATH', ROOT_PATH.DS.LOGS_DIR.DS);


class Logs{

	private static $_file   = FILE_EXT;
	private static $_folder = FOLDER_PATH;
	private static $_color  = array(
		'error'   => '#DD4B39',
		'log'     => '#F1C40F',
		'success' => '#A4C639'
	);
	/*
	format 
	type -- file -- line# -- log -- datetime;
	type: error, success
	file: path to file
	line#: line # where the log happen
	datetime: datetime when the log was writen
	*/

	public function write($type, $info, $log, $error){
		$filename = self::$_folder.date("Y-m-d").self::$_file;
		$array    = array(date("Y-m-d H:i:s P T"), $type, $info[2], $info[1], $info[0], $log, $error);
		$data     = ((file_exists($filename)) AND (filesize($filename)>0)) ? ',' : '';
		$data    .= json_encode($array);
		file_put_contents($filename, $data.PHP_EOL, FILE_APPEND|LOCK_EX);
	}

	public function file_list($id, $select=''){
		$logs_files = scandir(self::$_folder);
		$list = '<select id="'.$id.'" onchange="javascrit:load_log();">';
		$list.= '<option value="">Select date</option>';
		for($a=2; $a<(count($logs_files)-1); $a++){
			$selected = ($select==$logs_files[$a]) ? "selected" : "";
			$list .= '<option value="'.$logs_files[$a].'" '.$selected.'>'.$logs_files[$a].'</option>';
		}
		$list .= '</select>';
		return $list;
	}

	private function get_color($key){
		switch ($key) {
			case 'error':
				return self::$_color['error'];
				break;
			case 'log':
				return self::$_color['log'];
				break;
			case 'success':
				return self::$_color['success'];
				break;
			default:
				return null;
				break;
		}
		return $color;
	}

	public function read($file, $order=1, $type=''){
		$order     = empty($order) ? 1 : $order;
		$type      = empty($type) ? 'error' : $type;
		$file_data = '['.file_get_contents(self::$_folder.$file).']';
		$data      = json_decode($file_data, true);

		$output = '<table>';
			$output .= '<thead>
				<tr>
					<th width="5%">#</th>
					<th width="15%">Datetime</th>
					<th width="15%">File</th>
					<th width="10%">Function</th>
					<th width="5%">Line #</th>
					<th width="25%">Log</th>
					<th width="25%">Error</th>
				</tr>
			</thead>';
			$output .= '<tbody>';
			for($a=0; $a<(count($data)); $a++){
				$row = $data[$a];
				if($type==$row[1]){
					$output .= '<tr style="background-color: '.$this->get_color($row[1]).';">';
					$output .= '<th>'.($a+1).'</th>';
					for($b=0; $b<count($row); $b++){
						$row[$b] = is_array($row[$b]) ? json_encode($row[$b]) : $row[$b];
						$row[$b] = ($b==0) ? date("M d, Y h:i:s A", strtotime($row[$b])) : $row[$b];
						$output .= ($b!=1) ? '<td>'.$row[$b].'</td>' : '';
					}
					$output .= '</tr>';
				}
			}
			$output .= '</tbody>';
		$output .= '</table>';
		return $output;
	}
}
?>