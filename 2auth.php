<?php 

	ob_start();
	
	require_once 'includes/app/config.php';
	require_once 'includes/app/init.php';
	require 'includes/vendor/autoload.php';
	$authenticator = new PHPGangsta_GoogleAuthenticator();

	$tolerance = 2;
	
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



	if(isset($_POST['doAuth'])){
		
		$input = $_POST['otp-input'];
		
		
		$checkResult = $authenticator->verifyCode($AuthSecret, $input, $tolerance); 

		if ($checkResult) 
		{
			$error = success('Verfication Complete, Redirecting!');
			sleep(5);
			header('Location: home.php');
			exit;
			 
		} else {
			$error = error('Verfication Failed - Logged');
			$SQL = $odb -> prepare("INSERT INTO `loginlogs` VALUES(:username, :ip, UNIX_TIMESTAMP(), 'XX')");
			$SQL -> execute(array(':username' => $username." - 2auth failed",':ip' => $ip));
			session_start();
			unset($_SESSION['username']);
			unset($_SESSION['ID']);
			setcookie("username", "", time() + 720000);
			session_destroy();
			header('Location: login.php');
			exit();
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
<title><?php echo $sitename;?> - Login</title>
<!-- Bootstrap Core CSS -->
<link href="includes/theme/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="includes/theme/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="includes/theme/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="includes/theme/css/colors/default-dark.css" id="theme"  rel="stylesheet">
<script src='https://www.google.com/recaptcha/api.js'></script>
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
  <?php
					if(!empty($error)){
						echo ($error);
					}
				?>
    <div class="white-box">
      <form class="form-horizontal form-material" id="loginform" method="post">
        <h3 class="box-title m-b-20">Please enter the 2auth code (6 Digit Code) <?php echo $_SESSION['username']; ?></h3>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" required="" name="otp-input" placeholder="OTP Code">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button type="submit" name="doAuth" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
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

vc