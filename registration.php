<?php
	session_start();
	if(isset($_SESSION['SESS_USER_ID'])){													
		header("location: dashboard.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/log.css">

<!-- jQuery library -->
<script src="./js/jquery-2.2.0.js"></script>
<script src="js/jquery.validate.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="./js/bootstrap.min.js"></script>
</head>
<script>
  
  $(function() {
  
    $("#register-form").validate({
        onkeyup: function(element){this.element(element);},    
        rules: {
            fname: {
                required: true,
                letterOnly: true
            },
            lname: {
                required: true,
                letterOnly: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                pwcheck: true
            },
            cPassword: {
                equalTo: '#password'

            },
            dob: "required",
            role: "required"
        },
        
        messages: {
            fname: {
                required: "Please enter first name",
                letterOnly: "Enter alphabets only"
            },
            lname: {
                required: "Please enter Last name",
                letterOnly: "Enter alphabets only"
            },
            email: {
                required: "Please enter email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please provide a password",
                pwcheck: "Password must have A-Z a-z 0-9 and one symbol(@#$%&*)"
            },
            cPassword: {
                equalTo: "Confirm password doesn't match"
            },
            role: "Please specify user role",
            dob: "Please enter date of birth"
        }
    });
              $.validator.addMethod("pwcheck", function(value) {
                 return /^(?=.*\d)(?=.*[@,#,$,%,&,*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z@#$%&*]{5,}$/.test(value)
              });
              $.validator.addMethod("letterOnly", function(value) {
                 return /^[A-Za-z ]+$/.test(value);
              });
  });
  
  </script>
<body>
<div class="container">
    	<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="index.php">Login</a>
							</div>						
							<div class="col-xs-6">
								<a class="active">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
							<?php
			                if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
			                    if($_SESSION['status'] == 'success'){
			                        echo '<div class="alert alert-success">';
			                    }elseif ($_SESSION['status'] == 'error') {
			                        echo '<div class="alert alert-danger">';
			                    }
			                    foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			                      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>',$msg,'</div>';
			                    }
			                      unset($_SESSION['ERRMSG_ARR']);
			                      unset($_SESSION['status']);
			                  }
			                ?>
								<form id="register-form" action="reg_exec.php" method="post" role="form">
									<div class="form-group">
										<input type="text" name="fname" class="form-control" placeholder="First Name" value="">
									</div>
									<div class="form-group">
										<input type="text" name="lname" class="form-control" placeholder="Last Name" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<input type="password" name="cPassword" class="form-control" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<select name="role" class="form-control">
	                                      <option value="Student">Student</option>
	                                      <option value="Tutor">Tutor</option>
	                                   </select>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="recover.php" tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<button type="submit" name="register" class="btn btn-success pull-right">Register Now</button>
											</div>
										</div>
									</div>								
								</form>							
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>