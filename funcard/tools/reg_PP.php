<?php
session_start();
ob_start();
require_once('user.php');
if(isset($_POST['passport']))
{
	$user = new users();
	$user->user_passport = $_POST['passport'];
	$result = $user->check_new_passport();//check weather the passport has been used or not exisit
	
	switch($result)
	{
		case 0:
		{
			//echo 'new one, I can use it';
			$_SESSION['passport'] = $user->user_passport;
			header("location: ../register.php");
			break;
		}
		case 1;
		{
			//echo 'used, error';
			header("location: ../register_passport.php?error=1");
			break;
		}
		case 2;
		{
			//echo 'can not find this number';
			header("location: ../register_passport.php?error=2");
			break;
		}
	}
}
?>