<?php
if($type=='login'){

	if($Session->confirm_login($email,$password)==true){
	
		$output = '
			"success":true,
			"message":"You are now logged in!",
			"session":'.Sync::session().'
		';
	}else{
		$output = '
			"success":false,
			"message":"Invalid login credentials"
		';
	}
}
else if($type=='forgot-password'){
	$data = $Database->get_data(array(__LINE__, __METHOD__, __FILE__), 'email, first_name, profile_id', DB_PREFIX.'profiles', "email='$email'");
	if(!empty($data) && ($data[0]['email']==$email)){
		// creat reset_id and added to database
		$reset_id = $Core->rand_string(10);
		if($Database->add_reset_password(array(__LINE__, __METHOD__, __FILE__), $reset_id, $data[0]["profile_id"])){
			$message='Jay Swaminarayan '.$data[0]["first_name"].'!,<br><br>
				To reset your RC Vicharan password, simply click the link below. That will take you to a web page where you can create a new password.<br>Please note that the link will expire three hours after this email was sent.<br><br><a href="'.SITE_URL.'#reset-password/?'.$reset_id.'">Reset your RC Vicharan password</a>
			';
			$mail = Email::delevery($email, "How to reset your RC Vicharan password.", $message);
			/* If the mail is send then delete from Database */
			if($mail==1){
				$output='
					"success":true,
					"message":"A reset password link has been sent to your email. Please check you email for the link."
				';
			}else{
				$output='
					"success":false,
					"message":"We are experiencing problems sending email right now. Please try again later."
				';
			}
		}
	}else{
		$output='
			"success":false,
			"message":"Invalid email address"
		';
	}
}
else if($type=='reset-password'){
	if(!$Database->update(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'profiles', array("password" => $password), array("profile_id" => $id))){
		$output='
			"success":false,
			"message":"We are experiencing problems updating your password right now. Please contact Krupeshbhai, Mukeshbhai or Jigarbhai to reset your password."
		';
	}else{
		$Database->remove(array(__LINE__, __METHOD__, __FILE__), DB_PREFIX.'reset_password', "profile_id='$id'");
		$output='
			"success":true
		';
	}
}
?>