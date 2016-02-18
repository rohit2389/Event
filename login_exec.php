<?php
	session_start();
	require_once('connection.php');
 
	$errmsg_arr = array();
 
	$username = $_POST['username'];
	$password = $_POST['password'];
	$varifyPassword = $password;


	$stmt = $conn ->prepare('select u.user_id, u.user_name, u.password, u.email, u.status, r.role from user as u, role as r where email="'.$username.'" AND u.user_id = r.user_id 
								OR user_name ="'.$username.'" AND u.user_id = r.user_id');
	$stmt ->execute();
 	$row_count = $stmt->rowCount();
 	$result = $stmt -> fetchAll();

 	
 	if($row_count > 0){
	 	foreach ($result as $row) {
	 		$role = ($row['role']);
	 		$password = ($row['password']);
	 		$user_id = ($row['user_id']);
	 		$status = $row['status'];
	 		$user_name = $row['user_name'];
	 		$email =$row['email'];
	 	}
	 		$key = 'Pa%sswo$rd@Encr*ypt@ion%';
	 		$data = base64_decode($password);
			$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

			$decrypted = rtrim(
			    mcrypt_decrypt(
			        MCRYPT_RIJNDAEL_128,
			        hash('sha256', $key, true),
			        substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
			        MCRYPT_MODE_CBC,
			        $iv
			    ),
			    "\0"
			);
	 	if($decrypted == $varifyPassword){
	 		if($status=='Active'){
			 		session_regenerate_id();
					$_SESSION['SESS_USER_ID'] = $user_id;
					$_SESSION['SESS_USER_USERNAME'] = $user_name;
					$_SESSION['SESS_USER_EMAIL'] = $email;
					$_SESSION['SESS_USER_ROLE'] = $role;
					$_SESSION['sess_start_time'] = time();
					session_write_close();
					
						header("location: dashboard.php");
					
				}else{
					$errmsg_arr[] = "Your account is not activated.";
					$_SESSION['status'] = 'error';
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					session_write_close();
					header("location: index.php");
					exit();
				}
	 		
	 	}else{
	 		$errmsg_arr[] = "The email or password you entered don't match.";
			$_SESSION['status'] = 'error';
		 	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: index.php");
			exit();
	 	}
	 }else{
	 	$errmsg_arr[] = "User does not exist";
		$_SESSION['status'] = 'error';
	 	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	 }

 
	
?>