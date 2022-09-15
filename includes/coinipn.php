<?php     
require_once("app/config.php");
require_once("app/init.php");

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

    list($membership_id, $user_id) = explode("_", $_POST['item_number']);
	$txn_id = $_POST['txn_id']; 
    $item_name = $_POST['item_name']; 
    $amount1 = floatval($_POST['amount1']); 
    $amount2 = floatval($_POST['amount2']); 
    $currency1 = $_POST['currency1']; 
    $currency2 = $_POST['currency2']; 
    $status = intval($_POST['status']); 
    $status_text = $_POST['status_text']; 

	 //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field. 
	$pricesql = $odb -> prepare("SELECT `eur` FROM `plans` WHERE id = :id");
    $pricesql -> execute(array(":id" => (int)$membership_id));
    $price = $pricesql -> fetchColumn(0);
    $order_currency = 'EUR'; 
    $order_total = $price;
    //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point 

    // Check the original currency to make sure the buyer didn't change it. 
    if ($currency1 != $order_currency) { 
        errorAndDie('Original currency mismatch!'); 
    }     
     
    // Check amount against order total 
    if ($amount1 < $order_total) 
	{ 
        errorAndDie('Amount is less than order total!'); 
    } 
       $odb -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	   $usernamesql = $odb -> prepare("SELECT `username` FROM `users` WHERE `ID` = :id");
	   $usernamesql -> execute(array(":id" => (int)$user_id));
	   $username = $usernamesql -> fetchColumn(0);
	   
	   $getPlanInfo = $odb -> prepare("SELECT `unit`,`length`,`name` FROM `plans` WHERE `ID` = :plan");
       $getPlanInfo -> execute(array(':plan' => (int)$membership_id));
       $plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
       $unit = $plan['unit'];
	   $name = $plan['name'];
       $length = $plan['length'];
       $newExpire = strtotime("+{$length} {$unit}");
	   $prix = $plan['price'];
		
    if ($status >= 100 || $status == 2) 
	{ 
        // payment is complete or queued for nightly payout, success 
		$updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `ID` = :id");
        $updateSQL -> execute(array(':expire' => $newExpire, ':plan' => (int)$membership_id, ':id' => (int)$user_id));	  
		


    }
    die('IPN OK'); 