<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<?php
require_once('class_code.php');
$code = new code();
if(isset($_POST['number']))
{
	$code->creat_code($_POST['number'], $_POST['level']);
}

//echo $code->record_code(1, "XHOACVFO");
?>
<form action="code.php" method="post">
number<input type="text" name="number"/><br />
level<input type="text" name="level"/><br />
<input type="submit" />
</form>
<body>
</body>
</html>