<?php
require_once('function.php');

function set_cookie($username, $id)
{
	//setcookie("couponUserName", $username, time()+2600000, "/", "aierbang.org");
	setcookie("couponUserName", $username, time()+2600000);		
			
	//setcookie("couponUserID", $id, time()+2600000, "/", "aierbang.org");
	setcookie("couponUserID", $id, time()+2600000);
	$url = "../coupon.php"; 
	echo "<script language='javascript' type='text/javascript'>"; 
	echo "window.location.href='$url'"; 
	echo "</script>"; 
}
?>