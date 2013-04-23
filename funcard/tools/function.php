<?php
//include_once("../verification/tools/phpmailer/class.phpmailer.php");

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."DB".DIRECTORY_SEPARATOR."db.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."user.php");

global $db_G;//数据库操作对象
global $userarr;//当前用户对象
$db_G = new DB();
$userobj = new users();
$userobj -> getcurrentuser();


function Encode($str)
	{
		$code = md5($str);
		return $code;
	}

function login($name, $password)
{
	global $db_G;
	$password = Encode($password);
	
	$aebres = $db_G -> fetchOne("select uid from users where name='".$name."' and pass='$password'");

	if($aebres["uid"]){
		$result = $db_G -> fetchOne("select uid from coupon_user where name = '".$name."'");
		
	    if(!$result['uid']) //用户不存在，导入吧
		{ 
			if(!importUsers2PP($name)){
				return false;
			}
	    }

	    
    	$skey = $_COOKIE[session_name()];		
	  	$db_G -> query("UPDATE sessions SET uid = ".$aebres['uid']." , timestamp = ".time()." WHERE sid = '$skey'");	 	


	  	if ($db_G -> affectedRows() < 1) {
	   	 	$db_G -> query("INSERT INTO sessions (sid, uid,timestamp) VALUES ('".$skey."', ".$aebres['uid'].", ".time().")");
	  	}	
		
	  	$db_G -> query("UPDATE users SET access = ".time()." WHERE uid = ".$aebres['uid']);	

		
		return true;
	}
	
	return false;

}


function register($name, $password, $repassword, $email, $phone, $other)
{
	global $db_G;	
	if($password != $repassword)
	{
		//密码输入不同，请重试
		return 1;
	}
	else if(checkName($name))
	{
		$db_G -> query("insert into coupon_user(name,password,mail,phone,other) values('".$name."', '".Encode($password)."', '".$email."', '".$phone."','".$other."')");
		$uid = $db_G -> insertId();
		recordCard($uid);
		
		$db_G -> query("insert into users(name,pass,mail,created,status,init) values('".$name."', '".Encode($password)."', '".$email."', ".time().",1,'".$email."')");
		
		// 注册成功， 您的用户
		return 0;
	}
	else
	{
		//用户名相同，请重试
		return 2; 
	}
}

/*
function passport_register($name, $password, $repassword, $email, $phone, $other, $passport)
	{
		$error = 0;
		if($password != $repassword)
		{
			$error = 1;//密码输入不同，请重试
			return $error;
		}
		else if(checkName($name))
		{
			$uid = checkID("uid", "coupon_user");
			$void_date = date("Y/m/d", time()+63200000);
			
			//echo 'uid is:'.$uid.'. passport is: '.$passport.'. date is: '.$void_date;
			$R = dbconn("insert into coupon_user values('".$uid."', '".$name."', '".Encode($password)."', '".$email."', '".$phone."','".$other."')");//insert info to user table
			
			dbconn("insert into users(name,pass,mail,created,status,init) values('".$name."', '".Encode($password)."', '".$email."', ".time().",1,'".$email."')");
			
			$add_funcard = dbconn("insert into card (uid, card_id, void_date) values('".$uid."', '".$passport."', '".$void_date."')");//insert info to funcard table, use passport ID for funcard ID
			
			$add_passport = dbconn("insert into extra_item_value (uid, item_id, state) values('".$uid."', '1', '".$passport."')");
			$add_enable = dbconn("insert into extra_item_value (uid, item_id, state) values('".$uid."', '2', '1')");//insert info to extar_item_value table, active passport for user
			
			$disable_new_passport = dbconn("update new_passport set used = 1 where passport_id = ".$passport);//disable the passport id, marked as an used one;
			
			// 注册成功， 您的用户
			//mysql_free_result($R);
			return $error;
		}
		else
		{
			$error = 2; //用户名相同，请重试
			return $error; 
		}
	}
*/	
	
function register_aeb($name, $pass1)
{
	global $db_G;
	$password = Encode($pass1);
	$result = $db_G -> fetchOne("select uid,mail from users where name = '".$name."' and pass='".$password."'");
	if($result['uid']){
		if(checkCouponName($name))//new user from AEB
		{
			recordCard($uid);
			$db_G -> query("insert into coupon_user(name,password,mail) values('".$name."', '".$password."', '".$result['mail']."')");

			return 0;
		}
		else//there is a name in coupon_user table
		{
			return 2;
		}
	}
	else
	{
		return 1;
	}

}

/**
 * 检查护照用户是否存在
 * @param string $name 用户名
 */
function checkCouponName($name){
	global $db_G;
	$result = $db_G -> fetchOne("select uid from coupon_user where name = '".$name."'");
	if($result['uid'] > 0){
		return false;
	}
	
	return true;
}

function checkName($name) //check if there is a same name in coupon_user table. return true if the name is unicide
{
	global $db_G;
	$result = $db_G -> fetchOne("select uid from coupon_user where name = '".$name."'");
	if($result['uid'] > 0){
		return false;
	}
    
	$result = $db_G -> fetchOne("select uid from users where name = '".$name."'");
	if($result['uid'] > 0){
		return false;
	}

	return true;
}
		
function checkID($idName, $tableName)
	{
		$id = 0;
		$result = dbconn("select ".$idName. " from " .$tableName. " order by ".$idName." desc");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{ 
	        foreach ($line as $col_value)
			{
				if($col_value > $id)
				{
					$id = $col_value;
				}
        	}
    	}
		mysql_free_result($result);
		return $id += 1;
	}

function findUserIdbyName($name)
{
	global $db_G;
	$result = $db_G -> fetchOne("select uid from coupon_user where name = '".$name."'");
	if($result["uid"]){
		return $result["uid"];
	}	

	return false;
}

function findMerchantIDbyName($name)
	{
		$result = dbconn("select merchant_ID from consumption_merchant where merchant_name = '".$name."'");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				$id = $col_value;
        	}
    	}
		return $id;
	}

function recordCard($uid)
{
	global $db_G;
	$void_date = date("Y/m/d", time()+63200000);
	$res = $db_G -> fetchOne("select card_id from card order by card_id desc limit 1");
	if($res){
		$card_id = $res["card_id"] + 1;
		$result = $db_G -> query("insert into card(uid,card_id,void_date) values('".$uid."', '".$card_id."', '".$void_date."')");
	}
}

/**
 * 通过用户ID获取护照ID
 * @param $uid 用户ID
 */
function getCardIdByuid($uid){
	global $db_G;
	$result = $db_G -> fetchOne("select card_id from card where uid = $uid");
	
	return $result["card_id"];
}

function uploadMerchantToDB($picName, $tableName, $ID, $merchant_name)
	{
		$result = dbconn("select merchant_name from ".$tableName);
		$picURL = "./Mpic/".$picName;
		
		if($result == $merchant_name)
		{
			echo " same name, try again please ";
			mysql_free_result($result);
			return false;
		}
		else
		{
			$R = dbconn("insert into ".$tableName." values('".$merchant_name."', '".$ID."', '".$picName."')");
			mysql_free_result($result);
			//mysql_free_result($R);
			return true;
		}
	}
	
function uploadIconToDB($picName, $tableName, $couponID, $merchantID)
	{
		//$result = dbconn("SELECT merchant_name FROM ".$tableName);
		$picURL = "./Mpic/".$picName;
		//if($result == $merchant_name)
		//{
		//	echo " same name, try again please ";
		//	mysql_free_result($result);
		//	return false;
		//}
		//else
		//{
			$R = dbconn("insert into ".$tableName." values('".$merchantID."', '".$couponID."', '".$picName."')");
			//mysql_free_result($result);
			//mysql_free_result($R);
			return true;
		//}
	}

function uploadCouponToDB($picName, $tableName, $couponID, $merchantID)
	{
		$R = dbconn("insert into ".$tableName." values('".$merchantID."', '".$couponID."', '".$picName."')");
		return true;
	}

function upload_text_to_DB($coupon_ID, $file_name)
{
	$fileURL = "./Coupon_text/".$file_name;
	$R = dbconn("insert into coupon_text values('".$coupon_ID."', '".$file_name."')");
	return true;
}

function select_all_merchant()
{
	$result = dbconn("select * from merchant");
	$i = 1;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				switch ($i)
				{
					case 1:
					echo $col_value."<br/><br/>";
					$i++;
					break;
					
					case 2:
					$mid = $col_value;//set the merchant ID
					$i++;
					break;
					
					case 3:
					$i = 1;
					echo "<a href='./coupon_m.php?mid=$mid'><img src='./Mpic/$col_value' border='0' width='700'></a><br/>";
					echo "<a href='./coupon_m.php?mid=$mid'>click</a><br/><br/>";
					break;
				}
        	}
    	}
	mysql_free_result($result);
}

function coupon_by_merchant_id($merchant_id)
{
	$coupon = dbconn("select consumption_coupon.cid, consumption_coupon.title from consumption_coupon, extra_coupon_value where mid = ".$merchant_id." and extra_coupon_value.value = 0 and extra_coupon_value.item_id = 8 and extra_coupon_value.cid = consumption_coupon.cid;");
	$i = 1;
	$cid = 0;
	$score = 0;
	$count = 0;
	echo '<ul class="verifi_my_coupon">我的优惠券：';
	while ($line = mysql_fetch_array($coupon, MYSQL_ASSOC))
	{
		//print_r($line);
		/*echo '</br>score is '.$score.'; count is '.$count.'; title is'. $title.'|||';
		echo '<a href="show_coupon.php?cid='.$cid.'">go to coupon</a>';*/
		echo '<li><a href="show_coupon.php?cid='.$line["cid"].'">'.$line["title"].'</a></li>';
	}
}

function select_coupon_by_id($id, $type)
{
	switch ($type)
	{
		case 'm':
		$result = dbconn("select * from coupons where merchant_ID = '".$id."'");
		break;
		
		case 'c':
		$result = dbconn("select * from coupons where coupon_ID = '".$id."'");
		$fname = dbconn("select text_dir from coupon_text where coupon_ID = '".$id."'");
		break;
	}
	
	
	$i = 1;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				switch ($i)
				{
					case 1:
					//echo "case 1 <br/><br/>";
					$i++;
					break;
					
					case 2:
					//echo "coupon ID is $col_value <br/><br/>";
					$i++;
					break;
					
					case 3:
					$i = 1;
					echo "<img src='./Mpic/$col_value' alt onload=\"if(this.width>650) this.width=650;\">";
					
					break;
				}
        	}
    	}
		
	switch ($type)
	{
		case 'm':
		break;
		
		case 'c':
		echo"<table align=\"center\"><tr><td align=\"left\" width=\"480\"><font face=\"微软雅黑\" size=\"-1\">";
		echo "<br/><a class=\"print_text\" href=\"./coupon.php?cid=$id&print=1\">打印本页</a><br/>";
		while ($line = mysql_fetch_array($fname, MYSQL_ASSOC))
		{
	        foreach ($line as $file_name)
			{
				read_text($file_name);
			}
		}
		echo "<br/><a class=\"print_text\" href=\"./coupon.php?cid=$id&print=1\">打印本页</a><br/>";
		echo"</font></table></tr></td>";
	mysql_free_result($fname);
		break;
	}
		
	mysql_free_result($result);
}

function read_text($file_name)
{
	@$fp = fopen("Coupon_text/".$file_name, 'r'); //read file
  if(!$fp)
  {
	  echo " file open error ";
	  echo $file_name;
	  exit;
  }
  else
  {
	  while(!feof($fp))
	  {
	  	$r = fgets($fp);
		echo $r;
	  }
	  
	  fclose($fp);
  }
}

function select_all_coupon()
{
	$result = dbconn("select * from coupon_icon order by coupon_ID desc"); //倒序排序所有优惠券
	$pri = dbconn("select coupon_ID from coupon_priority");
	
	$pid = array();
	$cid = 0;//coupon ID
	$isP = false;//check is this coupin ID in priority table.
	$k = 0;
		
	while ($line = mysql_fetch_array($pri, MYSQL_ASSOC))
	{
		foreach($line as $col_value)
		{
			$pid[$k] = $col_value;
			$k++;
		}
	}
	
	//$result = dbconn("select * from coupons where merchant_ID = 1 order by coupon_ID desc");
	$i = 1; //for coupon's fromat count
	$j = 3; //for all fromat count
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				
				switch ($i)
				{
					case 1:
					{
					//echo "case 1 <br/><br/>";
					$i++;
					//$j++;
					break;
					}
					
					case 2:
					{
					//echo "coupon ID is $col_value <br/><br/>";
					$cid = $col_value;
					$isP = false;//set the value to false
					foreach($pid as $p)
					{
						if($cid == $p)
						{
							//echo "priority".$cid;
							$isP = true;//is priority coupon, will skip
						}
					}
					$i++;			
					break;
					}
					
					case 3:
					{
					
					if($isP)
					{					
						//echo "pid".$cid;
						$i=1;
						break;
					}
					else
					{
						if($j % 3 == 0 ) //set the table
						{
							echo "<tr valign=\"top\">";
							echo "<td class=\"all_coupon\">";
						}
						else
						{
							echo "<td class=\"all_coupon\">";
						}
						$i = 1;
						$j++;
						echo "<a href='./coupon.php?cid=$cid'><img src='./Mpic/$col_value' border='0' width='200'></a><br/>";
						echo "<a href='./coupon.php?cid=$cid'>点击查看优惠</a>";
						break;
					}
					
					}
				}
				if($j % 3 == 0 )
				{
					echo "</td>";
					echo "</tr>";
				}
				else
				{
					echo "</td>";
				}
        	}
    	}
	mysql_free_result($result);
	mysql_free_result($pri);
}

function select_priority_coupon()
{
	$pri = dbconn("select coupon_ID from coupon_priority  order by coupon_priority");
	
	$pid = array();
	$k = 0;
	while ($line = mysql_fetch_array($pri, MYSQL_ASSOC))
	{
		foreach($line as $col_value)
		{
			$result = dbconn("select * from coupon_icon where coupon_ID = '".$col_value."'");
			while($line_2 = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				foreach($line_2 as $value)
				{
				//echo "</br>value:".$value."</br>";
				$pid[$k] = $value;
				//echo "</br>value pid :".$pid[$k]."</br>";
				$k++;
				}
			}
		}
	}
	$i = 1; //for coupon's fromat count
	$j = 3; //for all fromat count
			foreach($pid as $col_value)
			{
				switch ($i)
				{
					case 1:
					{
					//echo "case 1 <br/><br/>";
					$i++;
					//$j++;
					break;
					}
					
					case 2:
					{
					//echo "coupon ID is $col_value <br/><br/>";
					$cid = $col_value;
					$i++;
					break;
					}
					
					case 3:
					{
					
					if($j % 3 == 0 ) //set the table
					{
						echo "<tr valign=\"top\">";
						echo "<td class=\"p_coupon\">";
						}
					else
					{
						echo "<td  class=\"p_coupon\">";
					}
					$i = 1;
					$j++;
					echo "<a href='./coupon.php?cid=$cid'><img src='./Mpic/$col_value' border='0' width='200'></a><br/>";
					echo "<a href='./coupon.php?cid=$cid'>点击查看优惠</a>";
					break;
					}
				}
				if($j % 3 == 0 )
				{
					echo "</td>";
					echo "</tr>";
				}
				else
				{
					echo "</td>";
				}
			}
	mysql_free_result($pri);
}

function coupon_count($id)
{
	if(coupon_ID_for_count($id))
	{//if this coupon in count table, update
		$count = search_from_table("count", "coupon_count", "coupon_ID", $id);
		$count = $count+1;	
	
		$R = dbconn("update coupon_count set count ='".$count."' where coupon_ID = '".$id."'");
	}
	else
	{//else insert
		$R2 = dbconn("insert into coupon_count values('".$id."', '1')");
	}
}

function coupon_ID_for_count($id)//if the coupon ID in coupon_count table, return true
{
	$result = dbconn("select coupon_ID from coupon_count where coupon_ID = '".$id."'");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{ 
	        foreach ($line as $col_value) 
			{
				//$id += 1;
				if($col_value == $id)
				{
					mysql_free_result($result);
					return true;
				}
        	}
    	}
		//return $id;
		mysql_free_result($result);
		return false;
}

function record_click_count($id)
{
	record_count($id, "coupon_count", "coupon_ID", "count");
}

function record_print_count($id)
{
	record_count($id, "coupon_print_count", "coupon_ID", "print_count");
}

function record_count($id, $table, $item_ID, $item_count)
{
	if(ID_for_count($id, $table, $item_ID, $item_count))
	{//if this coupon in count table, update
		$count = search_from_table($item_count, $table, $item_ID, $id);
		$count = $count+1;	
	
		$R = dbconn("update ".$table." set ".$item_count." ='".$count."' where ".$item_ID." = '".$id."'");
	}
	else
	{//else insert
		$R2 = dbconn("insert into ".$table." values('".$id."', '1')");
	}
}

function ID_for_count($id, $table, $item_ID, $item_count)//if the coupon ID in coupon_count table, return true
{
	$result = dbconn("select ".$item_ID." from ".$table." where ".$item_ID." = '".$id."'");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{ 
	        foreach ($line as $col_value) 
			{
				//$id += 1;
				if($col_value == $id)
				{
					mysql_free_result($result);
					return true;
				}
        	}
    	}
		//return $id;
		mysql_free_result($result);
		return false;
}

function select_all_coupon_count()
{
	$result = dbconn("select * from coupon_count order by coupon_ID desc"); //倒序排序所有优惠券
	//$result = dbconn("select * from coupons where merchant_ID = 1 order by coupon_ID desc");
	$i = 1; //for coupon's fromat count
	$j = 3; //for all fromat count
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				echo "<tr valign=\"top\">";
				echo "<td align=\"center\">";
				switch ($i)
				{
					case 1:
					$icon = search_from_table("coupon_logo", "coupon_icon", "coupon_ID", $col_value);
					$i++;
					echo "<img src='../Mpic/$icon'>";
					break;
					
					case 2:
					$i = 1;
					$j++;
					echo "优惠券被点击 $col_value 次<br/>";
					break;
				}
					echo "</td>";
					echo "</tr>";
        	}
    	}
	mysql_free_result($result);
}

function verification($card_ID = false, $phone = false)
{
	if(!$card_ID && !$phone ){
		return false;
	}
	
	global $db_G;

	if($phone){
		$phone_number = $db_G -> fetchOne("select uid from coupon_user where phone = '".$phone."'");
		if(!$phone_number["uid"]){
			return false;
		}
		$uid = $phone_number["uid"];
		
		$card = $db_G -> fetchOne("select card_id from card where uid = ".$uid);
		if($card["card_id"] > 0){		
			return $card["card_id"];
		}
		
	}
	
	if($card_ID){
		$card = $db_G -> fetchOne("select uid from card where card_id = '".$card_ID."'");
		if($card["uid"] > 0){		
			return $card_ID;
		}
	}

	return false;
}

function record_shop($card_id, $item, $shop_time, $price)
{
	$result_id = dbconn("select uid from card where card_id = '".$card_id."'");
	while ($line = mysql_fetch_array($result_id, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				$uid = $col_value;
        	}
    	}
	mysql_free_result($result_id);
	
	$result = dbconn("insert into coupon_shopping value('".$card_id."', '".$item."', '".$shop_time."', '".$uid."', '".$price."')");
}

function record_shopping($uid, $cid, $mid, $card_id, $score, $time, $price)
{
	$result = dbconn("insert into consumption_record value('".$uid."', '".$cid."', '".$mid."', '".$card_id."', '".$score."', '".$price."', '".$time."')")
	or die('record shopping failed');
	
}

function record_total_score($uid, $score)
{
	global $db_G;
	$result = $db_G -> fetchOne("select score from consumption_total_score where uid = ".$uid);

	if(!$result)//has no score record, create a new one
	{
		$total = $score;
		$insert = $db_G -> query("insert into consumption_total_score values(".$uid.", ".$score.")");
	}
	else//has one, update te old
	{
		$total = $result["score"];
		$total += $score;
		$update = $db_G -> query("update consumption_total_score set score = '".$total."' where uid = '".$uid."'");
	}
	
	//获取用户手机号
	$sql = "select phone from coupon_user where uid = ".$uid;
	$res = $db_G -> fetchOne($sql);

	if($res['phone']){
		sendsms_recore($res['phone'], $score, $total);
	}
	
}

function sendsms_recore($phone, $score, $totalscore){
	//发送短信通知用户
	require_once(PROJECT_ROOT_PATH.'/mes/mes_utf.php');
	$mess = new send_message();//send the reg message
	$phone = array($phone);
	$content = "尊贵的会员您好，您的积分".$score."分已记录，您的目前积分为".$totalscore."，可登录“我的积分”查看。祝您玩得开心！【爱儿帮】";
	$mess->sendmess($phone, $content);
}



function decrease_count($cid, $counts)
{
	//echo 'cid is '.$cid.'counts is '.$counts;
	$result = dbconn("update consumption_coupon set count ='".($counts-1)."' where cid = '".$cid."'");
}


function search_shopping()
{
	$buyer = dbconn("select * from coupon_shopping");
	$i = 1;
	
	//echo "fun卡ID; 消费名; 消费时间; 用户ID; 价格; 用户名; 用户邮箱; 用户电话<br/>";
	echo "<tr><td>fun卡ID</td><td>消费名</td><td>消费时间</td><td>用户ID</td><td>价格</td><td>用户名</td><td>用户邮箱</td><td>用户电话</td></tr>";
	while ($line = mysql_fetch_array($buyer, MYSQL_ASSOC))
	{
		foreach($line as $col_value)
		{
			switch($i)
			{
			case 1://card_ID
			{
				$i++;
				$card_ID = $col_value;
				break;
			}
			case 2://name
			{
				$i++;
				$item_name = $col_value;
				break;
			}
			case 3://time
			{
				$i++;
				$time = $col_value;
				break;
			}
			case 4://uid
			{
				$i++;
				$uid = $col_value;
				break;
			}
			case 5://price
			{
				$i=1;
				$price = $col_value;
				$user = search_user($uid);
				echo "<tr><td>".$card_ID."</td><td>".$item_name."</td><td>".$time."</td><td>".$uid."</td><td>".$price."</td><td>".$user[0]."</td><td>".$user[1]."</td><td>".$user[2]."</td></tr>";
				break;
			}
			}
		}
	}
}

function merchant_droplist()
{
	$result = dbconn("select merchant_name, merchant_id from consumption_merchant");
	
	echo '<select name="mid" id="mid">';
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		echo '
		<option value="'.$line['merchant_id'].'">'.$line['merchant_name'].'</option>
		';
	}
	echo '</select>';
}

function find_user_present($uid, $limit = 0)
{
	if(!is_numeric($uid) || !is_numeric($limit)){
		return false;
	}
	global $db_G;
	$res = $db_G -> fetchAll("select cp.pid,cp.pic,cp.title,cp.des,ce.date from consumption_exchange ce inner join consumption_present cp on cp.pid = ce.pid where ce.uid = '".$uid."' ORDER BY ce.date DESC  LIMIT ".$limit); 
	return $res;
}

function search_user($uid)
{
	$result = dbconn("select * from coupon_user where uid = '".$uid."'");
	$i = 1;
	$data = array();
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		foreach($line as $col_value)
		{
			switch($i)
			{
			case 1://uid
			{
				$i++;
				break;
			}
			case 2://name
			{
				$i++;
				$data[0] = $col_value;
				break;
			}
			case 3://pass
			{
				$i++;
				break;
			}
			case 4://mail
			{
				$i++;
				$data[1] = $col_value;
				break;
			}
			case 5://phone
			{
				$i++;
				$data[2] = $col_value;
				break;
			}
			case 6://other
			{
				$i=1;
				break;
			}
			}
		}
	}
	return $data;
}

function check_new_passport($passport)
{
	$used = null;
	$result = search_from_table("used", "new_passport", "passport_id", $passport);
	while($line = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
	}
}

function user_void_date($id)
{
	$result = dbconn("select void_date from card where uid = '".$id."'");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				$d = $col_value;
				return $d;
        	}
    	}
	mysql_free_result($result);
}

function check_from_table_DELETE($item, $table, $coloum, $value)
{
	$result = dbconn("select ".$item." from ".$table." where ".$coloum." = '".$value."'");
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				if($value = $col_value)
				{
					$delete = dbconn("delete from ".$table." where ".$coloum." = '".$value."'");
					return true;
				}
        	}
    	}
	mysql_free_result($result);
	return false;
}

function search_from_table($item, $table, $coloum, $value)
{
	global $db_G;
	$result = $db_G -> fetchOne("select ".$item." from ".$table." where ".$coloum." = '".$value."'");
	return $result[$item];
}

function connect_DB($query)
{
	return dbconn($query);
}
/*
function dbconn($query)
{
	return dbconn($query);
}*/

function find_merchantID_by_pic_name($pname)
{
	$id = search_from_table("merchant_ID", "coupons", "coupon_name", $pname);
	return $id;
}

function find_card_id_by_uid($uid)
{
	$cid = search_from_table("card_id", "card", "uid", $uid);
	return $cid;
}

function find_card_date_by_uid($uid)
{
	$vd = search_from_table("void_date", "card", "uid", $uid);
	return $vd;
}

function find_coupon_ID_by_name($cname)
{
	$cname = search_from_table("coupon_ID", "coupons", "coupon_name", $cname);
	return $cname;
}

/*function unicode2utf8($str){
        if(!$str) return $str;
        $decode = json_decode($str);
        if($decode) return $decode;
        $str = '["' . $str . '"]';
        $decode = json_decode($str);
        if(count($decode) == 1){
                return $decode[0];
        }
        return $str;
}*/

function utf8_to($str)
{
	if(!$str) return $str;
	$decode = iconv("GB2312", "UTF-8", $str);
	//iconv( "UTF-8", "gb2312" , $str);
	return $decode;
}

function print_page()
{
	echo '<script language="javascript" type="text/javascript">';
	echo 'window.print()';
	echo '</script>';
}

function core_redirect($url){
	echo '<script>window.location="'.$url.'";</script>';exit;
	//header("Location:".$url);exit;
}


class upload
{
	/*设置文件保存目录 注意包含*/
		private $uploaddir;

		/*设置允许上传文件的类型*/
		private $type=array();
		
		private $upload_file_name;//上传的文件名
		private $upload_file_temp_name;
		
		private $pic;//存贮的文件名

		/*程序所在路径*/
		//$patch="http://www.dreamdu.com/cr_downloadphp/upload/files/";
		
		public function __construct($dir, $type, $file_name, $fileTempName, $saveName)
		{
			$this->uploaddir = $dir;
			$this->upload_file_name = $file_name;
			$this->upload_file_temp_name = $fileTempName;
			$this->pic = $saveName;
			if(is_array($type))
			{
				$this->type = $type;
			}
			else
			{
				$this->type = array($type);
			}
		}

		public function set_dir($dir)
		{
			$this->uploaddir = $dir;
		}
		
		public function set_file_type($type)
		{
			$this->$type = $type;
		}
		/*获取文件后缀名函数*/
		private function fileext($filename)

		{
			return substr(strrchr($filename, '.'), 1);
		}
		
		public function upload_file()
		{
			$a = strtolower($this->fileext($this->upload_file_name));
			//echo $a;

			/*判断文件类型*/
			if(!in_array($a, $this->type))
			{
		        $text=implode(",",$this->type);
		        echo "您只能上传以下类型文件: ",$text,"<br>";
			}
			else
			{
				$this->pic = $this->pic.'.'.$a;
				$uploadfile = $this->uploaddir.$this->pic;
				file_exists($uploadfile);
				
    	    	if (move_uploaded_file($this->upload_file_temp_name, $uploadfile))
        		{
					echo "<center>您的文件已经上传完毕 上传图片预览: </center><br><center><img src='$uploadfile'></center>";
                    echo"<br><center><a href='javascript:history.go(-1)'>继续上传</a></center>";
				}
				else
				{
					echo "pic name is same, try again please";
				}
        	}
		}
}
?>