<?php
//include_once("phpmailer/class.phpmailer.php");
include_once("DB/db.php");

function Encode($str)
	{
		$code = md5($str);
		return $code;
	}
	
function login($name, $password)
	{
  /* // Connecting, selecting database  
    $link = mysql_connect("localhost", "root", "") 
        or die("Could not connect"); 
    print "Connected successfully"; 
    mysql_select_db("sitetest") or die("Could not select database");
	
    // Performing SQL query 
    $query = "SELECT * FROM users where name = '".$name."'"; 
    $result = mysql_query($query) or die("Query failed");
	*/
	$password = Encode($password);
	$result = dbconn("select user_pass from training_users where user_name = '".$name."'");
	
	 // Printing results in HTML 
   // print "<table>\n"; 
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{ 
        //print "\t<tr>\n"; 
        foreach ($line as $col_value) 
		{
			if($col_value == $password)
			{
				//echo 'password correct';
				return true;
			}
			/*$i = 0;
			$user[$i] = $col_value;
			
			echo $user[$i]; //0 = id, 1 = name, 2 = password
			$i += 1;*/
            //print "\t\t<td>$col_value</td>\n";
        }
       // print "\t</tr>\n"; 
    } 
   // print "</table>\n";
	
    /* Free resultset */ 
    mysql_free_result($result);
	return false; 
	}

function register($name, $pass, $repass, $mail, $P_name, $phone, $company, $baby_name, $baby_birth, $adress)
	{
		$error = 0;
		if($pass != $repass)
		{
			$error = 1;//密码输入不同，请重试
			return $error;
		}
		else if(checkName($name, "training_users", "user_name") && checkName($name, "coupon_user", "name") && checkName($name, "users", "name"))
		{
			$uid = checkID("user_ID", "training_users");
			$pass = Encode($pass);
			$R = dbconn("insert into training_users values('".$uid."', '".$name."', '".$pass."', '".$mail."', '".$P_name."', '".$phone."', '".$company."', '".$baby_name."', '".$baby_birth."', '".$adress."')");
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

function register_update($name, $pass, $repass, $mail, $P_name, $phone, $company, $baby_name, $baby_birth, $adress)
	{
		$error = 0;
		if($pass != $repass)
		{
			$error = 1;//密码输入不同，请重试
			return $error;
		}
		else if(check_pass($name, $pass, "users", "name", "pass") || check_pass($name, $pass, "coupon_user", "name", "password") )
		{
			$uid = checkID("user_ID", "training_users");
			$pass = Encode($pass);
			$R = dbconn("insert into training_users values('".$uid."', '".$name."', '".$pass."', '".$mail."', '".$P_name."', '".$phone."', '".$company."', '".$baby_name."', '".$baby_birth."', '".$adress."')");
			// 注册成功， 您的用户
			//mysql_free_result($R);
			return $error;
		}
		else
		{
			$error = 3; //password incorrect
			return $error; 
		}
	}

function check_pass($name, $password, $table_name, $namecol, $passcol)
	{
	$password = Encode($password);
	$result = dbconn("select ".$passcol." from ".$table_name." where ".$namecol." = '".$name."'");
	
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{ 
        foreach ($line as $col_value) 
		{
			if($col_value == $password)
			{
				return true;
			}
        }
    } 
    mysql_free_result($result);
	return false; 
	}

function checkName($name, $table, $col_name) //check if there is a same name in coupon_user table. return true if the name is unicide
	{
		$result = dbconn("select ".$col_name." from ".$table." where ".$col_name." = '".$name."'");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{ 
	        foreach ($line as $col_value) 
			{
				if(strtolower($col_value) == strtolower($name))
				{
					mysql_free_result($result);
					return false;
				}
        	}
    	}
		mysql_free_result($result);
		return true;
	}
		
function checkID($idName, $tableName)
	{
		$id = 0;
		$result = dbconn("select ".$idName. " from " .$tableName);
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
		$result = dbconn("select user_ID from training_users where user_name = '".$name."'");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				$id = $col_value;
        	}
    	}
		return $id;
	}

function findMerchantIDbyName($name)
	{
		$result = dbconn("select merchant_ID from merchant where merchant_name = '".$name."'");
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
	$void_date = date("Y/m/d", time()+63200000);
	$card_id = checkID("card_id", "card");
	
	$result = dbconn("insert into card values('".$uid."', '".$card_id."', '".$void_date."')");
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

function upload_text_to_DB($class_ID, $class_title, $class_text, $class_company, $class_date, $class_time, $class_lecturer, $class_adress)
{
	$R = dbconn("insert into training_classes values('".$class_ID."', '".$class_title."', '".$class_text."', '".$class_company."', '".$class_date."', '".$class_time."', '".$class_lecturer."', '".$class_adress."')");
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

function select_class_by_id($id)
{
	$result = dbconn("select * from training_classes where class_ID = '".$id."'");
	if(isset($_COOKIE['trainingUserName']))
	{
		$user_name = $_COOKIE['trainingUserName'];
		$user_ID = $_COOKIE['trainingUserID'];
	}
	$i = 1;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				switch ($i)
				{
					case 1://ID
					{
						$i++;
						/*echo "<tr><td class=\"all_c\">";
						echo $col_value;
						echo "</td>";*/
						$class_ID = $col_value;
						break;
					}
					
					case 2://title
					{
						$i++;
						$class_title = $col_value;
						break;
					}
					
					case 3://text
					{
						$i++;
						$class_dir = "classes/".$col_value;
						break;
					}
					
					case 4://company
					{
						$i++;
						$company_name = $col_value;
						break;
					}
					case 5://date
					{
						$i++;
						$class_date = $col_value;
						break;
					}
					case 6://time
					{
						$i++;
						$class_time = $col_value;
						break;
					}
					case 7://lecturer
					{
						$i++;
						$class_lecturer = $col_value;
						break;
					}
					case 8://adress
					{
						$i = 1;
						$class_adress = $col_value;
						//echo "<tr><td align=\"center\">";
						echo "<div class=\"classes_title\">".$class_title."</div>";
						
						
						$rate = cal_rate($class_ID);//class rate calculate
						
				
			   			echo "<table align=\"center\" name=\"rate\"><tr><td>";
						echo "<div class=\"classes\">";
						echo '
						<div class="rate">
						<div>总评:'.$rate.'</div>
						<div>
						<span id="rateStatus">评分...</span>
						<span id="ratingSaved">评分结果!</span> 
						<div id="rateMe" title="评分...">
    					<a onClick="rateIt(1,'.$class_ID.')" id="_1" title="较差" onMouseOver="rating(this)" onMouseOut="off(this)"></a>
    					<a onClick="rateIt(2,'.$class_ID.')" id="_2" title="不好" onMouseOver="rating(this)" onMouseOut="off(this)"></a>
    					<a onClick="rateIt(3,'.$class_ID.')" id="_3" title="一般" onMouseOver="rating(this)" onMouseOut="off(this)"></a>
     					<a onClick="rateIt(4,'.$class_ID.')" id="_4" title="挺好的" onMouseOver="rating(this)" onMouseOut="off(this)"></a>
    					<a onClick="rateIt(5,'.$class_ID.')" id="_5" title="好极了" onMouseOver="rating(this)" onMouseOut="off(this)"></a>
						</div>
						</div>';
						read_text($class_dir);
						
						echo '</div>';
						
						
						if(check_reg($user_ID, $class_ID))
						{
							echo "<div class=\"reg_button\"><a href=\"tools/registration.php?uid=".$user_ID."&class_ID=".$class_ID."&username=".$user_name."&company=".$company_name."\">报名</a></div>";
						}
						else
						{
							echo "<div text-align=\"center\"><a>已报名</a></div>";
						}
						echo "<div class=\"back_top\"><a href=\"classes.php\">返回上页</a></div>";
						set_comment();
						select_comment_by_class($class_ID);
						break;
						echo "</td></tr></table>";
					}
				}
        	}
    	}
	mysql_free_result($result);
}

function read_text($file_dir)
{
	@$fp = fopen($file_dir, 'r'); //read file
  if(!$fp)
  {
	  echo " file open error ";
	  echo $file_dir;
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

function set_comment()
{
	echo "<div>
<form action=\"tools/comment.php\" method=\"post\">
<input type=\"hidden\" name=\"user_name\" value=\"".$_COOKIE['trainingUserName']."\" /></input>
<input type=\"hidden\" name=\"class_ID\" value=\"".$_GET['class_ID']."\" /></input>
<input type=\"hidden\" name=\"date\" value=\"".date("Y-n-j")."\" /></input></br>
<textarea cols=\"80\" rows=\"7\" name=\"text\" id=\"comment\" onblur=\"javascript:checkInput();\"></textarea>
<input type=\"text\" name=\"passcode\" />
<img src=\"tools/yanzheng.php\" align=\"absmiddle\" />
<input type=\"submit\" name=\"sub\" value=\"发表评论\" />
</form>
</div>";
}

function select_comment_by_class($cid)
{
	$result = dbconn("select * from training_comment where class_ID = '$cid' order by comment_ID desc");
	
	$i = 1;
	echo "<ul class=\"comment_ul\">";
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				switch($i)
				{
					case 1://comment_id
					{
						$i++;
						break;
					}
					case 2://class_ID
					{
						$i++;
						break;
					}
					case 3://content
					{
						$i++;
						$content = $col_value;
						break;
					}
					case 4://user_name
					{
						$i++;
						$user_name = $col_value;
						break;
					}
					case 5://comment_time
					{
						$i=1;
						$time = $col_value;
						echo "
						<li class=\"comment_time\">".$time."</li>
						<li class=\"comment_user\">".$user_name." 评论：</li>
						<li class=\"comment_content\">".$content."</li>
						";
						break;
					}
				}
			}
		}
		echo "</ul>";
}

function select_class()
{
	$result = dbconn("select * from training_classes"); //class	
	$cid = 0;//class ID
	$i = 1; //for class's fromat count
	$j = 4; //for all fromat count
	if(isset($_COOKIE['trainingUserName']))
	{
		$user_name = $_COOKIE['trainingUserName'];
		$user_ID = $_COOKIE['trainingUserID'];
	}
	$class_ID = "";
	$company_name = "";
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				
				switch ($i)
				{
					case 1://ID
					{
						$i++;
						/*echo "<tr><td class=\"all_c\">";
						echo $col_value;
						echo "</td>";*/
						$class_ID = $col_value;
						break;
					}
					
					case 2://title
					{
						$i++;			
						echo "<tr><td class=\"all_c\">";
						echo "<a href=\"classes.php?class_ID=".$class_ID."\">".$col_value."</a>";
						echo "</td>";
						break;
					}
					
					case 3://text
					{
						$i++;
						/*echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";*/
						break;
					}
					
					case 4://company
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						$company_name = $col_value;
						break;
					}
					case 5://date
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 6://time
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 7://lecturer
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 8://adress
					{
						$i = 1;
						if(check_reg($user_ID, $class_ID))
						{
							echo "<td class=\"all_c\">";
							echo $col_value;
							echo "</td>";
							echo "<td class=\"all_c_last\"><div class=\"reg_button\"><a href=\"tools/registration.php?uid=".$user_ID."&class_ID=".$class_ID."&username=".$user_name."&company=".$company_name."\">报名</a></div>";
							echo "</td></tr>";
							echo "<tr class=\"table_tr\" height=\"1\"><td colspan=\"9\"></td></tr>";
						}
						else
						{
							echo "<td class=\"all_c\">";
							echo $col_value;
							echo "</td>";
							echo "<td class=\"all_c_last\"><a>已报名</a>";
							echo "</td></tr>";
							echo "<tr class=\"table_tr\" height=\"1\"><td colspan=\"9\"></td></tr>";
						}
						break;
					}
				}
        	}
    	}
	mysql_free_result($result);
}

function select_class_by_date($year, $month, $cname)
{
	$date = $year."-".$month;
	$result = dbconn("select * from training_classes where class_date like '".$date."%' and class_company = '".$cname."'"); //class	
	$cid = 0;//class ID
	$i = 1; //for class's fromat count
	$j = 4; //for all fromat count
	if(isset($_COOKIE['trainingUserName']))
	{
		$user_name = $_COOKIE['trainingUserName'];
		$user_ID = $_COOKIE['trainingUserID'];
	}
	$class_ID = "";
	$company_name = "";
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				
				switch ($i)
				{
					case 1://ID
					{
						$i++;
						/*echo "<tr><td class=\"all_c\">";
						echo $col_value;
						echo "</td>";*/
						$class_ID = $col_value;
						break;
					}
					
					case 2://title
					{
						$i++;			
						echo "<tr><td class=\"all_c\">";
						echo "<a href=\"classes.php?class_ID=".$class_ID."\">".$col_value."</a>";
						echo "</td>";
						break;
					}
					
					case 3://text
					{
						$i++;
						/*echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";*/
						break;
					}
					
					case 4://company
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						$company_name = $col_value;
						break;
					}
					case 5://date
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 6://time
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 7://lecturer
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 8://adress
					{
						$i = 1;
						if(check_reg($user_ID, $class_ID))
						{
							echo "<td class=\"all_c\">";
							echo $col_value;
							echo "</td>";
							echo "<td class=\"all_c_last\"><div class=\"reg_button\"><a href=\"tools/registration.php?uid=".$user_ID."&class_ID=".$class_ID."&username=".$user_name."&company=".$company_name."\">报名</a></div>";
							echo "</td></tr>";
							echo "<tr class=\"table_tr\" height=\"1\"><td colspan=\"9\"></td></tr>";
						}
						else
						{
							echo "<td class=\"all_c\">";
							echo $col_value;
							echo "</td>";
							echo "<td class=\"all_c_last\"><a>已报名</a>";
							echo "</td></tr>";
							echo "<tr class=\"table_tr\" height=\"1\"><td colspan=\"9\"></td></tr>";
						}
						break;
					}
				}
        	}
    	}
	mysql_free_result($result);
}

function select_class_by_user($uid)
{
	$user_class = dbconn("select class_ID from training_registration where user_ID = '".$uid."'");
	
	$i = 1; //for class's fromat count
	$j = 4; //for all fromat count
	while ($class = mysql_fetch_array($user_class, MYSQL_ASSOC))//list the class iD
		{
	        foreach ($class as $cid)
			{
				
	
		$result = dbconn("select * from training_classes where class_ID = '".$cid."%'"); //select class by id	
	
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				
				switch ($i)
				{
					case 1://ID
					{
						$i++;
						/*echo "<tr><td class=\"all_c\">";
						echo $col_value;
						echo "</td>";*/
						$class_ID = $col_value;
						break;
					}
					
					case 2://title
					{
						$i++;			
						echo "<tr><td class=\"all_c\">";
						echo "<a href=\"classes.php?class_ID=".$class_ID."\">".$col_value."</a>";
						echo "</td>";
						break;
					}
					
					case 3://text
					{
						$i++;
						/*echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";*/
						break;
					}
					
					case 4://company
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						$company_name = $col_value;
						break;
					}
					case 5://date
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 6://time
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 7://lecturer
					{
						$i++;
						echo "<td class=\"all_c\">";
						echo $col_value;
						echo "</td>";
						break;
					}
					case 8://adress
					{
						$i = 1;
						
							echo "<td class=\"all_c_last\">";
							echo $col_value;
							echo "</td>";
							
							echo "</td></tr>";
							echo "<tr class=\"table_tr\" height=\"1\"><td colspan=\"9\"></td></tr>";
						
						break;
					}
				}
        	}
    	}
			}
		}
}


function registration($user_name, $user_ID, $class_ID, $company)
{	
	if(check_reg($user_ID, $class_ID))
	{
		$result = dbconn("insert into training_registration values('".$user_ID."', '".$user_name."', '".$class_ID."', '".$company."')");
	}
}

function check_reg($user_ID, $class_ID)
{
	$result = dbconn("select class_ID from training_registration where user_ID='".$user_ID."'");
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{ 
	        foreach ($line as $col_value) 
			{
				//$id += 1;
				if(strtolower($col_value) == strtolower($class_ID))
				{
					mysql_free_result($result);
					return false;
				}
        	}
    	}
	mysql_free_result($result);
	return true;
}

function record_comment($class_ID, $content, $user_name, $time)
{
	$comm_ID = checkID("comment_ID", "training_comment");
	if($class_ID == "" || $content == "" || $user_name == "" || $time == "")
	{
		return "error";
	}
	else
	{
		$result = dbconn("insert into training_comment values('".$comm_ID."', '".$class_ID."', '".$content."', '".$user_name."', '".$time."')");
	}
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

function class_rate($cid, $score)
{
	if(class_for_rate($cid, "training_rate", "class_ID"))
	{//if this coupon in count table, update
		$rate = search_from_table("total_rate", "training_rate", "class_ID", $cid);
		(int)$rate = (int)$rate + (int)$score;
		$click = search_from_table("total_click", "training_rate", "class_ID", $cid);
		(int)$click = (int)$click + 1;
	
		$R = dbconn("update training_rate set total_rate ='".(int)$rate."' where class_ID = '".$cid."'");
		$R3 = dbconn("update training_rate set total_click ='".(int)$click."' where class_ID = '".$cid."'");
	}
	else
	{//else insert
		echo "here";
		$R2 = dbconn("insert into training_rate values('".$cid."', '".(int)$score."', '1')");
	}
}

function class_for_rate($id, $table, $item_ID)//if the class ID in coupon_count table, return true
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

function cal_rate($cid)
{
	$result = dbconn("select total_rate, total_click from training_rate where class_ID = '".$cid."'");
	$i = 0;
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{ 
	        foreach ($line as $col_value) 
			{
				switch($i)
				{
				case 0:
				{
					$total_rate = $col_value;
					$i++;
					break;
				}
				case 1:
				{
					$total_click = $col_value;
					break;
				}
				}
        	}
    	}
	$rate = round($total_rate/$total_click);
	return $rate;
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
	$result = dbconn("select ".$item." from ".$table." where ".$coloum." = '".$value."'");
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				$s = $col_value;
        	}
    	}
	mysql_free_result($result);
	return $s;
}

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

function find_company_by_name($uname)
{
	$cname = search_from_table("user_company", "training_users", "user_name", $uname);
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
?>