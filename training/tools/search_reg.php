<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>

<?php
require_once('function.php');
if(isset($_POST['class_ID']))
{
	$j = 1;
	$cid = $_POST['class_ID'];
	echo "<table><tr><td>user name</td><td>email</td><td>parent</td><td>tel</td><td>company</td><td>baby</td><td>baby birth</td><td>adress</td><tr>";
	$result = dbconn("select user_ID from training_registration where class_ID = '".$cid."'");
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{ 
        //print "\t<tr>\n"; 
        foreach ($line as $uid)
		{
			$user = dbconn("select * from training_users where user_ID = '".$uid."'");
			while ($line = mysql_fetch_array($user, MYSQL_ASSOC)) 
			{
        		//print "\t<tr>\n"; 
        		foreach ($line as $u)
				{
					//echo "<td>".$u."</td>";
					switch($j)
					{
						case 1://ID
						{
							$j++;
							break;
						}
						case 2://name
						{
							$j++;
							echo "<tr><td>".$u.",</td>";
							break;
						}
						case 3://pass
						{
							$j++;
							break;
						}
						case 4://email
						{
							$j++;
							echo "<td>".$u.",</td>";
							break;
						}
						case 5://pname
						{
							$j++;
							echo "<td>".$u.",</td>";
							break;
						}
						case 6://tel
						{
							$j++;
							echo "<td>".$u.",</td>";
							break;
						}
						case 7://company
						{
							$j++;
							echo "<td>".$u.",</td>";
							break;
						}
						case 8://baby
						{
							$j++;
							echo "<td>".$u.",</td>";
							break;
						}
						case 9://birth
						{
							$j++;
							echo "<td>".$u.",</td>";
							break;
						}
						case 10://adress
						{
							$j = 1;
							echo "<td>".$u."</td></tr>";
							break;
						}
					}
				}
			}
		}
	}
	echo "</tr></table>";
}
else
{
	$result = dbconn("select class_ID,class_title from training_classes");
	$i = 0;
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{ 
        //print "\t<tr>\n"; 
        foreach ($line as $col_value) 
		{
			if($i == 0)
			{
				$i++;
				echo $col_value."&nbsp;&nbsp;";
			}
			else
			{
				$i--;
				echo $col_value."</br>";
			}
		}
	}
}
?>
<form action="search_reg.php" method="post">
<input type="text" name="class_ID"/>
<input type="submit" value="OK" />
</form>
<a href="">刷新</a>
</body>
</html>
