<?php
#[0]=System Control
#[1]=Fans
#[2]=Lights
#[3]=Projector Input Source
#[4]=Projector Blank State
#echo count($states);
#[5]=Projector Frozen
# Mixer PC = 00:1F:16:F8:14:C1
# OverHead PC = 00:1f:29:9c:71:39
#[6] = Childrens Room
#[8] = Stage Lights
include 'controlfunctions.php';
header("Cache-Control: no-cache, must-revalidate");
header('Location: '.$_SERVER['HTTP_REFERER']);
$Class = $_GET['Class'];
$Action = $_GET['Action'];
$Parameters = $_GET['Parameters'];
$AmpStack="192.168.10.53";
$BoothStack="192.168.10.54";
$ProjectorBridge="192.168.10.55";  #Old IP is 192.168.2.8

$file=fopen("state.txt","r") or die ("can't open file");
$raw=fread($file,filesize("state.txt"));
$states=explode(" ",$raw);
#echo count($states);
fclose($file);

echo $Class." ".$Action;




function AllOutletsOn(){
global $AmpStack,$BoothStack;
#echo "Turning everything on";
#turn SetOutlet the 
SetOutlet($BoothStack,"1","ON");
#turn SetOutlet the 
SetOutlet($BoothStack,"2","ON");
#turn SetOutlet the 
SetOutlet($BoothStack,"3","ON");
#turn SetOutlet the 
SetOutlet($BoothStack,"4","ON");
#turn SetOutlet the 
SetOutlet($BoothStack,"5","ON");
#turn SetOutlet the 
SetOutlet($BoothStack,"6","ON");
#turn SetOutlet the 
SetOutlet($BoothStack,"7","ON");
#turn SetOutlet the 
SetOutlet($BoothStack,"8","ON");

#turn SetOutlet the 
SetOutlet($AmpStack,"1","ON");
#turn SetOutlet the 
SetOutlet($AmpStack,"2","ON");
#turn SetOutlet the 
SetOutlet($AmpStack,"3","ON");
#turn SetOutlet the 
SetOutlet($AmpStack,"4","ON");
#turn SetOutlet the 
SetOutlet($AmpStack,"5","ON");
#turn SetOutlet the 
SetOutlet($AmpStack,"6","ON");
#turn SetOutlet the 
SetOutlet($AmpStack,"7","ON");
#turn SetOutlet the 
SetOutlet($AmpStack,"8","ON");
}
function AllOutletsOff(){
global $AmpStack,$BoothStack;
#echo "turning everything off";

#turn SetOutlet the 
SetOutlet($AmpStack,"1","OFF");
#turn SetOutlet the 
SetOutlet($AmpStack,"2","OFF");
#turn SetOutlet the 
SetOutlet($AmpStack,"3","OFF");
#turn SetOutlet the 
SetOutlet($AmpStack,"4","OFF");
#turn SetOutlet the 
SetOutlet($AmpStack,"5","OFF");
#turn SetOutlet the 
SetOutlet($AmpStack,"6","OFF");
#turn SetOutlet the 
SetOutlet($AmpStack,"7","OFF");
#turn SetOutlet the 
SetOutlet($AmpStack,"8","OFF");

#turn SetOutlet the 
SetOutlet($BoothStack,"1","OFF");
#turn SetOutlet the 
SetOutlet($BoothStack,"2","OFF");
#turn SetOutlet the 
SetOutlet($BoothStack,"3","OFF");
#turn SetOutlet the 
SetOutlet($BoothStack,"4","OFF");
#turn SetOutlet the 
SetOutlet($BoothStack,"5","OFF");
#turn SetOutlet the 
SetOutlet($BoothStack,"6","OFF");
#turn SetOutlet the 
SetOutlet($BoothStack,"7","OFF");
#turn SetOutlet the 
SetOutlet($BoothStack,"8","OFF");
}

function PowerFunctions(){
global $Class,$Action,$Parameters,$AmpStack,$BoothStack,$ProjectorBridge,$states;

#echo "Power Functions". $Action;
Switch ($Action)
{
	Case "AllOn":
		wol("overhead");
		wol("booth");
		SetProjector($ProjectorBridge,"PON","");
		AllOutletsOn();
		SendIR("dvd","KEY_POWER");
		$states[0]=1;
		$states[1]=1;
		$states[2]=1;
		$states[6]=1;
		$states[7]=1;
		$states[8]=1;
		break;
	Case "AllOff":
		SetProjector($ProjectorBridge,"POF","");
		AllOutletsOff();
		SendIR("dvd","KEY_POWER");
		$states[0]=0;
		$states[1]=0;
		$states[2]=0;
		$states[6]=0;
		$states[7]=0;
		$states[8]=0;
		break;
	
	Case "FansOn":
		SetOutlet($AmpStack,"8","ON");
		$states[1]=1;
		break;
	Case "FansOff":
		SetOutlet($AmpStack,"8","OFF");
		$states[1]=0;
		break;
	Case "BoothLightsOn":
		SetOutlet($BoothStack,"8","ON");
		$states[2]=1;
		break;
	Case "BoothLightsOff":
		SetOutlet($BoothStack,"8","OFF");
		$states[2]=0;
		break;
	Case "StageLightsOn":
		SetOutlet($AmpStack,"6","ON");
		SetOutlet($BoothStack,"3","ON");
		$states[8]=1;
		break;
	Case "StageLightsOff":
		SetOutlet($AmpStack,"6","OFF");
		SetOutlet($BoothStack,"3","OFF");
		$states[8]=0;
		break;
	Case "KidsOn":
		SetOutlet($BoothStack,"1","ON");
		$states[6]=1;
		break;
	Case "KidsOff":
		SetOutlet($BoothStack,"1","OFF");
		$states[6]=0;
		break;
	}

}

function PandoraFunctions()
{
	global $Class,$Action,$Parameters,$AmpStack,$BoothStack,$ProjectorBridge;
	$cmd="tmux new -d -s pianobar /usr/bin/pianobar";
	echo $cmd;
	echo system ($cmd);
	echo "Pandora Functions". $Action;
	
	Switch ($Action)
	{
		case "SetStation":
			#$r=file_put_contents('/home/pi/.config/pianobar/ctl', "$Parameters", FILE_APPEND | LOCK_EX);
			break;
		case "StartRand":
			$r=file_put_contents('/home/pi/.config/pianobar/ctl', "42\n", FILE_APPEND | LOCK_EX);
			break;
		case "Pause":
			$r=file_put_contents('/home/pi/.config/pianobar/ctl', "p\n", FILE_APPEND | LOCK_EX);
			break;
		case "Next":
			$r=file_put_contents('/home/pi/.config/pianobar/ctl', "n\n", FILE_APPEND | LOCK_EX);
			break;
	}
	
}

function DVDFunctions()
{
global $Class,$Action,$Parameters,$AmpStack,$BoothStack,$ProjectorBridge,$states;
Switch ($Action){
	case "on":
		SendIR("dvd","KEY_POWER");
		break;
	case "open":
		SendIR("dvd","KEY_OPEN");
		SetOutlet($BoothStack,"8","ON");
		$states[2]=1;
		
		break;
	}
}


function WOLFunctions()
{
	global $Class,$Action,$Parameters,$AmpStack,$BoothStack,$ProjectorBridge,$states;
	
	wol($_GET['target']);
	
}


function ProjectorFunctions(){
global $Class,$Action,$Parameters,$AmpStack,$BoothStack,$ProjectorBridge,$states;
Switch ($Action){
	case "on":
		SetProjector($ProjectorBridge,"PON","");
		$states[7]=1;
		break;
	case "off":
		SetProjector($ProjectorBridge,"POF","");
		$states[7]=0;
		break;
	case "input":
		#Values here can be VID, RG1, SVD, RG2
		#echo "setting source ".$_GET['src'];
		SetProjector($ProjectorBridge,"IIS",$_GET['src']);
		if($_GET['src']=="RG1")
		{
			$states[3]=1;
		}
		elseif($_GET['src']=="SVD")
		{
			$states[3]=2;
		}
		break;
	case "freeze":
		SetProjector($ProjectorBridge,"OFZ",$_GET['state']);
		if($_GET['state']=="0")
		{
			$states[5]=0;
		}
		elseif($_GET['state']=="1")
		{
			$states[5]=1;
		}
		break;
	case "menu":
		SetProjector($ProjectorBridge,"OMN","");
		break;
	case "up":
		SetProjector($ProjectorBridge,"OCU","");
		break;
	case "down":
		SetProjector($ProjectorBridge,"OCD","");
		break;
	case "left":
		SetProjector($ProjectorBridge,"OCL","");
		break;
	case "right":
		SetProjector($ProjectorBridge,"OCR","");
		break;
	case "shutter":
		SetProjector($ProjectorBridge,"OSH");
		if($states[4]=="1")
		{
			$states[4]=0;
		}
		elseif($states[4]=="0")
		{
			$states[4]=1;
		}
		break;
}

}


echo "Determining Class";
Switch ($Class)
{
	Case "Power":
		PowerFunctions();
		break;
	Case "Projector":
		ProjectorFunctions();
		break;
	Case "Pandora":
		PandoraFunctions();
		break;
	Case "DVD":
		DVDFunctions();
		break;
	Case "WOL":
		WOLFunctions();
		break;
}

$file=fopen("state.txt","w") or die ("can't open file");
$raw=implode(" ",$states);
fwrite($file,$raw);
#echo count($states);
fclose($file);

$to = "technology@faithcovenantonline.org";
$subject = "FCC Sound System Controller Event";
$email = "The state of one or more objects has changed.  Current state list: \r\n".implode("\r\n",$states) ;


mail($to,$subject, $email);



?>
