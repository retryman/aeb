<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>add_merchant</title>
</head>
<?php
require_once('verifi.php');
if(isset($_POST['merchant_name']))
{
	$merchant = new merchant();
	$merchant->name = $_POST['merchant_name'];
	$merchant->password = $_POST['password'];
	$merchant->fullname = $_POST['merchant_fullname'];
	$merchant->add_new();
}
if(isset($_FILES['file']['name']))
{
	echo $_FILES['file']['tmp_name'];
	$merchant->upload_manual($_FILES['file']['name'], $_FILES['file']['tmp_name'], $_POST['merchant_name']);
}
?>
<form action="add_merchant.php" method="post"  enctype="multipart/form-data">
merchant name<input type="text" name="merchant_name" /><br />
password<input type="password" name="password" /><br />
merchant full name<input type="text" name="merchant_fullname" /><br />
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />merchant manual, use utf-8; .txt file:
<input name="file" type="file"  value="浏览" /><br />
<input type="submit" /><br />
</form>
<body>
</body>
</html>