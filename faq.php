<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "FAQ";
	require_once 'header.php'; 
	
	/// Querys for the stats below
	if(isset($_POST['buyNow']))
	{
		$id = $_POST['buyNow'];
		$concs = $_POST['concurrents'];
		$api = $_POST['api'];
		header('Location: buy.php?id='.$id.'&concurrents='.$concs.'&api='.$api.'');
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
	    	   <h3 class="panel-title"><i class=""> <font color="#070d19"> </i><h5 align = 'right'> - </h5></h5> </font>
         <div class="row">
        <div class="col-md-12">
		  
		  <?php
				
				$i = 1;
				$SQLGetFAQ = $odb -> query("SELECT * FROM `faq` ORDER BY `id` DESC");
				while ($getInfo = $SQLGetFAQ -> fetch(PDO::FETCH_ASSOC)){
					$question = $getInfo['question'];
					$answer = $getInfo['answer'];
	
				?>
					<div id="faq<?php echo $i; ?>" class="panel-group">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">
									<a class="font-bold" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#faq<?php echo $i; ?>" href="#faq<?php echo $i; ?>_q<?php echo $i; ?>" aria-expanded="false"><?php echo $question; ?></a>
								</h3>
							</div>
							<div id="faq<?php echo $i; ?>_q<?php echo $i; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">
									<?php echo $answer; ?>
								</div>
							</div>
						</div>                               
					</div>   
				<?php
				
				$i++;
				}		
				
				?>
        </div>
      </div>
									

      <!--/.row -->
<?php

	require_once 'footer.php';
	
?>