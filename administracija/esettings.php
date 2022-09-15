<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "Email Settings";
	require_once 'header.php'; 
	
	$updated = false;
	
	if (isset($_POST['eSettings'])){
		
		if ($_POST['e-host'] != $_POST['e-host']){
			$SQL = $odb -> prepare("UPDATE `smtpsettings` SET `host` = :sitename");
			$SQL -> execute(array(':sitename' => $_POST['e-host']));
			$Shost = $_POST['e-host'];
			$updated = true;
		}

		if ($_POST['e-auth'] != $_POST['e-auth']){
			$SQL = $odb -> prepare("UPDATE `smtpsettings` SET `host` = :sitename");
			$SQL -> execute(array(':sitename' => $_POST['e-auth']));
			$SAuth = $_POST['e-auth'];
			$updated = true;
		}
		
		if ($_POST['e-email'] != $_POST['e-email']){
			$SQL = $odb -> prepare("UPDATE `smtpsettings` SET `email` = :sitename");
			$SQL -> execute(array(':sitename' => $_POST['e-email']));
			$Susername = $_POST['e-email'];
			$updated = true;
		}
		
		if ($_POST['e-password'] != $_POST['e-password']){
			$SQL = $odb -> prepare("UPDATE `smtpsettings` SET `password` = :sitename");
			$SQL -> execute(array(':sitename' => $_POST['e-password']));
			$Spassword = $_POST['e-password'];
			$updated = true;
		}
		
		if ($_POST['e-port'] != $_POST['e-port']){
			$SQL = $odb -> prepare("UPDATE `smtpsettings` SET `port` = :sitename");
			$SQL -> execute(array(':sitename' => $_POST['e-port']));
			$Sport = $_POST['e-port'];
			$updated = true;
		}
		
		if($updated == true){
			$done = "Website settings have been updated";
		}

	}
?>


  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title"><?php echo $page; ?></h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="#"><?php echo $sitename; ?></a></li>
            <li class="active"><?php echo $page; ?></li>
          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div>
	  <?php
		if(isset($done)){
			echo success($done);
		}
		?>
      <div class="row">
	
	     <div class="col-md-6 col-sm-12 col-xs-12">
          <div class="white-box">
            <h3 class="box-title">Email Settings</h3>
				<form class="form-horizontal push-10-t" method="post">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-material">
												  <label for="site-name">Host</label>
                                                    <input class="form-control" type="text" id="site-name" name="e-host" value="<?php echo htmlspecialchars($Shost); ?>">
                                                  
                                                </div>
                                            </div>
                                        </div> 
										<div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-material">
												<label for="site-desc">Auth</label>
                                                    <select class="form-control" id="e-auth" name="e-auth" >
                                                        <option value="true">Yes</option>
														<option value="false">No</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                        </div> 
										<div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-material">
												 <label for="site-url">Email</label>
                                                    <input class="form-control" type="text" id="site-url" name="e-email" value="<?php echo htmlspecialchars($Susername); ?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-material">
												<label for="maintenance">Password</label>
                                                    <input class="form-control" type="text" id="maintenance" name="e-password" value="<?php echo htmlspecialchars($Spassword); ?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="form-material">
												<label for="google_site">Port</label>
                                                    <input class="form-control" type="text" id="google_site" name="e-port" value="<?php echo htmlspecialchars($Sport); ?>" >
                                                </div>
                                            </div>
                                        </div>									
                                        <div class="form-group">
                                            <div class="col-sm-9">
                                                <button name="eSettings" value="do" class="btn btn-sm btn-primary" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
				

          </div>
        </div>
		<div class="col-md-6 col-sm-12 col-xs-12">
          <div class="white-box">
            <h3 class="box-title">2Auth Settings</h3>
			
				

          </div>
        </div>
      </div>
	  
      <!--/.row -->
<?php

	require_once 'footer.php';
	
?>