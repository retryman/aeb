<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查找护照发送地址</title>
<link href="../CSS/coupon.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table>
<?php
require_once('../tools/function.php');
/*$adress = dbconn("select coupon_user.name,coupon_user.phone,extra_item_value.state from coupon_user,extra_item_value where extra_item_value.item_id = (select item_id from extra_item where item_name = 'adress') and extra_item_value.uid = coupon_user.uid 
union 
select coupon_user.name,coupon_user.phone,extra_item_value.state from coupon_user,extra_item_value where extra_item_value.item_id = (select item_id from extra_item where item_name = 'name') and extra_item_value.uid = coupon_user.uid;");
$adr = dbconn("select coupon_user.name,coupon_user.phone,extra_item_value.state from coupon_user,extra_item_value where extra_item_value.item_id = (select item_id from extra_item where item_name = 'adress') and extra_item_value.uid = coupon_user.uid");

$na = dbconn("select extra_item_value.state from coupon_user,extra_item_value where extra_item_value.item_id = (select item_id from extra_item where item_name = 'name') and extra_item_value.uid = coupon_user.uid");
*/

$result = dbconn("SELECT extra_item_value.uid, card.card_id, invent_code.code, coupon_user.name, coupon_user.mail,coupon_user.phone,user_extra_info.baby_name,user_extra_info.baby_sex,user_extra_info.baby_birth,user_extra_info.parent_name,user_extra_info.adress FROM coupon_user, card, extra_item_value LEFT JOIN user_extra_info ON extra_item_value.uid = user_extra_info.uid LEFT JOIN invent_code ON extra_item_value.uid = invent_code.uid WHERE extra_item_value.item_id = '1' AND coupon_user.uid = extra_item_value.uid AND card.uid = coupon_user.uid;");
//$ad = mysql_fetch_array($adress, MYSQL_ASSOC);
$list = array();

function has_pass($uid)
{
	$result = dbconn("SELECT state FROM extra_item_value WHERE uid = '".$uid."' AND item_id = '13'");
	$r = '';
	while($line  = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$r = $line['state'];
	}
	return $r;
}
		
while($line  = mysql_fetch_array($result, MYSQL_ASSOC))
{
	array_push($list, $line);
}
echo '<br/><br/><br/><br/>';
$counts = count($list);

echo '<td>ID,</td><td>护照,</td><td>用户名,</td><td>卡号,</td><td>邀请码</td><td>邮箱,</td><td>电话,</td><td>孩子姓名,</td><td>孩子性别,</td><td>孩子生日,</td><td>父母姓名,</td><td>居住地址,</td>';
for($i = 0; $i<$counts; $i++)
{
	$uid = $list[$i]['uid'];
	$name = $list[$i]['name'];
	$code = $list[$i]['code'];
	$card = $list[$i]['card_id'];
	$mail = $list[$i]['mail'];
	$phone = $list[$i]['phone'];
	$baby_name = $list[$i]['baby_name'];
	$baby_sex = $list[$i]['baby_sex'];
	$baby_birth = date('Y-m-d', $list[$i]['baby_birth']);
	$parent_name = $list[$i]['parent_name'];
	$adress = $list[$i]['adress'];
	
	if(has_pass($uid) == 1)
		$has_PP = '有';
	else
		$has_PP = '无';
	
	echo '<tr>';
	echo '<td>'.$uid.',</td><td>'.$has_PP.',</td><td>'.$name.',</td><td>'.$card.',</td><td>'.$code.',</td><td>'.$mail.',</td><td>'.$phone.',</td><td>'.$baby_name.',</td><td>'.$baby_sex.',</td><td>'.$baby_birth.',</td><td>'.$parent_name.',</td><td>'.$adress.',</td>';
	
	echo '</tr>';
}
?>
</table>
</body>
</html>