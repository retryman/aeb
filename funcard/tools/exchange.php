<?php
ob_start();
session_start();
require_once('present.php');
require_once('user.php');
$user = new users();
$present = new present();
if(isset($_POST['pid']))
{
	$present->pid = $_POST['pid'];
	$present->score = $user->exchange_score = $_POST['score'];
	$present->counts = $_POST['counts'];
	$user->user_score = $_POST['myscore'];
	
	if(isset($_COOKIE['couponUserID']))
	$user->user_id = $_COOKIE['couponUserID'];
	
	if($present->score > $user->user_score)
	{
		//echo 'not enoughe score';
		header("location: ../mypage.php?status=present&error=1");
		
	}
	else
	{
		//echo 'exhcange score'.$present->score;
		$status = $present->exchange($user->user_id);		
		if($status){
			$user->reduce_score();
		}
		header("location: ../mypage.php?status=present");
		$_SESSION['exchange'] = 0;
	}
}
?>