<?php
ob_start();
require_once('function.php');
if(isset($_GET['uid']))
{
	$uid = $_GET['uid'];
	$class_ID = $_GET['class_ID'];
	$username = $_GET['username'];
	$company = $_GET['company'];
	echo $uid,$username,$class_ID,$company;
	registration($username, $uid, $class_ID, $company);
	header("location: ../classes.php");
	   ob_end_flush();
}
?>