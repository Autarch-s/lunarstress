<?php 

	if(basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) die("Access denied");
	ob_start();
	
	require_once 'includes/app/config.php';
	require_once 'includes/app/init.php';
	
	if (!(empty($maintaince))) {
		header('Location: maintenance.php');
		exit;
	}
	
	if (!($user -> LoggedIn()) || !($user -> notBanned($odb))){
		header('location: relogin.php');
		die();
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
<title>Lunar Stress | <?php echo $page; ?></title>
<!-- Bootstrap Core CSS -->
<link href="includes/theme/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="includes/theme/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- morris CSS -->
<link href="includes/theme/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">

<?php if($page == "Home") { ?>  <!-- Vector CSS -->
<link href="includes/theme/plugins/bower_components/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" /> 
<script src="includes/theme/plugins/bower_components/jquery/dist/jquery.min.js"></script> <?php } ?>

<?php if($page == "Attack Hub") { ?>  <!-- Vector CSS -->
<script src="includes/theme/plugins/bower_components/jquery/dist/jquery.min.js"></script><?php } ?>
<!-- animation CSS -->
<link href="includes/theme/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="includes/theme/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="includes/theme/css/colors/default-dark.css" id="theme"  rel="stylesheet">
<script src="https://kit.fontawesome.com/1fabb56182.js" crossorigin="anonymous"></script>
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
    <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"></a>
      <div class="top-left-part"><a href="home.php"> <h2> <i class=""></i><center><span>   <h2 style="color: #626ed4;"><b>Lunar Stress</b></h2></li></span></span></center></li></span></a> </h2></b><p></p></a></div>
  <ul class="nav navbar-top-links navbar-right pull-right">
  					<li style="margin-top: 10%">Welcome, <?= $_SESSION['username'] ?> </li>
        <!-- /.dropdown -->
            <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> </i><i class="fa fa-user" style="font-size: 22px" aria-hidden="true"></i> </i></b> </a>
           <ul class="dropdown-menu animated flipInY">
                <li><a href="profile.php"><i class="ti-user"></i> My Profile</a></li>
                <li><a href="support.php"><i class="ti-settings"></i> Support Tickets</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
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
        <br><li class="nav-main-heading"><center><span><li class="nav-item nav-category">Main Menu</li></span></span></center></li>
        <li> <a href="home.php" class="waves-effect"><i class="fad fa fa-home fa-fw" data-icon="v"></i> <span class="hide-menu"> Home </a></li>
        	<li> <a href="plans.php" class="waves-effect"><i class="fa fa-shopping-cart" data-icon="v"></i> <span class="hide-menu">  &nbsp; Buy Plan</span></a></li>	
    <li> <a href="#" class="waves-effect"><i class="fad fa fa-fire fa-fw" data-icon="v"></i> <span class="hide-menu"> Free Hub <span class="label label-rouded label-custom label-custom label-danger pull-right ull-right">Soon </font></a></li>
		<li> <a href="hub.php" class="waves-effect"><i class="fad fa fa-fire fa-fw" data-icon="v"></i> <span class="hide-menu"> Attack Hub <span class="label label-rouded label-custom label-custom pull-right ull-right">Online </font></a></li>
		<li> <a href="api-info.php" class="waves-effect"><i class="fas fa-server" data-icon="v"></i> <span class="hide-menu"> &nbsp; Api Access</span></a></li>
		<li> <a href="faq.php" class="waves-effect"><i class="fad fa fa-question fa-fw" data-icon="v"></i> <span class="hide-menu"> FAQ </span></a></li><br><li class="nav-main-heading"><center><span><li class="nav-item nav-category">Support</li></span></span></center></li>
		<li> <a href="https://t.me/lunarstress" target="_blank" class="waves-effect"><i class="fa-brands fa-telegram" data-icon="v"></i> <span class="hide-menu"> Telegram</span></a></li>
		<li> <a href="https://discord.gg/kEUfVvU2WS" target="_blank" class="waves-effect"><i class="fa-brands fa-discord" data-icon="v"></i> <span class="hide-menu">  Discord </span></a></li>


		
		<?php
		
				/// Admin Panel (Only Admins can see this)
				 if ($user -> isAdmin($odb)){ 
		?>
		<li class="nav-small-cap"></li>
<?php if ($user -> isStaff($odb)){  ?>
				 <?php } }?>	
      </ul>
    </div>
  </div>


  <!-- Left navbar-header end -->
