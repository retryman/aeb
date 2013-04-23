<?php
	setcookie("MerchantName", '', time()+2600000, "/funcard", "aierbang.org");
	//setcookie("MerchantName", $_COOKIE['MerchantName'], time()-2600000, "/");
			
	setcookie("MerchantID", '', time()+2600000, "/funcard", "aierbang.org");
	//setcookie("MerchantID", $_COOKIE['MerchantID'], time()-2600000, "/");
	$url = "../merchant.php"; 
	echo "<script language='javascript' type='text/javascript'>"; 
	echo "window.location.href='$url'"; 
	echo "</script>"; 
?>