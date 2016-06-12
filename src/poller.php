<?php


include "configfile.php"

class property
{
	public $parent;
	public $id;
	public $name;
	public $state;
	public $args;
}
	

function getSwitchStatus($IP,$username,$password)
{
	$resultArray = array();
	$doc=new DOMDocument();
	$cmd="curl --user ".$username.":".$password."  http://".$IP."/index.htm";
	#echo $cmd;
	$page=exec($cmd,$retval);
	$page = implode("",$retval);
	$doc->loadHTML($page);
	foreach ($doc->getElementsByTagName('table') as $table)
	{
		if((strpos($table->nodeValue,'Individual Control') !== false) && (strpos($table->nodeValue,'Ethernet Power Controller') === false)) 
		{
			$rows=$table->childNodes;
			#echo $rows->length;
			for ($i=3;$i<$rows->length;$i++)
			{
				$row=$rows->item($i);
				if(get_class($row)==="DOMElement")
				{
					$p = new property();
					$p->parent = $IP;
					$p->id = $row->childNodes->item(0)->nodeValue;
					$p->name = $row->childNodes->item(1)->nodeValue;
					$p->state = $row->childNodes->item(2)->nodeValue;
					#echo $number." ".$name." ".$state."<br/>";
					$resultArray[]=$p;
				}
			}
		}
	}
	return $resultArray;
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


$resultArray = array();
$r1 = getSwitchStatus("192.168.2.54",$OutletUsername,$OutletPassword);
$r2= getSwitchStatus("192.168.2.53",$OutletUsername,$OutletPassword);
$resultArray = array_merge($r1,$r2);

foreach( $resultArray as $property)
{
	print_r ($property);
}

?>