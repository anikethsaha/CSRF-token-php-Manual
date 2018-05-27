<?php
require 'dbconfig.php';
require './protection_tokens/session_encryption.php';

if ($_POST['actionType'] == "reg") {

	$headers = apache_request_headers();
	$msg = new \stdClass();
	# code...
	if(!isset($_COOKIE['CSRF_TOKEN_ANIKETH']) || !isset($headers['X-CSRF-TOKEN'])) {
		$msg->status = "Forbidden";
		$msg->error = "CSRF_INVALID_OR_NOT_FOUND";
	}else{

			if( $_COOKIE['CSRF_TOKEN_ANIKETH'] == $headers['X-CSRF-TOKEN'] )
			{
					$optionsForPassHash = [
						// 'salt' => base64_encode("anyEncryptedRandomString__")
						'cost' => 11
					];
					$hashpassword = password_hash($_POST['password'], PASSWORD_BCRYPT, $optionsForPassHash);
					$sql = " INSERT INTO $db.registration ( Name, Email, University, Password, Phone_Number) 
					VALUES (?, ?, ?, ?, ?)";
					

					$stmt = $dbh->prepare($sql);

					$result = $stmt->execute([$_POST['name'] , $_POST['email'] , $_POST['university'] , $hashpassword , $_POST['phone_no']]);
					if($result){
						
						// $_SESSION['user'] = $_POST['name'];   // used just for testing purpose
						$msg->status = "Success";
		
					
					}else{
					
						$msg->status = "Failed";
						$msg->error = $stmt->errorCode();


					}
				}else{
						
						$msg->status = "Forbidden";
						$msg->error = "CSRF_INVALID_OR_NOT_FOUND";
				}

				
			

	}
	echo json_encode((array)$msg);
}
if ($_POST['actionType'] == "log") {

	$headers = apache_request_headers();
	$msg = new \stdClass();
	# code...
	if(!isset($_COOKIE['CSRF_TOKEN_ANIKETH']) || !isset($headers['X-CSRF-TOKEN'])) {
		$msg->status = "Forbidden";
		$msg->error = "CSRF_INVALID_OR_NOT_FOUND";
	}else{

			if( $_COOKIE['CSRF_TOKEN_ANIKETH'] == $headers['X-CSRF-TOKEN'] )
			{
					$sql = "SELECT * FROM $db.registration WHERE Email = ? ";
					$stmt = $dbh->prepare($sql);
					$stmt->execute([$_POST['email']]); 
					$userEmailVerification = $stmt->fetchAll();
					if($userEmailVerification){
						foreach ($userEmailVerification as $user ) {
							# code...

							if( password_verify($_POST['password'] , $user['Password'])){
								$msg->status = "Success";
								session_start();


								$session_user_encrypted_value =  new session_Ecnryption(); 
								$_SESSION['user'] = $session_user_encrypted_value->Encrypt($user['Name']); 
							}else{
								$msg->status = "Failed";
								$msg->error = "INVALID_PASSWORD";
							}
						}




					}else{
						$msg->status = "Failed";
						$msg->error = "INVALID_EMAIL_ADDRESS";
					}
				
				}else{
						
						$msg->status = "Forbidden";
						$msg->error = "CSRF_INVALID_OR_NOT_FOUND";
				}

				
			

	}
	echo json_encode((array)$msg);
}





?>