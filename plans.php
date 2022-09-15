<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "Plans & Products";
	require_once 'header.php'; 
	
	/// Querys for the stats below
	if(isset($_POST['buyNow']))
	{
		$id = $_POST['buyNow'];
		$concs = $_POST['concurrents'];
		$api = $_POST['api'];
		header('Location: buy.php?id='.$id.'&concurrents='.$concs.'&api='.$api.'');
	}
	
	if(isset($_POST['buyNowCC']))
	{
		
		$_SESSION['CC_planID'] = $_POST['buyNowCC'];
		$_SESSION['CC_concurrents'] = $_POST['concurrents'];
		$_SESSION['CC_api'] = $_POST['api'];
		
		header('Location: cc/process.php');
	}
?>


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

      <!--/.row -->
      <!-- .row -->
      <div class="row">
	     <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="white-box">
		  <h3 class="box-title">Plans</h3>
            <table class="table table-striped table-vcenter">
								<thead>
									<tr>
																				<th class="text-center" style="font-size: 12px;">Price</th>
										<th class="text-center" style="font-size: 12px;">Attack Time</th>
										<th class="text-center" style="font-size: 12px;">Length</th>
										<th class="text-center" style="font-size: 12px;">Concurrents</th>
										<th class="text-center" style="font-size: 12px;">VIP</th>
										<th class="text-center" style="font-size: 12px;">Actions</th>
									</tr>
								</thead>
								<tbody style="font-size: 12px;" class="text-center">
								<?php
								$SQLGetPlans = $odb -> query("SELECT * FROM `plans` WHERE `private` = 0 ORDER BY `ID` ASC");
								while ($getInfo = $SQLGetPlans -> fetch(PDO::FETCH_ASSOC)){
									$id = $getInfo['ID'];
									$name = $getInfo['name'];
									$price = $getInfo['price'];
									$length = $getInfo['length'];
									$unit = $getInfo['unit'];
									$concurrents = $getInfo['concurrents'];
									$mbt = $getInfo['mbt'];
									$vip = $getInfo['vip'];
									
									if($vip == "0")
									{
										$vip = '<button type="button" class="btn btn-outline btn-danger btn-circle"><i class="fa fa-times"></i> </button>';
									}
									
									if($vip == "1")
									{
										$vip = '<button type="button" class="btn btn-outline btn-success btn-circle"><i class="fa fa-check"></i> </button>';
									}
									
									
									$ID = $getInfo['ID'];
									if($bitcoin == 1) $BitcoinAccepted = '<a href="purchase/buy_plan.php?id='.$ID.'"><button type="button" class="btn btn-warning btn-circle"><i class="fa fa-bitcoin"></i> </button></a>';
									if($paypal == 1) $PayPalAccepted = '<a href="buy.php?id='.$ID.'"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-paypal"></i> </button></a>';
									if($bitcoin == 0 && $paypal == 0) $NeitherAccepted = 'Sales are currently closed';
									echo '<h2><tr>
										<td>'.htmlspecialchars($name).'</td>
										<td>$'.htmlentities($price).'</td>
										<td>'.htmlentities($mbt).' seconds</td>
										<td>'.htmlentities($length).' '.htmlspecialchars($unit).'</td></h2>
										<td>'.($concurrents).'</td>
										<td>'.($vip).'</td>
										<td>
										<a class="link-effect" href="#" data-toggle="modal" data-target="#modal-fadein'. $id .'" ><button type="button" class="btn btn-outline btn-warning btn-circle"><i class="fa fa-shopping-basket"></i> </button></a>
										</td>
										  </tr>';
								
								?>
								<div class="modal fade" id="modal-fadein<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel1">Review Order (<?php echo $name; ?>)</h4>
									  </div>
									  <div class="modal-body">
									  <form method="post">
										<?php /// HERE NEEDS TO BE TERMS OF SERVICE FROM ADMIN PANEL! ?>
										
										<ul class="list-icons">
										  <li><i class="fa fa-chevron-right text-danger"></i> Plan Name: <?php echo $name; ?></li>
										  <li><i class="fa fa-chevron-right text-danger"></i> Plan Price: $<?php echo $price; ?></li>
										   <li><i class="fa fa-chevron-right text-danger"></i> Price (Bitcoin): <?php echo $priceOfYourItemBTC = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=".$price); ?></li>

										</ul>
										
										
									  </div>
									  <div class="modal-footer">
										<?= '<button type="submit" value="'.$id.'" name="buyNowBTC" class="btn btn-outline btn-warning"><i class="fa-brands fa-bitcoin"></i> Bitcoin</a>';  ?>
										<?= '<button type="submit" value="'.$id.'" name="buyNowETH" class="btn btn-outline btn-info"><i class="fa-brands fa-ethereum"></i> Ethereum</a>';  ?>
										<?= '<button type="submit" value="'.$id.'" name="buyNowLTC" class="btn btn-outline btn-danger"><i class="fa-solid fa-litecoin-sign"></i> Litecoin </a>';  ?>
									  </div>
									  </form>
									</div>
								  </div>
								</div>
								<?php
									} 
								?>
								</tbody>
							</table>
							<h3 class="text-center">For PayPal/Credit Card payments, contact us on Discord.</h3>
          </div>
        </div>
		
		 <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="white-box">
           <h3 class="box-title">Frequently Asked Questions</h3>
                <dl>
                  <dt>What is Attack Time?</dt>
                  <dd>Attack time is how long you can attack one target for. You can send a flood for X amount of seconds</dd>
				  <br/>
                  <dt>What is Length?</dt>
                  <dd>Once you've purchased the plan, this is how long you will have the plan for to use.</dd>
				  <br/>
                  <dt>What are concurrents?</dt>
                  <dd>Concurrents are the amount of attacks you can run at the same time</dd>
				  <br/>
                  <dt>What is VIP?</dt>
                  <dd>VIP is a system on the site that uses VIP Nodes instead of normal nodes which is able to multiply the power of your attack. <br> Having a VIP also gives you a variety of exclusive bypass methods only reserved for VIP users.</dd>
				  <br/>
                  <dt>How long does it take to get my plan?</dt>
                  <dd>Average waiting time for a plan is about 15-20 minutes, completely dependent on the crypto network confirmation.</dd>
				  <br/>
                  <dt>Will I be re-charged at the end of my subscription period?</dt>
                  <dd>No. You will have to manually have  re-purchase a package if you are interested in keeping your  membership.</dd>
                </dl>
          </div>
        </div>
      </div>
     	<div class="row">

     	</div>


	 
									

      <!--/.row -->
<?php

	require_once 'footer.php';
	
?>