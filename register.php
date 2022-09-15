<?php 

	ob_start();
	require_once 'includes/app/config.php';
	require_once 'includes/app/init.php';

	if (!(empty($maintaince))) {
		header('Location: maintenace.php');
		exit;
	}

	//Set IP (are you using cloudflare?)
	if ($cloudflare == 1){
		$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	else{
		$ip = $user -> realIP();
	}

	//Are you already logged in?
	if ($user -> LoggedIn()){
		header('Location: home.php');
		exit;
	}
	
	//User logged in recently?
	if(!empty($_COOKIE['username'])){
		header('Location: relogin.php');
		exit;
	}

	if(isset($_POST['doCreate'])){
		$username = $_POST['register-username'];
		$email = $_POST['register-email'];
		$password = $_POST['register-password'];
		$rpassword = $_POST['register-password2'];
		$referrer = $_POST['register-referrer'];
		
		if(empty($username) || empty($email) || empty($password) || empty($rpassword)){
			$error = "Please enter all fields";
		}


		//Check if the username is legit
		if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15){
			$error = 'Username must be  alphanumberic and 4-15 characters in length';
		}
		
		//Check referral
		$referral='0';
		
		if(empty($referrer))
		{
			$referrer = '0';
		}

		//Check if user is available
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");
		$SQL -> execute(array(':username' => $username));
		$countUser = $SQL -> fetchColumn(0);
		if ($countUser > 0){
			$error = 'Username is already taken';
		}
		
		//Validate email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$error = 'Email is not a valid email address';
		}
		
		//Compare first to second password
		if ($password != $rpassword){
			$error = 'Passwords do not match';
		}
		
		//Check if email already exists
		$SQL = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = :email");
		$SQL->execute(array(':email' => $email));
		$EmailCount = $SQL->fetchColumn(0);
		if($EmailCount > 0){
			$error = 'That email is already being used';
		}
		
		//Make registeration
		if(empty($error)){
			
			/// Check if referral
			
		
					$insertUser = $odb -> prepare("INSERT INTO `users` VALUES(NULL, :username, :password, :email, 0, 0, 0, 0, :referral, 0, 0, 0, 0,  :refered, NULL)");
					$insertUser -> execute(array(':username' => $username, ':password' => SHA1(md5($password)), ':email' => $email, ':referral' => $referral, ':refered' => $referrer));
					$done = "You have succesfully created your account! Please return to login!";	
					header('Location: login.php');
				
			
			
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
<title><?php echo $sitename;?> - Register</title>
<!-- Bootstrap Core CSS -->
<link href="includes/theme/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="includes/theme/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="includes/theme/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="includes/theme/css/colors/default-dark.css" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">

  <div class="login-box">
  
    <div class="white-box">
	    <?php
					if(!empty($error)){
						echo error($error);
					}
					if(!empty($done)){
						echo success($done);
					}
				?>
      <form class="form-horizontal form-material" id="loginform" method="post">
        <h3 class="box-title m-b-20">Create a new account</h3>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" required=""  name="register-username" placeholder="Username">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" required="" name="register-email" placeholder="Email">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="password" required="" name="register-password" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" type="password" required="" name="register-password2" placeholder="Confirm Password">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
                  <button name="doCreate" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light submit-btn">Register</button>
          </div>
		          </div>

				  <html>

  </body>
</html>
                <div class="text-block text-center my-3">
                  <span class="text-small font-weight-semibold">Already have an account?</span>
                  <a href="login.php" class="text-primary m-l-5">Sign In</a>
        </div>
      </form>
    </div>
  </div>


</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel1">Terms of Services</h4>
                  </div>
                  <div class="modal-body">
				  
						<?php 

						$SQLGetNews = $odb -> query("SELECT * FROM `tos`");
						while ($getInfo = $SQLGetNews -> fetch(PDO::FETCH_ASSOC)){
						echo  $getInfo['archive'];
						}

						?>
					
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>







			
<!-- jQuery -->
<script src="includes/theme/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="includes/theme/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="includes/theme/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="includes/theme/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="includes/theme/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="includes/theme/js/custom.js"></script>
<!--Style Switcher -->
<script src="includes/theme/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>

