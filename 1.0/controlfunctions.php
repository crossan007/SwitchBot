<?php
include "configfile.php"
function SetProjector ($IP,$Command,$Parameters){
#ftp://ftp.panasonic.com/pub/panasonic/drivers/pbts/manuals/OM_PT-LB60.55.50.232C.pdf
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($socket === false) {
		echo "failure creating socket";
	}
	else{
		echo "ok";
	}
	$result = socket_connect($socket,$IP,20108);
	if ($result === false){
		echo "socket connect failed";
	}
	else{
	 echo "ok";
	}
	if (empty($Parameters) && $Parameters != "0")
	{
		$cmd = chr(2).$Command.chr(3);
	}
	else{
		$cmd = chr(2).$Command.":".$Parameters.chr(3);
	}
	socket_write($socket, $cmd,strlen($cmd));
	echo "OK";
	
	#echo "Reading response:\n\n";
	#while ($out = socket_read($socket, 2048)) {
#		echo $out;
	#}

	echo "Closing socket...";
	socket_close($socket);
	echo "OK.\n\n";
}


function SetOutlet($IP,$Outlet,$State){
global $OutletUsername, $OutletPassword
$cmd="curl --user "$OutletUsername.":".$OutletPassword."http://".$IP."/outlet?".$Outlet."=".$State;
#echo $cmd;
system ($cmd);
}

function GetProjector($IP,$Command){
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($socket === false) {
		die("failure creating socket");
	}
	else{
		#echo "Socket Created";
	}
	$result = socket_connect($socket,$IP,20108);
	if ($result === false){
		die("socket connect failed");
	}
	else{
	 #echo "Socket Connected";
	}
	$cmd = chr(2).$Command.chr(3);
	socket_write($socket, $cmd,strlen($cmd));
	#echo "Query Written";
	socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>1, "usec"=>0));
	#echo "Reading response:\n\n";
	while ($out = socket_read($socket, 1)) {
		echo $out;
	}

	#echo "Closing socket...";
	socket_close($socket);
	#echo "OK.\n\n";
}

function GetOutlet($IP,$Outlet){

}

function SendIR($Remote,$Key) {
$cmd="irsend send_once ".$Remote." ".$Key;
#echo $cmd;
system ($cmd);
system ($cmd);

}


function wol($target)
{
	
	switch($target)
	{
		case "overhead":
		$cmd="wakeonlan 00:1F:29:9C:71:39";
		#echo $cmd;
		system ($cmd);
		break;
		
		case "booth":
		$cmd="wakeonlan 00:1F:16:F8:14:C1";
		#echo $cmd;
		system ($cmd);
		break;
	
	
	}
}


?>