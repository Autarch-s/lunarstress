<?php     
require_once("db.php");
require_once("init.php");

    // Fill these in with the information from your CoinPayments.net account. 
    $cp_merchant_id = '77a6d1b0958c3eb01a8184be07b98fe0'; 
    $cp_ipn_secret = '9ajncop12380'; 
    $cp_debug_email = 'grentrol192@gmail.com'; 
     
    function errorAndDie($error_msg) { 
        global $cp_debug_email; 
        if (!empty($cp_debug_email)) { 
            $report = 'Error: '.$error_msg."\n\n"; 
            $report .= "POST Data\n\n"; 
            foreach ($_POST as $k => $v) { 
                $report .= "|$k| = |$v|\n"; 
            } 
            mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
        } 
        die('IPN Error: '.$error_msg); 
    } 
     
    if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
        errorAndDie('IPN Mode is not HMAC'); 
    } 
     
    if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
        errorAndDie('No HMAC signature sent.'); 
    } 
     
    $request = file_get_contents('php://input'); 
    if ($request === FALSE || empty($request)) { 
        errorAndDie('Error reading POST data'); 
    } 
     
    if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
        errorAndDie('No or incorrect Merchant ID passed'); 
    } 
         
    $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
    if ($hmac != $_SERVER['HTTP_HMAC']) { 
        errorAndDie('HMAC signature does not match'); 
    } 
     
    // HMAC Signature verified at this point, load some variables. 

    list($points, $user_id) = explode("_", $_POST['item_number']);
	$txn_id = $_POST['txn_id']; 
    $item_name = $_POST['item_name']; 
    $amount1 = floatval($_POST['amount1']); 
    $amount2 = floatval($_POST['amount2']); 
    $currency1 = $_POST['currency1']; 
    $currency2 = $_POST['currency2']; 
    $status = intval($_POST['status']); 
    $status_text = $_POST['status_text']; 

	 //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field. 
    $order_currency = 'EUR'; 
    $order_total = (int)$points/100+1;
    //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point 

    // Check the original currency to make sure the buyer didn't change it. 
    if ($currency1 != $order_currency) { 
        errorAndDie('Original currency mismatch!'); 
    }     
     
    // Check amount against order total 
    if ($amount1 < $order_total) { 
        errorAndDie('Amount is less than order total!'); 
    } 
       $odb -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	   $usernamesql = $odb -> prepare("SELECT `username` FROM `users` WHERE `id` = :id");
	   $usernamesql -> execute(array(":id" => (int)$user_id));
	   $username = $usernamesql -> fetchColumn(0);

	   
    if ($status >= 100 || $status == 2) { 
        // payment is complete or queued for nightly payout, success 
		$SQL = $odb -> prepare("DELETE FROM `historique` WHERE `statut` = :statut AND `username` = :user");
        $SQL -> execute(array(':statut' => '<span class="label label-warning">Waiting</span>', ':user' => $username));
		
		$SQLinsert = $odb -> prepare("INSERT INTO `historique` VALUES(NULL, :licence, :statut, :username, UNIX_TIMESTAMP())");
        $SQLinsert -> execute(array(':licence' => 'Addition of '.(int)$points.' points', ':statut' => '<span class="label label-success">Paid</span>', ':username' => $username));
		
		$updateSQL = $odb -> prepare("UPDATE `users` SET `points` = points +:pts WHERE `id` = :id");
        $updateSQL -> execute(array(':pts' => (int)$points, ':id' => (int)$user_id));	  
		
		$SQLinsert = $odb -> prepare("INSERT INTO `courrier` VALUES(NULL, :sujet, :contenu, :username, 0, UNIX_TIMESTAMP())");
        $SQLinsert -> execute(array(':sujet' => 'Payment confirmation', ':contenu' => ' '.$username.', Hello,<br>
        <p>We confirm receipt of payment of your payment for the addition of '.(int)$points.' additional.<br>
        Your invoice is now available in your settings in the "Invoices" tab.<br><br>
        Need to get more information ? Feel free to <a style="color:red" href="centre-de-ticket">open a ticket</a>', ':username' => $username));

    } else if ($status < 0) { 
        //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent 
		$SQL = $odb -> prepare("DELETE FROM `historique` WHERE `statut` = :statut AND `username` = :user");
        $SQL -> execute(array(':statut' => '<span class="label label-warning">Waiting</span>', ':user' => $username));
		
		$SQLinsert = $odb -> prepare("INSERT INTO `historique` VALUES(NULL, :licence, :statut, :username, UNIX_TIMESTAMP())");
        $SQLinsert -> execute(array(':licence' => 'Addition of '.(int)$points.' points', ':statut' => '<span class="label label-danger">Failure</span>', ':username' => $username));
    } else { 
        //payment is pending, you can optionally add a note to the order page 	
		$SQLinsert = $odb -> prepare("INSERT INTO `historique` VALUES(NULL, :licence, :statut, :username, UNIX_TIMESTAMP())");
        $SQLinsert -> execute(array(':licence' => 'Addition of '.(int)$points.' points', ':statut' => '<span class="label label-warning">Waiting</span>', ':username' => $username));

    } 
    die('IPN OK'); 