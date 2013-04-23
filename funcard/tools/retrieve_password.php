<?php
ob_start(); 
session_start();
require_once('user.php');
if($_POST['state'] == "check_phone")
{
	//check phone number
	$user = new users();
	$user->user_name = $_POST['username'];	
	$user->phone = $_POST['phone'];
	if($user->check_phone() == 1)
	{
		//phone number is correct
		$_SESSION['username'] = $user->user_name;
		$_SESSION['retrieve_pass'] = 1;
		header("location: ../retrievepass.php");
	}
	else
	{
		$_SESSION['retrieve_pass'] = 2;//phone and user name not matched;
		header("location: ../retrievepass.php");
	}
}
else if($_POST['state'] == "change_pass")
{
	//set the new password
	$newpass = $_POST['newpass'];
	$renewpass = $_POST['renewpass'];
	
	if($newpass != $renewpass)
	{
		$_SESSION['retrieve_pass'] = 3;//new password not matched
		header("location: ../retrievepass.php");
	}
	else
	{//reset the password
		$user = new users();
		$user->user_name = $_POST['username'];
		$user->change_pass($newpass);
		$_SESSION['retrieve_pass'] = 0;//set to normal;
		header("location: ../retrievepass.php");
	}
}
?>