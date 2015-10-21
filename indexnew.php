<?php
header("refresh:5;url=index.php");
$status=$_GET['status'];
echo "<h1 style=\"color:green;width:100%;background-color:yellow\">$status</h1>";
$file=fopen("state.txt","r") or die ("can't open file");
$raw=fread($file,filesize("state.txt"));
$states=explode(" ",$raw);
#[0]=System Control
#[1]=Fans
#[2]=Lights
#[3]=Projector
#[4]=
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
<h1>System</h1>
<img class="icon" src="/images/Speaker.gif"/>
<div class="ClearFloat"></div>
<?php
if($states[0]==1)
{
	echo '<a href="/Actions.php?Class=Power&Action=AllOff"><img class="button" src="/images/ToggleOn.gif"/></a>';
}
else
{
	echo '<a href="/Actions.php?Class=Power&Action=AllOn"><img class="button" src="/images/ToggleOff.gif"/></a>';
}
?>


</div>
<div class="ClearFloat"></div>
<div class="SubControlZone">
<h1>Fans</h1>
<img class="icon" src="/images/Fan.gif"/>
<?php
if($states[1]==1)
{
	echo '<a href="/Actions.php?Class=Power&Action=FansOff"><img class="button" src="/images/ToggleOn.gif"/></a>';
}
else
{
	echo '<a href="/Actions.php?Class=Power&Action=FansOn"><img class="button" src="/images/ToggleOff.gif"/></a>';
}
?>
</div>
<div class="ClearFloat"></div>
<div class="SubControlZone">
<h1>Lights</h1>
<img class="icon" src="/images/RopeLight.gif"/>
<?php
if($states[2]==1)
{
	echo '<a href="/Actions.php?Class=Power&Action=LightsOff"><img class="button" src="/images/ToggleOn.gif"/></a>';
}
else
{
	echo '<a href="/Actions.php?Class=Power&Action=LightsOn"><img class="button" src="/images/ToggleOff.gif"/></a>';
}
?>
</div>
</div>
<!--End System Power Controls-->


<!--Start Projector Controls-->
<div class="ControlColumn">
<div class="ControlZone">
<h1>Projector</h1>
<img class="icon" src="/images/Projector.gif"/>
<div class="ClearFloat"></div>
<img class="button" src="/images/ToggleOff.gif"/>

</div>
<div class="ClearFloat"></div>
<div class="SubControlZone">
<h1>DVD Player</h1>
<?php
if($states[3]==2)
{
	echo '<a href="/Actions.php?Class=Projector&Action=input&src=SVD"><img class="button" src="/images/DVDPlayerGlow.gif"/></a>';
}
else
{
	echo '<a href="/Actions.php?Class=Projector&Action=input&src=SVD"><img class="button" src="/images/DVDPlayer.gif"/></a>';
}
?>

</div>
<div class="ClearFloat"></div>
<div class="SubControlZone">
<h1>Laptop</h1>


<?php
if($states[3]==1)
{
	echo '<a href="/Actions.php?Class=Projector&Action=input&src=RG1"><img class="button" src="/images/LaptopGlow.gif"/></a>';
}
else
{
	echo '<a href="/Actions.php?Class=Projector&Action=input&src=RG1"><img class="button" src="/images/Laptop.gif"/></a>';
}
?>

</div>
</div>
<!--End Projector Controls-->

<!--Start Pandora Controls
<div class="ControlColumn">
	<div class="ControlZone">
	<h1>Pandora</h1>
	<img class="icon" src="/images/Pandora.gif"/>
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
	<img class="button" src="/images/Pause.gif"/>
	</div>
	<div style="float:right; border:1px dotted; margin-right:10px;width:40%; text-align:center">
	<a href="/Actions.php?Class=Pandora&Action=Next">Skip</a>
	<img class="button" src="/images/Skip.gif"/>
	</div>
	</form>
	</div>
</div>
--><!--End Pandora Controls-->

</body></html>
