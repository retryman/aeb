<?php
require_once('verifi.php');
session_start();
if(isset($_POST['card_id']))
{
	$record = new recording();
	$record->shop_time = date("Y-m-d H:i:s");
	$record->mid = $_COOKIE['MerchantID'];
	$record->card_id = $_POST['card_id'];
	$record->price = $_POST['price'];
	$record->cid = $_POST['couponid'];
	$record->counts = $_POST['coupon_count'];
	$record->score = $_POST['score'];
	if($_POST['price'] =="" || $_POST['coupon_count'] =="")
	{
		
		$_SESSION['confirm'] = 'no';
		//echo 'prince: '.$_POST['price'];
		//echo 'count: '.$_POST['coupon_count'];
		//header("location: ../show_coupon.php?cid=".$record->cid);
		$url = "../show_coupon.php?cid=".$record->cid; 
		echo "<script language='javascript' type='text/javascript'>"; 
		echo "window.location.href='$url'"; 
		echo "</script>"; 
	}
	else
	{
		$record->record();
		$_SESSION['confirm'] = 'yes';
		//echo 'price: '.$record->price;
		//echo 'score: '.$record->score;
		//header("location: ../show_coupon.php?cid=".$record->cid);
		
		$url = "../show_coupon.php?cid=".$record->cid; 
		echo "<script language='javascript' type='text/javascript'>"; 
		echo "window.location.href='$url'"; 
		echo "</script>";
	}
}
?>