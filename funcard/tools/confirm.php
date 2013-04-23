<?php
require_once('function.php');
session_start();
if(isset($_POST['card_id']))
{
	$shop_time = date("Y-m-d H:i:s");
	$item = "中国儿艺优惠";
	$card_id = $_POST['card_id'];
	$price = $_POST['price'];
	record_shop($card_id, $item, $shop_time, $price);
	$_SESSION['confirm'] = 'yes';
	header("location: ../verification.php");
}
?>