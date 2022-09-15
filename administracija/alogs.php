<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "API Logs";
	require_once 'header.php'; 
	
		
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
		if(isset($notify)){
			echo ($notify);
		}
		?>
      <div class="row">
	
	     <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="white-box">
            <h3 class="box-title">Overview API Logs</h3>
				<table class="table js-dataTable-full">
							<thead>
								<tr>
									<th style="font-size: 12px;">User</th>
									<th style="font-size: 12px;">Key</th>
									<th style="font-size: 12px;">Attacks</th>
								</tr>
							</thead>
							<tbody style="font-size: 12px;">
							<?php
							$SQLGetLogs = $odb -> query("SELECT * FROM `users_api` ORDER BY `ID` DESC LIMIT 600");
							while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC)){
								$user = $getInfo['userID'];
								// User Check
								$sales = $odb->query("SELECT `username` FROM `users` WHERE `ID` = '$user'")->fetchColumn(0);

								$key = $getInfo['key'];
								$attacks = $getInfo['attacks'];
								echo '<tr>
										<td>'.htmlspecialchars($sales).'</td>
										<td>'.htmlspecialchars($key).'<br></td>
										<td>'.htmlspecialchars($attacks).'<br></td>
									  </tr>';
							}
							?>	
							</tbody>
						</table>
			
          </div>
        </div>
		
      </div>
	  
<?php

	require_once 'footer.php';
	
?>