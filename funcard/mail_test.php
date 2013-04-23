<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
require_once("tools/phpmailer/class.phpmailer.php");
//require("class.phpmailer.php");
if(array_key_exists('adress', $_POST))
{//send mail to this mail adress
	$adress = $_POST['adress'];
	
	//echo 'hello';
	
	$mail = new phpmailer();
	
	$mail->IsSMTP();
	$mail->Host = "smtp.sina.com.cn";//smtp server
	$mail->SMTPAuth = true;
	$mail->Username = "sizhangyu";
	$mail->Password = "70599";
	
	$mail->From = "sizhangyu@sina.com.cn";//mail box
	$mail->AddAddress($adress, "LH");//mail to
	
	$mail->Subject = "phpmailer test";
	$mail->FromName = "self";//mail sender's name
	$mail->Body = "hello";
	$mail->WordWrap = 50;
	
	if(!$mail->Send())
	{
		echo'mail send error';
		echo $mail->ErrorInfo;
	}
	else
	{
		echo'mail send successful';
	}
}
?>
<form action="mail_test.php"  method="post">
<label for="adress">mail adress</label>
<input id="adress" name="adress" type="text" />
<input type="submit" value="send mail" />
</form>
</body>
</html>