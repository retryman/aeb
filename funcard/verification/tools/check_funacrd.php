<?php
require_once("verifi.php");
session_start();

if(isset($_POST['card_ID']))
{
	$user = new user();
	$user->card_ID = $_POST['card_ID'];
	$user->phone =  $_POST['phone'];
	
	$record = new recording();
	$record->cid = $_POST['couponid'];
	$record->used = $_POST['used'];
	
	$cid = $_POST['couponid'];
	$cardID = $user->verification_funcard();
	if($cardID)
	{
		//echo "yes";
		$_SESSION['result'] = 1;
		$_SESSION['card_id'] = $cardID;
		header("location: ../show_coupon.php?cid=".$cid);
	}
	else
	{
		//echo "no";
		$_SESSION['result'] = 0;
		header("location: ../show_coupon.php?cid=".$cid);
	}
}

?>