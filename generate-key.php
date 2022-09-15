<?php 
ob_start();
session_start();
require_once 'includes/app/config.php';
require_once 'includes/app/init.php';

$userID = $_SESSION['ID'];

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

if ($user->hasMembership($odb)) {
	$updateSQL = $odb -> prepare("UPDATE `users` SET`api` = :skey WHERE `ID` = :id");
	$updateSQL -> execute(array(':id' => (int)$userID, ':skey' => $string));
	$result = ['key' => $string];
	echo json_encode($result);
}
else {
	echo "To get access to API please buy a plan.";
}

?>