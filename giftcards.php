<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "GiftCards";
	require_once 'header.php'; 
	
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
	  <div id="div"></div>
	     <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="white-box">
		  <h3 class="box-title">Redeem Code <i style="display: none;" id="icon" class="fa fa-cog fa-spin"></i></h3>
			<form class="form-horizontal" method="post" onsubmit="return false;"  >
              <div class="form-group">
                <label for="GiftCode" class="col-sm-3 control-label">GiftCode</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="code" id="code" placeholder="XXXXXX">
                </div>
              </div>
              <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-9">
                  <button  onclick="redeemCode()" class="btn btn-outline btn-info">Redeem Code</button>
                </div>
              </div>
            </form>
          </div>
        </div>
	
		
		 <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="white-box">
           <h3 class="box-title">Gift Cards</h3>
                <dl>
                  <dt>How do i redeem it?</dt>
                  <dd>You simply redeem it by placing the code in the text box to the left and click redeem and the plan will be assigned to your account!</dd>
				  <br/>
                  <dt>What do i recieve if i redeem this code?</dt>
                  <dd>The gift cards are assigned to plans when you redeem the code you will recieve a plan like you would paying for one.</dd>
				  <br/>
				   <button class="btn btn-outline btn-success" data-toggle="modal" data-target="#ticket" type="button"><i class="fa fa-pencil"></i> View Redeemed Codes</button>
				  <br/>
                 
                  
                </dl>
          </div>
        </div>
      </div>
									
			<script>
			function redeemCode() {
				var code = $('#code').val();
				document.getElementById("icon").style.display="inline"; 
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp=new XMLHttpRequest();
				}
				else {
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById("icon").style.display="none";
						document.getElementById("div").innerHTML=xmlhttp.responseText;
						if (xmlhttp.responseText.search("SUCCESS") != -1) {
							inbox();
						}
					}
				}
				xmlhttp.open("GET","includes/ajax/user/giftcodes/redeem.php?user=<?php echo $_SESSION['ID']; ?>" + "&code=" + code,true);
				xmlhttp.send();
			}
			</script>
			<div class="modal" id="ticket" tabindex="-1" role="dialog" aria-hidden="false" style="display: non;">
				<div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel1">Open New Support Ticket <i style="display: none;" id="icon" class="fa fa-cog fa-spin"></i></h4>
									  </div>
									  <div class="modal-body">
									  <div id="div"></div>
											<?php /// HERE NEEDS TO BE TERMS OF SERVICE FROM ADMIN PANEL! ?>
											<form class="form-horizontal" method="post" onsubmit="return false;">
											  <div class="form-group">
												<label for="inputEmail3" class="col-sm-3 control-label">Subject*</label>
												<div class="col-sm-9">
												  <input class="form-control" type="text" id="subject">
												</div>
											  </div>
											  <div class="form-group">
												<label for="inputEmail3" class="col-sm-3 control-label">Content*</label>
												<div class="col-sm-9">
												 <textarea class="form-control" id="content" rows="8"></textarea>
												</div>
											  </div>
											</form>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button onclick="newticket()" class="btn btn-outline btn-info"><i class="fa fa-plus"></i> Create Ticket</button>
									  </div>
									</div>
								  </div>
			</div>
      <!--/.row -->
<?php

	require_once 'footer.php';
	
?>