<?php
class Form{
	public function select_box($parent, $first_value='option', $value=''){
		global $database;
		$result = $database->result(array(__LINE__, __METHOD__, __FILE__), "SELECT name, value FROM ".DB_PREFIX."select_box WHERE parent='$parent' ORDER BY name");
		if(count($result)>0){
			$out = '<option value="">Select a '.$first_value.'</option>';
			for ($a=0; $a<count($result); $a++) { 
				$row = $result[$a];
				$selected = ($value==$row["value"]) ? "selected" : "";
				$out .= '<option value="'.$row["value"].'" '.$selected.'>'.$row["name"].'</option>';
			}
			return $out;
		}else{
			return '<option value="">No '.$first_value.' found</option>';
		}

	}
}
?>