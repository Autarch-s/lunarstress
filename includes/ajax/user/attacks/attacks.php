<?php

	ob_start(); 
	require_once '../../../app/config.php';
	require_once '../../../app/init.php'; 

	if (!empty($maintaince)) {
		die($maintaince);
	}

	if (!($user->LoggedIn()) || !($user->notBanned($odb)) || !(isset($_SERVER['HTTP_REFERER']))) {
		die();
	}

	if (!($user->hasMembership($odb)) && $testboots == 0) {
		die();
	}
	
	$username = $_SESSION['username'];

?>
<table class="table table-bordered">
	<thead>
        <tr>
            <th style="font-size: 12px;"  class="text-center">Target</th>
            <th style="font-size: 12px;" class="text-center">Port</th>
            <th style="font-size: 12px;" class="text-center">Method</th>
			<th style="font-size: 12px;" class="text-center">VIP</th>
            <th style="font-size: 12px;" class="text-center">Expires</th>
			<th style="font-size: 12px;" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
<?php

    $SQLSelect = $odb->query("SELECT * FROM `logs` WHERE date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND user='{$_SESSION['username']}' ORDER BY `id` DESC LIMIT 5");

    while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)) {

        $ip = $show['ip'];
        $port = $show['port'];
        $time = $show['time'];
        $method = $odb->query("SELECT `fullname` FROM `methods` WHERE `name` = '{$show['method']}' LIMIT 1")->fetchColumn(0);
        $rowID = $show['id'];
        $date = $show['date'];
		$vip = $show['vip']; if($vip == 1) { $vip = "Yes"; } else { $vip = "No"; }
		 
        $expires = $date + $time - time();

        if ($expires < 0 || $show['stopped'] != 0) {
            $countdown = "Expired";
        }
		else {
            $countdown = '<div id="a' . $rowID . '"></div>';
            echo "
				<script id='ajax'>
					var count={$expires};
					var counter=setInterval(a{$rowID}, 1000);
					function a{$rowID}(){
						count=count-1;
						if (count <= 0){
							clearInterval(counter);
							attacks();
							return;

						}
					document.getElementById('a{$rowID}').innerHTML=count;
					}
				</script>
			";
        }

        if ($show['time'] + $show['date'] > time() and $show['stopped'] != 1) {
            $action = '<button type="button" onmousedown="bleep2.play()" onclick="stop(' . $rowID . ')" id="st" class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i> Stop</button>';
        } else {
            $action = '<button type="button" onmousedown="bleep4.play()" id="rere" onclick="renew(' . $rowID . ')" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i> Renew</button>';
        }

        echo '<tr>
		<td style="font-size: 12px;" class="text-center">' . htmlspecialchars($ip) . '</td>
		<td style="font-size: 12px;" class="text-center">' . $port . '</td>
		<td style="font-size: 12px;" class="text-center">' . $method . '</td>		
		<td style="font-size: 12px;" class="text-center">' . $vip . '</td>
		<td style="font-size: 12px;" class="text-center">' . $countdown . '</td>
		<td style="font-size: 12px;" class="text-center">' . $action . '</td>
		</tr>';

    }
?> 

	</tbody>
</table>
<html>
<head>
    <script>
 var bleep2 = new Audio();
 bleep2.src = "stop.mp3"; 
        
    var bleep4 = new Audio();
 bleep4.src = "renew.mp3";     
</script>
    </head>
</html>