<?php
require_once('class_record.php');
if(isset($_POST['cid']))
{
	$record = new my_record();
	//$this->uid, $this->cid, $this->mid, $this->card_id, $this->score, $this->shop_time, $this->price
	$record->uid = $_COOKIE['couponUserID'];
	$record->cid = $_POST['cid'];
	$record->mid = $_POST['mid'];
	$record->card_id = $record->find_card_by_uid();
	$record->score = $_POST['score'];
	$record->shop_time = date("Y-m-d H:i:s");
	$record->price = $_POST['price'];
	$record->counts = $_POST['count'];
	
	$record->record_all();
	
	$url = "../mypage.php"; 
	echo "<script language='javascript' type='text/javascript'>"; 
	echo "window.location.href='$url'"; 
	echo "</script>"; 
}

?>