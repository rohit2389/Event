<?php
	session_start();
	require_once('connection.php');
	require('swiftmail/index.php');
 
	$errmsg_arr = array();
 
	if (isset($_REQUEST['register'])) {

		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$role = $_POST['role'];

		$username = substr($fname, 0,3).substr($lname, 0,3);

		$key = 'Pa%sswo$rd@Encr*ypt@ion%';
		$string = $password;


		$iv = mcrypt_create_iv(
		    mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
		    MCRYPT_DEV_URANDOM
		);

		$password = base64_encode(
		    $iv .
		    mcrypt_encrypt(
		        MCRYPT_RIJNDAEL_128,
		        hash('sha256', $key, true),
		        $string,
		        MCRYPT_MODE_CBC,
		        $iv
		    )
		);
		$user_name = usernameExist($username, $conn);
		$userExist = userExist($email, $conn);
			if($userExist <= 0){
					$sql = "INSERT INTO user (email, password, firstname, lastname)
						    VALUES ('$email', '$password','$fname','$lname')";
						    
				    $conn->exec($sql);
				    $user_id = $conn->lastInsertId();
				    if($user_id){
				    	$stmt =  $conn->prepare("UPDATE user SET user_name = '$user_name' WHERE user_id = '$user_id'");
				        $stmt->execute();
				        $affected_rows = $stmt->rowCount();
					   	
					    $sql = "INSERT INTO role (user_id, role)
					    VALUES ('$user_id', '$role')";
					   	$conn->exec($sql);
					   	$role_id = $conn->lastInsertId();

						   	if($role_id){
								sendmail($user_id, $email, $fname);
								$errmsg_arr[] = "Your account created successfully. we sent a mail to you please varify your email id";
								$_SESSION['status'] = 'success';

							   	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
								session_write_close();
								header("location: ./index.php");
								$conn = null;
						   	}
						   	
					}
			}else{
					$errmsg_arr[] = "The email address you have entered is already registered";
						$_SESSION['status'] = 'error';
					   	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
						session_write_close();
						header("location: ./registration.php");
						$conn = null;
			}
		
		}
	function ren_gen() {
    $characters = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 3; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}

	function userExist($email, $conn){
	$sql = "select * from user
                    WHERE email = '$email'";
        $stmt = $conn ->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num_rows = count($rows);
        return $num_rows;
	}

	function usernameExist($username, $conn){
		$ren_gen = ren_gen();
		$user_name = $username.$ren_gen;
		$counting = 1;
			$sql = "select * from user
	                    WHERE user_name = '$user_name'";
	        $stmt = $conn ->prepare($sql);
	        $stmt->execute();
	        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	        $num_rows = count($rows);
	        if($num_rows > 0){
	        	usernameExist($username, $conn);
	        }else{
	        	return $user_name;
	        }
	}
?>