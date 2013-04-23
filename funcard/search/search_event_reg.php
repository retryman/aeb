<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>报名查询</title>
</head>
<body>
<form action="search_event_reg.php" method="post">
<?php 
require_once('../tools/event_class.php');
$event = new events(1);
$event->search_all_title();
?>
<input type="submit" value="OK" />
</form>
<?php
if(isset($_POST['event']))
{
	echo 'id is: '.$_POST['event'].'<br>';
	$event_search = new events($_POST['event']);
	echo 'uid,name,mail,phone,other,card_id,eid,time,stage,baby_name,baby_sex,baby_birth,parent_name,adress';
	$event_search->search_reigster();
}
?>
</body>
</html>