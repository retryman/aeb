<?php
ob_start();
require_once('verifi.php');
$user = new user();
$user->username = $_POST['name'];
$user->password = $_POST['password'];
//echo $user->user_login();
if($user->user_login())
{
	setcookie("MerchantName", $user->username, time()+2600000, "/funcard", "aierbang.org");
	//setcookie("MerchantName", $user->username, time()+2600000, "/");
	$id = $user->find_merchant_id();
			
	setcookie("MerchantID", $id, time()+2600000, "/funcard", "aierbang.org");
	//setcookie("MerchantID", $id, time()+2600000, "/");
	
	$username = $_COOKIE['couponUserName'];
	$uid = $_COOKIE['couponUserID'];

	setcookie("couponUserName", $username, time()-2600000, "/funcard", "aierbang.org");
	setcookie("couponUserName", $username, time()-2600000, "/");
	//setcookie("couponUserName", $username, time()+2600000);
	
	setcookie("couponUserName", $username, time()-2600000, "/funcard", "aierbang.org");
	setcookie("couponUserName", $username, time()-2600000, "/");
	
	$url = "../merchant.php"; 
	echo "<script language='javascript' type='text/javascript'>"; 
	echo "window.location.href='$url'"; 
	echo "</script>"; 
}
else
{
	header("location: ../index.php");
}
?>