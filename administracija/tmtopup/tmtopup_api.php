<?php
date_default_timezone_set('Asia/Bangkok');

$_CONFIG['mysql']['dbhost'] = 'mysql.hostinger.in.th';

// Username ที่ใช้เชื่อมต่อ MySQL Server

$_CONFIG['mysql']['dbuser'] = 'u790250211_zerok';

// Password ที่ใช้เชื่อมต่อ MySQL Server

$_CONFIG['mysql']['dbpw'] = 'zFToA6r4Ru';

// ชื่อฐานข้อมูลที่เราจะเติม วัน ให้

$_CONFIG['mysql']['dbname'] = 'u790250211_zerok';


/* MySQL Config | End */
// ------------------------------------------------------------------------------------------------


// ------------------------------------------------------------------------------------------------

/* จำนวน ; วัน ที่จะได้รับเมื่อเติมเงินในราคาต่างๆ  */

$_CONFIG['day'][50] = 3;					// วัน ที่ได้รับเมื่อเติมเงินราคา 50 บาท
$_CONFIG['day'][90] = 7;					// วัน ที่ได้รับเมื่อเติมเงินราคา 90 บาท
$_CONFIG['day'][300] = 30;				// วัน ที่ได้รับเมื่อเติมเงินราคา 300 บาท
$_CONFIG['day'][500] = 60;				// วัน ที่ได้รับเมื่อเติมเงินราคา 500 บาท
$_CONFIG['day'][1000] = 120;			// วัน ที่ได้รับเมื่อเติมเงินราคา 1,000 บาท

/* จำนวน วัน ที่จะได้รับเมื่อเติมเงินในราคาต่างๆ | End */
 
//--------------------------------------------------------------------------------------------------

/* จำนวน ; ID ที่จะได้รับเมื่อเติมเงินในราคาต่างๆ  */

$_CONFIG['plans'][50] = 1;					// ID ที่ได้รับเมื่อเติมเงินราคา 50 บาท
$_CONFIG['plans'][90] = 70;					// ID ที่ได้รับเมื่อเติมเงินราคา 90 บาท
$_CONFIG['plans'][300] = 69;				// ID ที่ได้รับเมื่อเติมเงินราคา 300 บาท
$_CONFIG['plans'][500] = 84;				// ID ที่ได้รับเมื่อเติมเงินราคา 500 บาท
$_CONFIG['plans'][1000] = 85;			// ID ที่ได้รับเมื่อเติมเงินราคา 1,000 บาท

/* จำนวน ID ที่จะได้รับเมื่อเติมเงินในราคาต่างๆ | End */

// ------------------------------------------------------------------------------------------------

// กำหนด API Passkey
define('API_PASSKEY', 'shooterapitmtbynnik9');


require_once('AES.php');



// ------------------------------------------------------------------------------------------------
/* เชื่อมต่อฐานข้อมูล | Begin */
mysql_connect($_CONFIG['mysql']['dbhost'],$_CONFIG['mysql']['dbuser'],$_CONFIG['mysql']['dbpw']) or die('ERROR|DB_CONN_ERROR|' . mysql_error());
mysql_select_db($_CONFIG['mysql']['dbname']) or die('ERROR|DB_SEL_ERROR|' . mysql_error());
/* เชื่อมต่อฐานข้อมูล | End */
// ------------------------------------------------------------------------------------------------


if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
if($_SERVER['REMOTE_ADDR'] == '203.146.127.115' && isset($_GET['request']))
{
    $aes = new Crypt_AES();
    $aes->setKey(API_PASSKEY);
    $_GET['request'] = base64_decode(strtr($_GET['request'], '-_,', '+/='));
    $_GET['request'] = $aes->decrypt($_GET['request']);
    if($_GET['request'] != false)
    {
        parse_str($_GET['request'],$request);
        $request['Ref1'] = base64_decode($request['Ref1']);
		
      	$result = mysql_query('SELECT * FROM `users` WHERE `id`=\'' .$request['Ref1']. '\' LIMIT 1') or die(mysql_error());

		if ($request['cardcard_amount']==50)
		{
		$upday = time()+($_CONFIG['day'][50]*86400);
		mysql_query("UPDATE `users` SET `expire` = '".$upday."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		mysql_query("UPDATE `users` SET `membership` = '".$_CONFIG['plans'][50]."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		}
		else 
		if ($request['cardcard_amount']==90)
		{
		$upday = time()+($_CONFIG['day'][90]*86400);
		mysql_query("UPDATE `users` SET `expire` = '".$upday."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		mysql_query("UPDATE `users` SET `membership` = '".$_CONFIG['plans'][90]."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		}
		else 
		if ($request['cardcard_amount']==300)
		{
		$upday = time()+($_CONFIG['day'][300]*86400);
		mysql_query("UPDATE `users` SET `expire` = '".$upday."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		mysql_query("UPDATE `users` SET `membership` = '".$_CONFIG['plans'][300]."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		}else 
		if ($request['cardcard_amount']==500)
		{
		$upday = time()+($_CONFIG['day'][500]*86400);
		mysql_query("UPDATE `users` SET `expire` = '".$upday."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		mysql_query("UPDATE `users` SET `membership` = '".$_CONFIG['plans'][500]."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		}else 
		if ($request['cardcard_amount']==1000)
		{
		$upday = time()+($_CONFIG['day'][1000]*86400);
		mysql_query("UPDATE `users` SET `expire` = '".$upday."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		mysql_query("UPDATE `users` SET `membership` = '".$_CONFIG['plans'][1000]."' WHERE `id` = '".$request['Ref1']."' LIMIT 1;");
		}	   
	  	  

        echo 'SUCCEED : '.$request['Ref1'] .'';
    }
    else
    {
        echo 'ERROR|INVALID_PASSKEY';
    }
}
else
{
    echo 'ERROR|ACCESS_DENIED';
}

?>