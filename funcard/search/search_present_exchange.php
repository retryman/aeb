<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
require_once('../tools/user.php');

$code = new users();

$list = $code->search_present_exchange();
$counts = count($list);
?>
<table>
<?php
echo '<td>礼品ID,</td><td>礼品名,</td><td>兑换时间,</td><td>发送</td><td>用户ID,</td><td>用户名,</td><td>电话,</td><td>email,</td><td>姓名,</td><td>地址,</td>';
//pid | uid | date       | send | name   | phone       | mail      | title                    | parent_name | adress
for($i = 0; $i<$counts; $i++)
{
	$pid = $list[$i]['pid'];
	$uid = $list[$i]['uid'];
	$date = date("Y-m-d", $list[$i]['date']);
	
	if($list[$i]['send'] == 0)
		$send = '否';
	else
		$send = '是';
		
	$username = $list[$i]['name'];
	$phone = $list[$i]['phone'];
	$mail = $list[$i]['mail'];
	$title = $list[$i]['title'];
	$parent_name = $list[$i]['parent_name'];
	$adress = $list[$i]['adress'];
	
	echo '<tr>';
	echo '<td>'.$pid.',</td><td>'.$title.',</td><td>'.$date.',</td><td>'.$send.'</td><td>'.$uid.',</td><td>'.$username.',</td><td>'.$phone.',</td><td>'.$mail.',</td><td>'.$parent_name.',</td><td>'.$adress.',</td>';	
	echo '</tr>';
}
?>
</table>
</body>
</html>