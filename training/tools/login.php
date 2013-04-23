<?php
require_once('function.php');
$username = $_POST['name'];
$passowrd = $_POST['password'];

if(login($username, $passowrd))
{
	setcookie("trainingUserName", $username, time()+2600000, "/training", "aierbang.org");
	//setcookie("trainingUserName", $username, time()+2600000, "/");		
	$id = findUserIdbyName($username);
			
	setcookie("trainingUserID", $id, time()+2600000, "/training", "aierbang.org");
	//setcookie("trainingUserID", $id, time()+2600000, "/");
	$url = "../classes.php"; 
	header("location: ../classes.php"); //head to another page
}
else
{
	header("location: ../user_login.php?error=1");
}
?>