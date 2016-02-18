<?php
	session_start();
	if(isset($_SESSION['SESS_USER_ID'])){													
		header("location: dashboard.php");
	}
	include('connection.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset Account</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/log.css">
	<link href="css/font-awesome.min.css" type="text/css" />

<!-- jQuery library -->
<script src="./js/jquery-2.2.0.js"></script>
<script src="./js/jquery.validate.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="./js/bootstrap.min.js"></script>
<style type="text/css">
	.mycontent-left {
  border-left: 1px solid #DFDFDF;
  .label {width:200px;text-align:left;float:left;padding-right:10px;font-weight:bold;color: red;}
    #register-form label.error, .output {color:#FB3A3A;font-weight:normal;}
}
</style>
<script>
$(function() {
  
    $("#resetPass-form").validate({
        onkeyup: function(element){this.element(element);},    
        rules: {
            password: {
                required: true,
                pwcheck: true
            },
            cPassword: {
                equalTo: '#password'

            }
        },
        
        messages: {
            password: {
                required: "Please provide a password",
                pwcheck: "Password must have A-Z a-z 0-9 and one symbol(@#$%&*)"
            },
            cPassword: {
                equalTo: "Confirm password doesn't match"
            }        
        }
    });
              $.validator.addMethod("pwcheck", function(value) {
                 return /^(?=.*\d)(?=.*[@,#,$,%,&,*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z@#$%&*]{5,}$/.test(value)
              });
    });
  
  
</script>
</head>
<body>
<div class="container">
<div class="row">
	<div class="col-md-6 col-md-offset-3">

	<?php
	if (isset($_REQUEST['search'])) {
		$user_name = $_GET['user_name'];
		$user = userExist($user_name, $conn);
			if($user <= 0){

				$errmsg_arr[] = "No such user found.";
							$status = 'error';
							$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
							session_write_close();
							header("location: recover.php");
							exit();
			}else{
				?>
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<a class="active">Recover Account</a>
							</div>						
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
							<form id="login-form" action="recover.php" method="post" role="form">
								<div class="form-group ">
									<div class="row">
										<div class="col-lg-8">
											<input type="radio" name="user_id" value="<?php echo $user['user_id']; ?>" checked="checked"/> Email me a link to reset my password<br>
											<div style="padding-left:2em; font-size:0.8em;">
												<?php echo $user['email'];?>
											<input type="hidden" name="name" value="<?php echo $user['firstname'];?>" />
											<input type="hidden" name="email" value="<?php echo $user['email'];?>" />
											</div>
										</div>
										<div class="col-lg-4 mycontent-left">
											<img src="abc.jpg"><br/>
											<?php 
													echo $user['firstname'];
											?>
										</div>
									</div>

								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<button type="submit" name="confirm-account" class="btn btn-success">Recover Now</button>
											<a href="recover.php" class="btn btn-primary pull-right">Not You?</a>
										</div>
									</div>
								</div>								
							</form>							
							</div>
						</div>
					</div>
				</div>
				<?php
				}
			}elseif (isset($_REQUEST['confirm-account'])) {
				
				$user_id = $_POST['user_id'];
				$name = $_POST['name'];
				$email = $_POST['email'];
				$action = 'pass-reset-req';
				$token = '';
				$token = generateRandomString();

					$sql = "INSERT INTO activities (user_id, action, token)
							    VALUES ('$user_id', '$action','$token')";
							    
					    $conn->exec($sql);
					    $act_id = $conn->lastInsertId();
					    if($act_id){
					    	require('swiftmail/index.php');
						    passRestConfirmationMail($user_id,$email,$name,$token);
							    $errmsg_arr[] = "Your reset password link has been sent to your E-mail.";
								$status = 'success';
								$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
								session_write_close();
								header("location: recover.php");
								exit();
						}
			}elseif (isset($_GET['passord-reset-req'])) {
				$id = $_GET['user_id'];
				$tok = $_GET['token'];
				$user_name = $_GET['username'];

				$token = chkToken($id, $tok, $conn);
					if($token <= 0){
						$errmsg_arr[] = "Incorrect credential.";
							$_SESSION['status'] = 'error';
							$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
							session_write_close();
							header("location: index.php");
							exit();
					}else{
						?>
						<div class="panel panel-login">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-12">
									<a class="active">Reset Password</a>
								</div>						
							</div>
							<hr>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
								<form id="resetPass-form" action="recover.php" method="post" role="form">
									<div class="form-group">
										<input type="password" name="password" id="password" class="form-control" placeholder="Password">
										<input type="hidden" name="user_name" value="<?php echo $user_name;?>" />
									</div>
									<div class="form-group">
										<input type="password" name="cPassword" class="form-control" placeholder="Confirm Password">
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">Know my password
													<a href="index.php" tabindex="5" class="forgot-password">Login</a>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<button type="submit" name="reset-pass" class="btn btn-success pull-right">Reset</button>
											</div>
										</div>
									</div>				
								</form>							
								</div>
							</div>
						</div>
					</div>
					<?php
					}	
			}elseif (isset($_REQUEST['reset-pass'])) {
				$user_name = $_POST['user_name'];
				$Password = $_POST['password'];
				$newPassword = passwordHashing($Password);

				$updatePassword = updateNewPassword($newPassword, $user_name, $conn);
						if($updatePassword <= 0){
							$errmsg_arr[] = "Something went wrong please try later.";
								$status = 'error';
								$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
								session_write_close();
								header("location: recover.php");
								exit();
						}else{
							$errmsg_arr[] = "Your password has been reset successfully!.Use your new password to login again.";
								$status = 'success';
								$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
								session_write_close();
								header("location: recover.php");
								exit();
						}
					
			}else{
				?>
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<a class="active">Find Your Account</a>
							</div>						
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
						<?php 
							if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
							echo '<font color="red"><ul>';
							foreach($_SESSION['ERRMSG_ARR'] as $msg) {
								echo '<li>',$msg,'</li>'; 
								}
							echo '</ul></font>';
							unset($_SESSION['ERRMSG_ARR']);
							}
						?>
							<div class="col-lg-12">
								<form id="login-form" action="recover.php" method="get" role="form">
									<div class="form-group">
										<input type="email" name="user_name" class="form-control" placeholder="abc@domain.com" value="">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">Have an account
													<a href="index.php" tabindex="5" class="forgot-password">Login</a>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<button type="submit" name="search" class="btn btn-success pull-right">Search</button>
											</div>
										</div>
									</div>								
								</form>							
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</body>
</html>
<?php
function generateRandomString() {
    $characters = 'abcdefghijklmnopqrstuvwxyz12345ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function passwordHashing($genPassword){
		$key = 'Pa%sswo$rd@Encr*ypt@ion%';
		$string = $genPassword;


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
		return $password;
	}

function updateNewPassword($newPassword, $user_name, $conn){
		$stmt =  $conn->prepare("UPDATE user SET password = '$newPassword' WHERE email = '$user_name'");
        $stmt->execute();
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
	}

function chkToken($id, $tok, $conn){
	$sql = "select * from activities
        WHERE user_id = '$id' AND token = '$tok'";
        $stmt = $conn ->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num_rows = count($rows);
        return $num_rows;
	}

function userExist($user_name, $conn){
		$sql = "select user_id, email, firstname from user
	                    WHERE email = '$user_name'";
	        $stmt = $conn ->prepare($sql);
	        $stmt->execute();
	        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	        $num_rows = count($rows);
	        if($num_rows > 0){
	        	foreach ($rows as $row)
	        	return $row;
	        }else{
	        	return $num_rows;
	        }
	}
?>