<?php

	ob_start();
	session_start();
	require_once 'includes/app/config.php';
	require_once 'includes/app/init.php';
	
	if(isset($_GET['id']) && Is_Numeric($_GET['id']) && $user -> LoggedIn()){
	
		$id = (int)$_GET['id'];
		$row = $odb -> query("SELECT * FROM `plans` WHERE `ID` = '$id'") -> fetch();

		$method = $_GET['method'];
		
		$planPrice = $row['price']; 

		$username = $_SESSION['username'];
		$email = $username.'@gmail.com';
		$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://dev.sellix.io/v1/payments',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "cart": null,
    "confirmations": 1,
    "coupon_code": null,
    "credit_card": null,
    "currency": "USD",
    "custom_fields": {
        "username": "'.$username.'",
        "secret": "lunarz",
        "user_id": "'.$_SESSION['ID'].'"
    },
    "email": "'.$email.'",
    "fraud_shield": {
        "ip": "255.255.255.255",
        "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0",
        "user_language": "en-GB,fr-FR;q=0.5"
    },
    "gateway": "'.$method.'",
    "lex_payment_method": null,
    "paypal_apm": null,
    "product_id": null,
    "block_vpn_proxies": false,
    "quantity": 1,
    "return_url": "https://lunarstress.com/payment-success.php",
    "title": "Lunar Stress Payment",
    "value": '.$planPrice.',
    "webhook": "https://lunarstress.com/payment-hook.php",
    "white_label": false
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer 7rXAPNwpXA0axhxIOlCtI8bgtcFqG4DpANvcR4r57epYIIrZyqBNVCdqDqh7Rk7Y',
    'Content-Type: application/json',
    'Cookie: __cf_bm=_qd_vBmw3FT.jBUP_ygSS9U5oh_AaXzW5nQG40h9U1U-1657919603-0-AdObDXwahjcMODuVxJ4K+THnqzVYfLkIwqV+3kbD5j8WyoLT+DOwbHLoP/5W7xLAGhMvEJgwOY61m6BAojPCmTY='
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$rearray = json_decode($response);	
$url = $rearray->data->url;
		header('Location: ' . $url);
		exit;
	
	}
	else{
		header('Location: home.php');
		exit;
	}

?>