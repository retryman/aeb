<?php
$user = $_GET['u'];
if($user != 'edward'){
	exit;
}

include 'config.php';

$db = new DB();

//取出passport中所有用户
$sql = "select * from coupon_user cu left join user_extra_info uei on uei.uid = cu.uid";

$res = $db -> fetchAll($sql);
$i =1;
if($res){	
	foreach($res as $item){		
		$sql = "select uid from users where name = '".$item['name']."'";
		
		if($item['name']){
			$record = $db -> fetchOne($sql);
			
			if(!$record){
				$db -> query("insert into users(name,pass,mail,created,status,init) values('".$item['name']."', '".$item['password']."', '".$item['mail']."', ".time().", 1, '".$item['mail']."')");
				
				$uid = $db -> insertId();
				if($uid && $item["baby_name"]){
					$db -> query("insert into profile_values (fid, uid, value) values(2, $uid, '".$item["baby_name"]."')");
				}
				if($uid && $item["baby_birth"]){
					$year = date('Y',$item["baby_birth"]);
					$month = date('m',$item["baby_birth"]);
					$day = date('d',$item["baby_birth"]);
					$db -> query("insert into profile_values (fid, uid, value) values(5, $uid, '".serialize(array('year' => $year, 'month' => $month, 'day' => $day))."')");
				}
				if($uid && $item["baby_sex"]){
					$sex = $item["baby_sex"] == 'M'?'男':'女';
					$db -> query("insert into profile_values (fid, uid, value) values(37, $uid, '".$sex."')");
				}
			}
		}
		echo $i++;
	}
}

?>

