<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	$page = "API Access";
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
        <div class="col-md-12">
		 <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="white-box">
		  				<h3 class="m-b-0">API Manager<i style="display: none;" id="manage" class="fa fa-cog fa-spin" aria-hidden="true"></i></h3>
		  				<br>
		  				<p class="m-b-0">API Link</p>
		  				<input type="disabled" class="form-control" id="key" type="text" value="<?= $user->apiKey($odb) == '-1' ? 'To have API Access you need a plan.': 'https://lunarstress.com/api.php?key='.$user->apiKey($odb).'&host=[host]&port=[port]&time=[time]&method=[method]' ?>" style="background-color:  #2a3142 !important" readonly>
		  				<br>
		  				<button class="btn btn-primary" name="gen_key" onclick="generate()">Generate New Key</button>

    
						</div>
          </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
		 <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="white-box">
		  				<h3 class="m-b-0">API Information<i style="display: none;" id="manage" class="fa fa-cog fa-spin" aria-hidden="true"></i></h3>
		  				<br>
		  				<p class="m-b-0">Fields: </p>
		  				<dl>
                                    </dd><dd style="font-size:15px"><bb class="badge bg-primary">host</bb> - IPv4 Target 1.1.1.1 or Website HTTP / HTTPs
                                    </dd><dd style="font-size:15px"><bb class="badge bg-primary">port</bb> - Destination Port (0-65535)
                                    </dd><dd style="font-size:15px"><bb class="badge bg-primary">time</bb> - Attack Time (30 - 86400)
                                    </dd><dd style="font-size:15px"><bb class="badge bg-primary">method</bb> - Attack Method
                                </dd></dl>
    
						</div>
          </div>
        </div>
        <div class="col-md-6">
        	 <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="white-box">
		  				<h3 class="m-b-0">API Methods<i style="display: none;" id="manage" class="fa fa-cog fa-spin" aria-hidden="true"></i></h3>
		  				<br>
                                <dd style="font-size:15px">Amplification:<br>
                                <bb class="badge bg-primary"> NTP</bb><bb class="badge bg-primary"> DNS</bb><bb class="badge bg-primary"> OVH-AMP</bb></dd><dd style="font-size:15px">Botnet:<br>
                                <bb class="badge bg-primary"> SYN</bb><bb class="badge bg-primary"> UDP</bb><bb class="badge bg-primary"> STOMP</bb><bb class="badge bg-primary"> OVH-UDP</bb>
                              </dd><dd style="font-size:15px">Layer 7 Methods<br>
                                <bb class="badge bg-primary"> HTTP-SOCKET </bb><bb class="badge bg-primary"> TLS-V1 </bb><bb class="badge bg-primary"> TLS-V2 </bb> <bb class="badge bg-primary"> HTTP-STORM</bb><bb class="badge bg-primary"> HTTP-GET</bb>                               </dd>
    
        </div>
        </div>
        </div>

      </div>
									

      <!--/.row -->
     <script>
     	function generate() {
     		$.ajax('/generate-key.php', 
{
    dataType: 'json', // type of response data
    timeout: 500,     // timeout milliseconds
    success: function (data,status,xhr) {   // success callback function
    	$("#key").val("https://lunarstress.com/api.php?key=" + data.key + "&host=[host]&port=[port]&time=[time]&method=[method]");
    },
    error: function (jqXhr, textStatus, errorMessage) { // error callback 
    	alert("You don't have access to API.");
    }
});
     	}
     </script>
<?php

	require_once 'footer.php';
	
?>