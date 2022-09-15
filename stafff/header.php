<?php 

	if(basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) die("Access denied");
	ob_start();
	
	require_once '../includes/app/config.php';
	require_once '../includes/app/init.php';
	
	if (!(empty($maintaince))) {
		header('Location: maintenance.php');
		exit;
	}
	
	if (!($user -> LoggedIn()) || !($user -> notBanned($odb))){
		header('location: relogin.php');
		die();
	}


	 if(!$user->isStaff($odb)){
		header('Location: ../home.php');
		exit;
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
<title><?php echo $sitename; ?> | <?php echo $page; ?></title>
<!-- Bootstrap Core CSS -->
<link href="../includes/theme/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="../includes/theme/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- morris CSS -->
<link href="../includes/theme/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
<!-- animation CSS -->
<link href="../includes/theme/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="../includes/theme/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="../includes/theme/css/colors/default-dark.css" id="theme"  rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.bundle.js"></script>
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
<div id="wrapper">
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
      <div class="top-left-part"><a href="home.php"> <h2> <i class="fa fa-bomb"></i> <b><?php echo $sitename; ?> </h2></b><p></p></a></div>
      <ul class="nav navbar-top-links navbar-left hidden-xs">
        <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
      </ul>
      <ul class="nav navbar-top-links navbar-right pull-right">
        <!-- /.dropdown -->
        <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <b><?php echo $_SESSION['username']; ?></b> </a>
           <ul class="dropdown-menu animated flipInY">
                <li><a href="../profile.php"><i class="ti-user"></i> My Profile</a></li>
                <li><a href="../support.php"><i class="ti-settings"></i> Support Tickets</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="../logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
              </ul>
          <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
      </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
  </nav>
  <!-- Left navbar-header -->
  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
      <ul class="nav" id="side-menu">
        <?php
			/// Guest Only See Main Menu (You have to be member to see the hub)
		?>
        <li class="nav-small-cap m-t-10">--- Main & Settings</li>
		<li> <a href="home.php" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard </a></li>
        <li> <a href="support.php" class="waves-effect"><i class="fa fa-users fa-fw" data-icon="v"></i> <span class="hide-menu"> Support Tickets </a></li>
		<li> <a href="../" class="waves-effect"><i class="fa fa-arrow-left fa-fw" data-icon="v"></i> <span class="hide-menu"> Return to home </span></a></li>
		
        </li>
		</ul>
    </div>
  </div>
  <!-- Left navbar-header end -->