  <?php
  include("header.php");
  $paginaname = 'Dashboard';

  ?>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid"> 
       <div style="float: right;" class="col-lg-4">
        <span>  
          <div id="div" style="display:none"></div>
          <img id="divimage"  style="display:inline-block;"/>
        </span>
        <div id="accordion2">
          <div class="card">
            <div class="card-header">
              <p class="alert alert-fill-primary text-center" >Is it automatic?</p>
            </div>
            <div id="collapse-6" class="collapse show" data-parent="#accordion2" style="">
              <div class="card-body">
                After purchasing a package you will receive a code in your email, just enter it, complete the captcha and click redeem, the desired plan will be automatically added to your account.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Redeem Code</h4>
            <form class="form-horizontal" method="post" onsubmit="return false;"><div id="div"></div>
              <div class="form-group">
                <label for="GiftCode" class="col-sm-12 control-label">GiftCode</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="code" id="code" placeholder="XXXXXX">
                </div>
                <br>
                <div class="form-group m-b-0">
                  <div class="col-sm-offset-3 col-sm-3">
                    <button  id="launch" onclick="redeemCode()" class="btn btn-outline btn-info">Redeem Code</button>
                  </div>
                </div>
              </div>
              
            </form>
          </div>
        </div>
      </div>

    </div>
    <script>
      function redeemCode() {
       launch.disabled = true;
       var code = $('#code').val();
			//document.getElementById("icon").style.display="inline"; 
      var xmlhttp;
      if (window.XMLHttpRequest) {
       xmlhttp=new XMLHttpRequest();
     }
     else {
       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }
     xmlhttp.onreadystatechange=function() {
       if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        launch.disabled = false;
					//document.getElementById("icon").style.display="none";
          document.getElementById("div").style.display="none";
          document.getElementById("divimage").style.display="none";
          if (xmlhttp.responseText.search("Success") != -1)
          {
            Command: toastr["success"]("Congratulations the code is activated.", "Success")

            toastr.options = {
              "closeButton": true,
              "debug": true,
              "newestOnTop": true,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": 200,
              "hideDuration": 300,
              "timeOut": 2000,
              "extendedTimeOut": 300,
              "showEasing": "swing",
              "hideEasing": "swing",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
          } else {

            Command: toastr["error"]("Something is wrong..")

            toastr.options = {
              "closeButton": true,
              "debug": true,
              "newestOnTop": true,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": 200,
              "hideDuration": 300,
              "timeOut": 2000,
              "extendedTimeOut": 300,
              "showEasing": "swing",
              "hideEasing": "swing",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            
          }
        }
      }
      xmlhttp.open("GET","ajax/redeem.php?user=<?php echo $_SESSION['ID']; ?>" + "&code=" + code,true);
      xmlhttp.send();
    }
  </script>

</div> 
</div> 
</div>			   	  
<?php
require('xwaf.php');
$xWAF = new xWAF();
$xWAF->start();
?>