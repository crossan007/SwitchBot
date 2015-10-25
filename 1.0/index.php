<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("refresh:5;url=index.php");
$status=$_GET['status'];
echo "<h1 style=\"color:green;width:100%;background-color:yellow\">$status</h1>";
$file=fopen("state.txt","r") or die ("can't open file");
$raw=fread($file,filesize("state.txt"));
$states=explode(" ",$raw);
#[0]=System Control
#[1]=Fans
#[2]=Booth Lights
#[3]=Projector Input Source
#[4]=Projector Blank State
#[5]=Projector Frozen
#[6]=Nursery Amp State
#[7]=Projector State
#[8]=Stage Lights
#echo count($states);
fclose($file);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="title">
<h1>Faith Covenant Church Sound System Controller
<?php

?>
</h1>
</div>
<!--Start System Power Controls-->
<div class="ControlColumn">
<div class="ControlZone">
<div class="ClearFloat"></div>
<?php
if($states[0]==1)
{
	echo '<h2>System: ON</h2><a href="/Actions.php?Class=Power&Action=AllOff">Turn Off</a>';
}
else
{
	echo '<h2>System: OFF</h2><a href="/Actions.php?Class=Power&Action=AllOn">Turn On</a>';
}
?>


</div>
<div class="ClearFloat"></div>


<div class="ControlZone">
<div class="ClearFloat"></div>
<?php
if($states[6]==1)
{
	echo '<h2>Nursery: ON</h2><a href="/Actions.php?Class=Power&Action=KidsOff">Turn Off</a>';
}
else
{
	echo '<h2>Nursery: OFF</h2><a href="/Actions.php?Class=Power&Action=KidsOn">Turn On</a>';
}
?>
</div>
<div class="ClearFloat"></div>


<div class="ControlZone">
<div class="ClearFloat"></div>
<?php
if($states[1]==1)
{
	echo '<h2>Fans: ON</h2><a href="/Actions.php?Class=Power&Action=FansOff">Turn Off</a>';
}
else
{
	echo '<h2>Fans: OFF</h2><a href="/Actions.php?Class=Power&Action=FansOn">Turn On</a>';
}
?>
</div>
<div class="ClearFloat"></div>
<div class="ControlZone">

<?php
if($states[2]==1)
{
	echo '<h2>Booth Lights: ON</h2><a href="/Actions.php?Class=Power&Action=BoothLightsOff">Turn Off</a>';
}
else
{
	echo '<h2>Booth Lights: OFF</h2><a href="/Actions.php?Class=Power&Action=BoothLightsOn">Turn On</a>';
}
?>
</div>
<div class="ClearFloat"></div>
<div class="ControlZone">

<?php
if($states[8]==1)
{
	echo '<h2>Stage Lights: ON</h2><a href="/Actions.php?Class=Power&Action=StageLightsOff">Turn Off</a>';
}
else
{
	echo '<h2>Stage Lights: OFF</h2><a href="/Actions.php?Class=Power&Action=StageLightsOn">Turn On</a>';
}
?>
</div>


</div>
<!--End System Power Controls-->


<!--Start Projector Controls-->
<div class="ControlColumn">
<div class="ControlZone">
<?php
if ($states[7]==0)
{
	echo '<h2>Projector: OFF</h2><a href="/Actions.php?Class=Projector&Action=on">Turn On</a><br><br>';
} 
elseif ($states[7]==1)
{
	echo '<h2>Projector: ON</h2><a href="/Actions.php?Class=Projector&Action=off">Turn Off</a><br><br>';
}

?>
</div>
<div class="ControlZone">
<?php
if ($states[3]==2)
{
	echo '<h2>Source: DVD</h2>';
	echo '<a href="/Actions.php?Class=Projector&Action=input&src=RG1">Set Laptop</a>';
} 
elseif ($states[3]==1)
{
	echo '<h2>Source: VGA</h2>';
	echo '<a href="/Actions.php?Class=Projector&Action=input&src=SVD">Set DVD</a><br><br>';
}




?>
</div>
<div class="ControlZone">
<?php
if ($states[4]==1)
{
	echo '<h2>Blanked</h2>';
	echo '<a href="/Actions.php?Class=Projector&Action=shutter">UnBlank Screen</a><br><br>';
} 
elseif ($states[4]==0)
{
	echo '<h2>UnBlanked</h2>';
	echo '<a href="/Actions.php?Class=Projector&Action=shutter">Blank Screen</a><br><br>';
}


?>

</div>

<div class="ControlZone">
<?php
if ($states[5]==1)
{
	echo '<h2>Frozen</h2>';
	echo '<a href="/Actions.php?Class=Projector&Action=freeze&state=0">Thaw Screen</a><br><br>';
} 
elseif ($states[5]==0)
{
	echo '<h2>UnFrozen</h2>';
	echo '<a href="/Actions.php?Class=Projector&Action=freeze&state=1">Freeze Screen</a><br><br>';
}


?>

</div>


</div>
<!--End Projector Controls-->




<!--Start DVD Controls-->
<!--
<div class="ControlColumn">
<div class="ControlZone">
<div class="ClearFloat"></div>
<h2>DVD Power</h2><a href="/Actions.php?Class=DVD&Action=on">DVD Power</a>
</div>
<div class="ClearFloat"></div>


<div class="ControlZone">
<h2>DVD Tray</h2><a href="/Actions.php?Class=DVD&Action=open">Open</a>
<div class="ClearFloat"></div>
</div>
<div class="ClearFloat"></div>

</div>
</div>
-->
<!--End DVD Controls-->


<!--Start Computer Controls-->
<div class="ControlColumn">
<div class="ControlZone">
<div class="ClearFloat"></div>
<h2>Booth Computer</h2><a href="/Actions.php?Class=WOL&Action=wake&target=booth">Wake</a>
</div>
<div class="ClearFloat"></div>


<div class="ControlZone">
<h2>Overhead Computer</h2><a href="/Actions.php?Class=WOL&Action=wake&target=overhead">Wake</a>
<div class="ClearFloat"></div>
</div>
<div class="ClearFloat"></div>

</div>
</div>
<!--End DVD Controls-->



<!--Start Pandora Controls
<div class="ControlColumn">
	<div class="ControlZone">
	<h1>Pandora</h1>
	<form name="RadioStation" action="Actions.php" method="get">
	<input name="Class" value="Pandora" type="hidden">
	<input name="Action" value="SetStation" type="hidden">
	<select name="Parameters">
	<Option value="6">Chris Tomlin With Matt Redman Radio</option>
	<Option value="7">Christmas Radio</option>
	<Option value="9">Classical Christmas Radio</option>
	<Option value="10">Classical for Studying Radio</option>
	<Option value="14">Family Force 5 Radio</option>
	<Option value="15">Flyleaf Radio</option>
	<Option value="16">Free Chapel Radio</option>
	<Option value="17">Gateway Worship Radio</option>
	<Option value="18">Hans Zimmer (Composer) Radio</option>
	<Option value="19">Israel Houghton Radio</option>
	<Option value="20">Jason Gray Radio</option>
	<Option value="21">Kurt Carr Radio</option>
	<Option value="22">Lecrae Radio</option>
	<Option value="24">Ludwig van Beethoven Radio</option>
	<Option value="25">Mary Mary Radio</option>
	<Option value="27">Natalie Grant Radio</option>
	<Option value="28">New Life Worship Radio</option>
	<Option value="35">Stryper Radio</option>
	<Option value="36">The David Crowder Band Radio</option>
	<Option value="37">Thousand Foot Krutch Radio</option>
	<Option value="38">Tye Tribbett Radio</option>
	<Option value="41">Worth Dying For Radio</option>
	<Option value="42">Yolanda Adams Radio</option>
	</select>
	<input type="submit" value="Submit">
	<div style="float:left; border:1px dotted;margin-left:10px; width:40%; text-align:center">
	<a href="/Actions.php?Class=Pandora&Action=Pause">Pause</a>
	
	</div>
	<div style="float:right; border:1px dotted; margin-right:10px;width:40%; text-align:center">
	<a href="/Actions.php?Class=Pandora&Action=Next">Skip</a>
	
	</div>
	</form>
	</div>
</div>
<!--End Pandora Controls-->

</body></html>
