<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邀请码使用人</title>
</head>
<?php
require_once('../tools/class_code.php');

$code = new code();

$list = $code->search_user_by_code();
$counts = count($list);
?>
<table>
<?php
echo '<td>ID,</td><td>邀请码,</td><td>护照号,</td><td>邮箱,</td><td>电话,</td><td>孩子姓名,</td><td>孩子性别,</td><td>孩子生日,</td><td>父母姓名,</td><td>居住地址,</td>';
for($i = 0; $i<$counts; $i++)
{
	$uid = $list[$i]['uid'];
	$code = $list[$i]['code'];
	$passport = $list[$i]['state'];
	$mail = $list[$i]['mail'];
	$phone = $list[$i]['phone'];
	$baby_name = $list[$i]['baby_name'];
	$baby_sex = $list[$i]['baby_sex'];
	$baby_birth = date('Y-m-d', $list[$i]['baby_birth']);
	$parent_name = $list[$i]['parent_name'];
	$adress = $list[$i]['adress'];
	
	echo '<tr>';
	echo '<td>'.$uid.',</td><td>'.$code.',</td><td>'.$passport.',</td><td>'.$mail.',</td><td>'.$phone.',</td><td>'.$baby_name.',</td><td>'.$baby_sex.',</td><td>'.$baby_birth.',</td><td>'.$parent_name.',</td><td>'.$adress.',</td>';
	
	echo '</tr>';
}
?>
</table>
<body>
</body>
</html>