<?php
require_once 'swift/lib/swift_required.php';

if(isset($_POST['submit'])) {
	$email = $_POST['email'];
	$subject = 'Activate your account';
	$message_body = $_POST['message'];
	
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('frndsf4evr@gmail.com') //your gmail email account
  ->setPassword('8827127100'); //and you gmail password account

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance($subject) //your subject line
  ->setFrom(array('frndsf4evr@gmail.com' => 'UserManagement')) // from sender info 
  ->setTo(array($email)) // to recipient
  ->setBody($message_body); // your message

	if($result = $mailer->send($message)) {
		echo "<script>alert('Sending your message email id:$email is success.');</script>";
	}
}
//Edited by: Ronard Cauba/ronardcauba@zoho.com
//Date: 4/16/2014
?>
<html>
<head>
	<title>Sending Email using Swiftmail</title>
	<!-- Bootstrap -->
		
	<style>
		#message-style {
			padding: 20px;
			width: 210px;
			margin: 0px auto;
			margin-left: 100px;
			border: 1px solid lightgrey;
		}
		
		#message-header-style {
			height: 20px;
			padding: 10px;
			background: lightgrey;
			font-weight: bold;
			color: #069fec;
		}
	</style>
</head>
<div id="message-style">
<div id="message-header-style">
	<center>Mailing System</center>
</div>
<form class="form-horizontal" action="index.php" method="post">
	
	<div class="form-group">
		<label for="name">Email</label>
		<input type="email" name="email" id="email" value="" placeholder="Email" autofocus required style="height: 30px;" />
	</div>
	<div class="form-group">
		<label for="name">Subject</label>
		<input type="text" value="" name="subject" id="EMAIL" placeholder="Subject Line" required style="height: 30px;" />
	</div>
	<div class="control-group">
		<label for="name">Message</label>
			<textarea name="message" id="desc" class="form-control" rows="3" placeholder="Message" required></textarea>
	</div>
	<div class="control-group">
		<input type="submit" name="submit" value="Send" class="btn btn-primary"/>
	</div>
</form>
</div>