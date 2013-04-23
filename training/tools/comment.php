<?php
ob_start();
session_start();
require_once('function.php');
$text = $_POST['text'];
$user_name = $_POST['user_name'];
$class_ID = $_POST['class_ID'];
$date = $_POST['date'];
if(isset($_POST['passcode']))
{
	if ($_POST['passcode'] == $_SESSION['Checknum'])
	{
		record_comment($class_ID, $text, $user_name, $date);
	}
	else
	{
		echo "验证码错误";
	}
}
//session_destroy();
header("location: ../classes.php?class_ID=".$class_ID);
ob_end_flush();
?>