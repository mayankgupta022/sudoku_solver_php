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
#message
{
	font-family:Verdana, Geneva, sans-serif;
	font-size:24px;
	color:#CCC;
	text-align:center;
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
<?php

function solve(&$ar,$k,&$left,&$num)
{
/*
pick 1
see if it can come in a row
for all possible poitions, check if it can come in those col
for all possible row and col, check if it can come in thos box
if possibility is only one, then fill it
pick 2
and so on
*/
	$flag1=1;
	while($flag1!=0)
	{
		$flag1=solve_by_row($ar,$k,$left,$num);
		$flag1=solve_by_col($ar,$k,$left,$num);
		$flag1=solve_by_box($ar,$k,$left,$num);
		
	}
	return $flag1;
}

function solve_by_row(&$ar,$k,&$left,&$num)
{
	$flag3=0;
	for($i=1;$i<=9;$i++)
	{
		if(check_row($ar,$i,$k))
		{
			$flag1=0;
			$flag2=0;
			for($j=1;$j<=9;$j++)
			{
				if($ar[$i][$j]=='')
					if(check_col($ar,$j,$k))
						if(check_box($ar,$i,$j,$k) && $ar[$i][$j]=='')
						{
							if($flag1!=0)
							{
								$flag2=1;
								break;
							}
							$flag1=$j;
							
						}
			}
			if($flag2==0 && $flag1!=0)
			{
				$ar[$i][$flag1]=$k;
				$left--;
				$num[$k]--;
				$flag3=1;
			}
		}
	}
	return $flag3;
}

function solve_by_col(&$ar,$k,&$left,&$num)
{
	$flag3=0;
	for($j=1;$j<=9;$j++)
	{
		if(check_col($ar,$j,$k))
		{
			$flag1=0;
			$flag2=0;
			for($i=1;$i<=9;$i++)
			{
				if($ar[$i][$j]=='')
					if(check_row($ar,$i,$k))
						if(check_box($ar,$i,$j,$k) && $ar[$i][$j]=='')
						{
							if($flag1!=0)
							{
								$flag2=1;
								break;
							}
							$flag1=$i;
							
						}
			}
			if($flag2==0 && $flag1!=0)
			{
				$ar[$flag1][$j]=$k;
				$left--;
				$num[$k]--;
				$flag3=1;
			}
		}
	}
	return $flag3;
}
function solve_by_box(&$ar,$k,&$left,&$num)
{
	$flag3=0;
	for($i=1;$i<=7;$i+=3)
	{
		for($j=1;$j<=7;$j+=3)
		{
			if(check_box($ar,$i,$j,$k))
			{
				$flag0=0;
				$flag1=0;
				$flag2=0;
				for($l=$i;$l<=$i+2;$l++)
				{
					if($ar[$i][$j]=='')
						if(check_row($ar,$l,$k))
						{
							for($m=$j;$m<=$j+2;$m++)
								if(check_col($ar,$m,$k) && $ar[$l][$m]=='')
								{
									if($flag1!=0)
									{
										$flag2=1;
										break;
									}
									$flag0=$l;
									$flag1=$m;
								}
						}
				}
				if($flag2==0 && $flag1!=0)
				{
					$ar[$flag0][$flag1]=$k;
					$left--;
					$num[$k]--;
					$flag3=1;
				}
			}
			
		}
		
	}
	
				
	return $flag3;
}

function solve_old(&$ar,$i,$j,&$left,&$num)
{
/*
Old logic
Go to empty box
pick 1;
see if row has it
see if column has it
see if box has it
if none has it, set 1 to possible
repeat for all no. upto 9
if possible only for single no., put that no.
*/

	for ($k=1;$k<=9;$k++)
		$possible[$k]=0;

		$flag1=0;
		$flag2=0;

	for ($k=1;$k<=9;$k++)
	{
		if(check_row($ar,$i,$k) && check_col($ar,$j,$k) && check_box($ar,$i,$j,$k))
		{
			$possible[$k]=1;
			if($flag1==0)
				$flag1=$k;
			else
			{
				$flag2=1;
				break;
			}
		}
	}
	if($flag2==0 && $flag1!=0)
	{
		$left--;
		$ar[$i][$j]=$flag1;
		$num[$flag1]--;
		return $flag1;
	}
	else
		return 0;
}

function check_row(&$ar,$i,$k)
{
	for($j=1;$j<=9;$j++)
		if($ar[$i][$j]==$k)
		{
			return 0;
		}
	return 1;
}

function check_col(&$ar,$j,$k)
{
	for($i=1;$i<=9;$i++)
		if($ar[$i][$j]==$k)
		{
			return 0;
		}
	return 1;
}

function check_box(&$ar,$i,$j,$k)
{
	if($i%3==0)
		$l=$i-2;
	else
		$l=$i-$i%3+1;
	if($j%3==0)
		$m=$j-2;
	else
		$m=$j-$j%3+1;

	for($i=$l;$i<=$l+2;$i++)
		for($j=$m;$j<=$m+2;$j++)
		{
			if($ar[$i][$j]==$k)
			{
				return 0;
			}
		}
	return 1;
}

//main starts here
$left=0;

for ($i=1;$i<=9;$i++)
	$num[$i]=9;
for ($i=1;$i<=9;$i++)
{
	for ($j=1;$j<=9;$j++)
	{
		$ar[$i][$j]=$_POST[$i . $j ];
		if($ar[$i][$j]=='')
		{
			$left++;
			$color[$i][$j]='black';
		}
		else
		{
			$num[$ar[$i][$j]]--;
			$color[$i][$j]='red';
		}
			
	}
}
$max=$left*2;
while($left!=0 && $max--)
{
	$flag1=0;
	//call algo2
	if($flag1==0)
	{
		for($k=1;$k<=9;$k++)
		{
			if($num[$k]>0)
				$flag1+=solve($ar,$k,$left,$num);
		}
	}
	while($flag1==0 && $left>0)
	{
		//call algo1
		$sol=$left;
		for ($i=1;$i<=9;$i++)
		{
			for ($j=1;$j<=9;$j++)
			{
				if($ar[$i][$j]=='')
				{
					$sol-=solve_old($ar, $i, $j,$left,$num);
				}
			}
		}
		if($sol==$left)
			$flag1=1;
	}
}
show($ar,$left,$max,$color);

function show(&$ar,$left,$max,$color)
{
		for ($i=1;$i<=9;$i++)
		{
			for ($j=1;$j<=9;$j++)
			{
				echo "<input type='text' readonly='readonly' class='numfield' style='color:" . $color[$i][$j] . "' value='" . $ar[$i][$j] . "' /></input>";
				if (($j)%3==0)
					echo " ";
			}
		if (($i)%3==0)
			echo "<p style='font-size:1px; font-weight:bold; height:3px'></p>";
		else
			echo "<br />";
		}
		
	echo "<div id='buttonbox'><a href='index.php'><input type='button' value='NEW' class='buttonstyle' /></a></div>";
	if($max==-1)
		echo "<p id='message'>This sudoku can't be solved further using this program.</p>";
}

?>
</body>
</html>