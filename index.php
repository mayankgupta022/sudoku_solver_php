<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#main
{
	background-color:#06C;
	padding:0px;
	margin:0px auto;
	position:relative;
	width:410px;
	top:10px;
}
#heading
{
	font-family:Verdana, Geneva, sans-serif;
	font-size:50px;
	color:#F90;
	text-align:center;
}
.numfield
{
	width:40px;
	height:40px;
	font-weight:bold;
	font-size:35px;
}
.buttonstyle
{
	font-weight:bold;
	font-size:35px;
}
#newbox
{
	width:410px;
}
#buttonbox
{
	text-align:center;
}
</style>
</head>

<body id="main">
<div id="heading">
SUDOKU Solver</div>
<br />
<div id="newbox">
<form action='solve.php' method='post'>
<?php
for ($i=1;$i<=9;$i++)
{
	for ($j=1;$j<=9;$j++)
	{
		echo "<input type='text' autocomplete='off' class= 'numfield' name='" . $i . $j . "' />";
		if (($j)%3==0)
			echo " ";
	}
	if (($i)%3==0)
			echo "<p style='font-size:1px; font-weight:bold; height:3px'></p>";
	else
			echo "<br />";
}
?>
<div id="buttonbox">
<input type="submit" value="SOLVE" class="buttonstyle"/><input type="reset" value="RESET" class="buttonstyle"/>
</div>
</form>
</div>
</body>
</html>