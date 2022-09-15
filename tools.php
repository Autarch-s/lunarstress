<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "Tools";
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
	  <div class="col-lg-12" id="resolverz"></div>
      <div class="row">
	     <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="white-box">
		  <h3 class="box-title">Tools <i style="display: none;" id="toolz" class="fa fa-cog fa-spin"></i></h3>
           <form class="form-horizontal push-10-t push-10" action="base_forms_premade.html" method="post" onsubmit="return false;">
                                        <div class="form-group">
                                            <div class="col-xs-12">
											<label for="tool">Value</label>
                                                    <input class="form-control" type="text" name="value" id="tool">
                                                    
                                            </div>
                                        </div>         
                                        <div class="form-group">
                                            <div class="col-xs-12">
											<label for="tool">Tool</label>
                                                    <select class="form-control" id="resolver" name="resolver" size="1">
														<option value="domain">Domain to IP</option>
														<option value="geo">Geolocation</option>
                                                    </select>
                                            </div>
                                        </div>                   
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <button onclick="tools()" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Find Results</button>
                                            </div>
                                        </div>
									
                                    </form>
          </div>
        </div>
		
		 <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="white-box">
           <h3 class="box-title">Tools Information</h3>
                <dl>
                  <dt>Geo-Check</dt>
                  <dd>This tool will find the location of the target.</dd>
				  <br/>

				  <dt>Domain to IP</dt>
                  <dd>This tool will try to find the IP Address of a given domain.</dd>
				  <br/>

				   
                 
                  
                </dl>
          </div>
        </div>
      </div>
									
			<script>
			
			function tools() {
			var tool=$('#tool').val();
			var resolver=$('#resolver').val();
			document.getElementById("toolz").style.display="inline"; 
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp=new XMLHttpRequest();
			}
			else {
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("toolz").style.display="none";
					document.getElementById("resolverz").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","includes/ajax/user/tools/tools.php?type=" + resolver + "&resolve=" + tool,true);
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