<?php
$username = $_COOKIE['couponUserName'];
$uid = $_COOKIE['couponUserID'];

	//setcookie("couponUserName", $username, time()-2600000, "/funcard", "aierbang.org");
	setcookie("trainingUserName", $username, time()-2600000, "/training", "aierbang.org");					
	//setcookie("couponUserID", $uid, time()-2600000, "/funcard", "aierbang.org");
	setcookie("trainingUserID", $uid, time()-2600000, "/training", "aierbang.org");
	
	header("location: ../user_login.php"); //head to another page

?>