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

<!-- Latest compiled JavaScript -->
<script src="./js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a class="active">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="registration.php">Register</a>
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
								<form action="login_exec.php" method="post" role="form">
									<div class="form-group">
										<input type="text" name="username" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" class="form-control" placeholder="Password">
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
												<button type="submit" class="btn btn-primary pull-right">Login</button>
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