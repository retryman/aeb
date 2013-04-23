<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>set coupon priority</title>
</head>

<body>
<?php
require_once('function.php');

$result = dbconn("select coupon_name, coupon_ID from coupons");
$j = 1;
	echo"<table><tr><td>All coupons</br>";
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				echo $col_value;
				if($j == 0)
				{
					echo "<br/>";
					$j++;
				}
				else
				{
					echo "&nbsp;&nbsp;";
					$j--;
				}
        	}
    	}
		echo"</td></tr></table>";

$result = dbconn("select * from coupon_priority");
echo"<table><tr><td>priority coupons</br>";
$i = 1;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				echo $col_value;
				if($i == 0)
				{
					echo "<br/>";
					$i++;
				}
				else
				{
					echo "&nbsp;&nbsp;";
					$i--;
				}
        	}
    	}
		echo"</td></tr></table>";
?>

<form action="set_p.php" method="post" enctype="multipart/form-data">
<input type="text" name="cid" />coupon's id<br/>
<input type="text" name="priority" />coupon's priority<br/>
<input type="text" name="option" />1 for new coupon, 2 for change priority, 3 for delete coupon from priority table<br/>
<input type="submit" name="submit" value="submit"/>
</form>
</body>
</html>