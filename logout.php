<?php
	session_start();	
	unset($_SESSION['SESS_USER_ID']);
	unset($_SESSION['SESS_USER_USERNAME']);
	unset($_SESSION['SESS_USER_EMAIL']);
	unset($_SESSION['SESS_USER_ROLE']);

	header("location: index.php");
?>