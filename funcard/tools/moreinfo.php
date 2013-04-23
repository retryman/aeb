<?php
ob_start();
session_start();
require_once('user.php');
if(isset($_POST['baby_name']))
{
	$user = new users();
	$user->baby_name = $_POST['baby_name'];
	$user->baby_sex = $_POST['baby_sex'];
	$user->parent_name = $_POST['parent_name'];
	$user->user_adress = $_POST['adress'];
	$user->user_id = $_COOKIE['couponUserID'];
	
	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$user->baby_birth = $year.'-'.$month.'-'.$day;
	//echo strtotime($user->baby_birth);
	$user -> record_aebuserinfo();
	$r = $user->record_more_info();
	if($r == 0)
	{
		if(isset($_SESSION['new_reg']) && $_SESSION['new_reg'] == 1)
		{
			header("location: ../finished.php");//first time, head to welcome page
		}
		else
		{
			header("location: ../mypage.php");//normail, head to my page
		}
	}
	else if($r == 1)
	{
		$info = array('babyname'=>$user->baby_name, 'babysex'=>$user->baby_sex, 'babybirth'=>$user->baby_birth, 'parentname'=>$user->parent_name, 'adress'=>$user->user_adress);
		$_SESSION['moreinfo'] = $info;
		header("location: ../user_info.php?error=1");
	}
}
?>