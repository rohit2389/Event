<?php
	session_start();
	if(!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) {
		header("location: http://localhost/stu_log/index.php");
		exit();
	}
$timeout = 5; // Set timeout minutes
$logout_redirect_url = "index.php"; // Set logout URL

$timeout = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['sess_start_time'])) {
    $elapsed_time = time() - $_SESSION['sess_start_time'];
    if ($elapsed_time >= $timeout) {
        // session_destroy();
        	unset($_SESSION['SESS_USER_ID']);
			unset($_SESSION['SESS_USER_USERNAME']);
			unset($_SESSION['SESS_USER_EMAIL']);
			unset($_SESSION['SESS_USER_ROLE']);

				$errmsg_arr[] = "You have been logged out due to inactivity.";
                    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                    $_SESSION['status'] = 'error';
                    session_write_close();
        header("Location: $logout_redirect_url");
        exit();
    }
}
$_SESSION['sess_start_time'] = time();
?>