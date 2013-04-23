<?php
require_once('DB/db.php');
$option = $_POST['option'];
$cid = $_POST['cid'];
switch($option)
{
	case 1://new coupon
	{
		$priority = $_POST['priority'];
		set_priority($cid, $priority);
		echo "<a href='set_priority.php'>back</a>";
		break;
	}
	
	case 2://update coupon
	{
		$priority = $_POST['priority'];
		update_priority($cid, $priority);
		echo "<a href='set_priority.php'>back</a>";
		break;
	}
	
	case 3://delete coupon
	{
		remove_priority($cid);
		echo "<a href='set_priority.php'>back</a>";
		break;
	}
}

function set_priority($cid, $priority)
{
	$set = dbconn("insert into coupon_priority values('".$cid."', '".$priority."')");
	//mysql_free_result($set);
}

function update_priority($cid, $priority)
{
	$update = dbconn("update coupon_priority set coupon_priority = '".$priority."' where coupon_ID = '".$cid."'");
	//mysql_free_result($update);
}

function remove_priority($cid)
{
	$remove = dbconn("delete from coupon_priority where coupon_ID = '".$cid."'");
	//mysql_free_result($remove);
}
?>