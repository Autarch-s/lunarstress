<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "Support";
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
      <!-- .row -->

      <!--/.row -->
      <!-- .row -->
      <div class="row">
	     <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="white-box">
		  <h3 class="box-title">Support Tickets</h3>
           <div class="content" id="messages"></div>
          </div>
        </div>
		
		 <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="white-box">
           <h3 class="box-title">Ticket Information</h3>
                <dl>
                  <dt>Support Tickets</dt>
                  <dd>We recommend you looking at our FAQ page which is located <a href="faq.php"> here</a> for questions and answers but if you are unable to find your question please open a ticket!</dd>
				  <br/>
                  <dt>Average Ticket Response</dt>
                  <dd>We are online for most of the days. Average ticket response time is 30 minutes to an hour.</dd>
				  <br/>
				   <button class="btn btn-outline btn-success" data-toggle="modal" data-target="#ticket" type="button"><i class="fa fa-pencil"></i> Open Ticket</button>
				  <br/>
                 
                  
                </dl>
          </div>
        </div>
      </div>
									
			<script>
			inbox();
			
			function inbox() {
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				}
				else {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function(){
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("messages").innerHTML = xmlhttp.responseText;
						eval(document.getElementById("ajax").innerHTML);
					}
				}
				xmlhttp.open("GET","includes/ajax/user/tickets/inbox.php",true);
				xmlhttp.send();
			}
			
			function newticket() {
				var subject = $('#subject').val();
				var content = $('#content').val();
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
				xmlhttp.open("GET","includes/ajax/user/tickets/newticket.php?subject=" + subject + "&content=" + content,true);
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