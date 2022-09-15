<?php 
ob_start();
session_start();
require_once 'includes/app/config.php';
require_once 'includes/app/init.php';
$stdin = file_get_contents('php://input');
$data = json_decode($stdin);

if (!isset($data->event)) {
	die('There was an error while accessing this page.');
}

if ($data->data->custom_fields->secret != 'lunarz') {
	die('There was an error while accessing this page.');
}

if ($data->event == 'order:paid') {
	// An order was paid
	$uniqid = $data->data->uniqid;
	$username = $data->data->custom_fields->username;
	$uid = $data->data->custom_fields->user_id;
	$userID = $uid;
	$price = $data->data->total_display;
	$method = $data->data->gateway;
	$status = "PAID";
	
	$SQL = $odb -> prepare("SELECT * FROM `plans` WHERE `price` = :price");
	$SQL -> execute(array(':price' => $price));
	$plan = $SQL -> fetch();

	$planID = $plan['ID'];

	$SQL = $odb -> prepare("INSERT INTO `payments` VALUES(NULL, :price, :planid, :userid, :payer, :transactionid, UNIX_TIMESTAMP())");
	$SQL -> execute(array(':price' => $price, ':planid' => $plan['ID'] , ':userid' => $uid, ':payer' => $username, ':transactionid' => $uniqid));

	
	// Key Gen
	function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
		return $randomString;
	}
	
	$string = generateRandomString();

	//$SQL = $odb -> prepare("INSERT INTO `users_api` VALUES(NULL, :userID, :key, :attacks,");
	//$SQL -> execute(array(':userID' => $userID, ':key' => $string, ':attacks' => '0'));
	
	$unit = $plan['unit'];
	$length = $plan['length'];
	$newExpire = strtotime("+{$length} {$unit}");
	$updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan, `api` = :skey WHERE `ID` = :id");
	$updateSQL -> execute(array(':expire' => $newExpire, ':plan' => (int)$planID, ':id' => (int)$userID, ':skey' => $string));
    

}


?>