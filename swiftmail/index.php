<?php
require_once 'swift/lib/swift_required.php';
function sendmail($activation_id, $email, $name){
	$subject = "Activate your account";
	$message_body = $message = "
	Dear ".$name.",
	
		Your account has been created successfully.Please click the following link to activate your account:
	http://localhost/stu_log/activation/?user_id=".$activation_id."";
	
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('frndsf4evr@gmail.com') //your gmail email account
  ->setPassword('8827127100'); //and you gmail password account

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance($subject) //your subject line
  ->setFrom(array('frndsf4evr@gmail.com' => 'UserManagement')) // from sender info 
  ->setTo(array($email)) // to recipient
  ->setBody($message_body); // your message

	if($result = $mailer->send($message)) {
		var_dump($result);
	}
}
function passRestConfirmationMail($user_id,$email,$name,$token){
	$subject = "Reset your user management password";
	$message_body = $message = "
	Dear ".$name.",
	
		Your password link has been regenerated. Please click the following link to reset your password.
	http://localhost/stu_log/recover.php?user_id=".$user_id."&token=".$token."&username=".$email."&passord-reset-req=

	

	Thanks and Regards,
	Team";
	
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('frndsf4evr@gmail.com') //your gmail email account
  ->setPassword('8827127100'); //and you gmail password account

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance($subject) //your subject line
  ->setFrom(array('frndsf4evr@gmail.com' => 'UserManagement')) // from sender info 
  ->setTo(array($email)) // to recipient
  ->setBody($message_body); // your message

	if($result = $mailer->send($message)) {
		return $result;
	}
}

function sendMaliUpdatepassword($name, $email, $password){
	$subject = "Reset your user management password";
	$message_body = $message = "
	Dear ".$name.",
	
		Your password has been updated successfully.Please click the following link to login.
	http://localhost/stu_log/.

	User Name: ".$email."
	NewPassowrd: ".$password."

	Thanks and Regards,
	Team";
	
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('frndsf4evr@gmail.com') //your gmail email account
  ->setPassword('8827127100'); //and you gmail password account

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance($subject) //your subject line
  ->setFrom(array('frndsf4evr@gmail.com' => 'UserManagement')) // from sender info 
  ->setTo(array($email)) // to recipient
  ->setBody($message_body); // your message

	if($result = $mailer->send($message)) {
		return $result;
	}
}

function passwordRecoverMail($email, $password){
	$subject = "Reset your user management password";
	$message_body = $message = "
	Dear user,
	
		Your password has been updated successfully.Please use the following username and password to login.
	http://localhost/stu_log/.

	User Name: ".$email."
	NewPassowrd: ".$password."

	Thanks and Regards,
	Team";
	
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('frndsf4evr@gmail.com') //your gmail email account
  ->setPassword('8827127100'); //and you gmail password account

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance($subject) //your subject line
  ->setFrom(array('frndsf4evr@gmail.com' => 'UserManagement')) // from sender info 
  ->setTo(array($email)) // to recipient
  ->setBody($message_body); // your message

	if($result = $mailer->send($message)) {
		return $result;
	}
}


?>