<?php
require_once('function.php');
class users
{
	public $user_name = '';
	public $pass = '';
	public $user_id = '';
	public $user_mail = '';
	public $user_score = '';
	public $exchange_score = '';
	public $user_adress = '';
	public $user_passport = '';
	public $real_name = '';
	public $phone = '';
	
	public $baby_name = '';
	public $baby_birth = '';
	public $baby_sex = '';
	public $parent_name = '';
	private $db;//数据库操作对象
	
	public function __construct()
	{
	$user_name = '';
	$pass = '';
	$user_id = '';
	$user_mail = '';
	$user_score = '';
	$exchange_score = '';
	$user_adress = '';
	$user_passport = '';
	$real_name = '';
	$phone = '';
	
	$baby_name = '';
	$baby_birth = '';
	$baby_sex = '';
	$parent_name = '';
	global $db_G;
	$this -> db = $db_G;
	}
	
	/**
	 * 更新用户电话
	 * @param $phone 电话号码
	 */
	function setUserPhone($phone, $uid){
		if(!$phone || !$uid){
			return false;
		}
		
		//更新coupon_user表
		$this -> db -> query("update coupon_user set phone = '".$phone."' where uid = ".$uid);
	
		return true;
		
	}
	
	function getcurrentuser(){
		global $userarr;	
		if($_COOKIE['couponUserID']){
			$_COOKIE['couponUserID'] = Security::decrypt($_COOKIE['couponUserID']);
		}
		
		$uid = @$_COOKIE['couponUserID'];
		$session_id = $_COOKIE[session_name()];
		if(is_numeric($uid)){
			$res = $this -> db -> fetchOne("select uid,name,mail,phone from coupon_user where uid = $uid");
			
			if($res){
				$userarr = $res;
			}
	
			if(!$res && $_SERVER["SCRIPT_NAME"] != '/kidspassport/index.php'){//用户不存在，去首页吧	
				$this -> setUserCookie('','',-1);			
				core_redirect("/kidspassport");
			}
			else if(!$res['phone'] && $_SERVER["SCRIPT_NAME"] != '/funcard/register.php' && $_SERVER["SCRIPT_NAME"] != '/funcard/tools/reg.php'){//补充电话号码
				
				core_redirect("/funcard/register.php?type=phone");
				
			}
			
			
			$res = $this -> db -> fetchOne("select score from consumption_total_score where uid = $uid");
			if($res){
				$userarr["score"] = $res["score"];
			}
		}
		else if($session_id){//点评网可能已经登录			
			$res = $this -> db -> fetchOne("select u.uid,u.name from sessions s inner join users u on u.uid = s.uid where s.sid='".$session_id."'");
			if($res["uid"]){
				
				$respp = $this -> db -> fetchOne("select uid,name,phone from coupon_user where name = '".$res["name"]."'");
				
				if($respp){//护照网存在该用户
					$this -> setUserCookie($respp["name"],$respp["uid"]);
					if($respp["phone"]){						
						core_redirect("/funcard/mypage.php");
					}
					else{
						core_redirect("/funcard/register.php?type=phone");
					}
				}
				else{//护照网不存在该用户
				
					if($uid = $this -> importUsers2PP(false,$res["uid"])){//导入用户成功
						$res = $this -> db -> fetchOne("select uid,name from coupon_user where uid = $uid");
						if($res){
							$this -> setUserCookie($res["name"],$res["uid"]);							
							core_redirect("/funcard/register.php?type=phone");
						}
					}
					
				}
			}
		}

	}
	
	/**
	 * 登录操作
	 * @param unknown_type $name 用户名
	 * @param unknown_type $pass 密码
	 */
	public function doUserLogin($name, $pass){
		$uid = $this -> userLoginCheck($name, $pass);
	
		if($uid){			
			core_redirect("/funcard/mypage.php");
		}
		else{
			core_redirect("/kidspassport/index.php?error=1");
		}
	}
	
	public function setUserCookie($name, $uid, $time = 2600000){
		setcookie("couponUserName", $name, time() + $time, "/", "aierbang.org");
		$uid = $uid?Security::encrypt($uid):$uid;
		setcookie("couponUserID", $uid, time() + $time, "/", "aierbang.org");			
	}
	
	public function userLoginCheck($name, $pass){
		
		$password = md5($pass);
		
		$aebres = $this -> db -> fetchOne("select uid from users where name='".$name."' and pass='$password'");
	
		if($aebres["uid"]){
			$result = $this -> db  -> fetchOne("select uid from coupon_user where name = '".$name."'");
			
		    if(!$result['uid']) //用户不存在，导入吧
			{ 
				$uid = $this -> importUsers2PP($name);
				if($uid){										
					$this -> setUserCookie($name,$uid);
					$this -> aebUserLogin($aebres["uid"]);
					core_redirect("/funcard/register.php?type=phone");
				}
		    }
	
		    $this -> setUserCookie($name,$result['uid']);
			$this -> aebUserLogin($aebres["uid"]);

			
			return $result['uid'];
		}
		
		return false;
	}
	
	public function aebUserLogin($uid){
		$skey = $_COOKIE[session_name()];		
	  	$this -> db  -> query("UPDATE sessions SET uid = ".$uid." , timestamp = ".time()." WHERE sid = '$skey'");	 	


	  	if ($this -> db  -> affectedRows() < 1) {
	   	 	$this -> db  -> query("INSERT INTO sessions (sid, uid,timestamp) VALUES ('".$skey."', ".$uid.", ".time().")");
	  	}	
		
	  	$this -> db  -> query("UPDATE users SET access = ".time()." WHERE uid = ".$uid);	
	}
	
	/**
	 * 从users里到数据到coupon_user表
	 * @param $name	用户名
	 * @param $uid	用户ID
	 */
	private function importUsers2PP($name ='', $uid=''){
		if(!$name && !$uid){
			return false;
		}
		
		if($name){
			$sql = "select name,pass,mail from users where name='".$name."'";
		}
		else if(is_numeric($uid)){
			$sql = "select name,pass,mail from users where uid=$uid";
		}
		
		$res = $this -> db -> fetchOne($sql);
		
		if($res){
			$this -> db -> query("insert into coupon_user(name,password,mail) values('".$res["name"]."', '".$res["pass"]."', '".$res["mail"]."')");
			if($this -> db -> affectedRows() > 0){
				return $this -> db -> insertId();
			}
		}
		return false;
	}
	
	
	public function doUserLogout(){
		setcookie("couponUserName", '', time()-2600000, "/", "aierbang.org");
		setcookie("couponUserID", '', time()-2600000, "/", "aierbang.org");
		
		$skey = $_COOKIE[session_name()];		
	  	$this -> db  -> query("delete from sessions where sid = '$skey'");	
	
		$url = "../../kidspassport/"; 
		echo "<script language='javascript' type='text/javascript'>"; 
		echo "window.location.href='$url'"; 
		echo "</script>"; 
	}
	

	public function check_log()
	{
		if(isset($_COOKIE['couponUserName']))
		return true;
		else
		return true;
	}
	
	public function find_score()
	{
		if($this->check_log())
		{
			$this->user_score = search_from_table("score", "consumption_total_score", "uid", $this->user_id);
		}
		if($this->user_score == null)
		{
			$this->user_score = 0;
		}
		return $this->user_score;
	}
	
	public function find_my_present($limit = 0)
	{
		return find_user_present($this->user_id, $limit);
	}
	
	public function record_present($present_id, $present_score)
	{
		$result = dbconn("");
	}
	
	public function record_adress()
	{
		if($this->has_PP == 1)//has a passport, do not need to send
		{			
			$adress = $this -> db -> query("insert into extra_item_value (uid, item_id, state) values('".$this->user_id."', '13', '1')");//record it is has a passport or not 
		}
		else if($this->user_adress == "" && $this->real_name == "")
		{
			
		}
		else//new one, record adress, send the passport
		{
			
			$adress = $this -> db -> query("insert into extra_item_value (uid, item_id, state) values('".$this->user_id."', (select item_id from extra_item where item_name = 'adress'), '".$this->user_adress."')");
			
			$real_name = $this -> db -> query("insert into extra_item_value (uid, item_id, state) values('".$this->user_id."', (select item_id from extra_item where item_name = 'name'), '".$this->real_name."')");
			
			
			$uid = $this -> getAebUid(false,$this->user_id);		
			if($uid){		
				$this -> db -> query("insert into profile_values (fid, uid, value) values(41, $uid, '".$this->user_adress."')");
				$this -> db -> query("insert into profile_values (fid, uid, value) values(19, $uid, '".$this->real_name."')");
			}
			
		}
	}
	
	public function getAebUid($name, $uid = false){
		if($uid){
			$result = $this -> db -> fetchOne("select name from coupon_user where uid = ".$uid);
			if($result["name"]){
				$name =  $result["name"];
			}
		}
		
		if($name){
			$result = $this -> db -> fetchOne("select uid from users where name = '".$name."'");
			if($result["uid"]){
				return $result["uid"];
			}
		}
		return false;
	}
	
	public function reduce_score()
	{
		$this -> db -> query("update consumption_total_score set score = consumption_total_score.score-".$this->exchange_score." where uid = ".$this->user_id);
		global $userarr;
	
		if($userarr['phone']){
			$res = $this -> db -> fetchOne("select score from consumption_total_score where uid = $this->user_id");
			if($res["score"]){
				sendsms_recore($userarr['phone'], -$this->exchange_score, $res["score"]);
			}
		}
	}
	
	public function increase_score()
	{
		$this -> db -> query("update consumption_total_score set score = consumption_total_score.score+".$this->exchange_score." where uid = ".$this->user_id);
		global $userarr;
	
		if($userarr['phone']){
			$res = $this -> db -> fetchOne("select score from consumption_total_score where uid = $this->user_id");
			if($res["score"]){
				sendsms_recore($userarr['phone'], $this->exchange_score, $res["score"]);
			}
		}
	}
	
	public function active_my_passport()
	{
		$funcard_id;
		$passport_id;
		$state = 0;//passport state, 0 is nothing, 1 is had funcard
		//find_card_id_by_uid($uid)
		$card = dbconn("select extra_item_value.state,card.card_id from extra_item,extra_item_value,card where extra_item_value.uid = '".$this->user_id."' and extra_item.item_name = 'passport' and card.uid = extra_item_value.uid and extra_item_value.item_id = extra_item.item_id") or die("active_my_passport failed");//search funcard id
		while($line = mysql_fetch_array($card, MYSQL_ASSOC))
		{
			$funcard_id = $line['card_id'];
			$passport_id = $line['state'];
			if($line['state'] == $line['card_id'])
			{
				$state = 1;
			}
		}
		
		//echo'<br/>funcard id: '.$funcard_id.'. passport_id:'.$passport_id.'. enable is:'.$enable.'<br/>';
		
		if($state == 0)//doesn't has passport number, assgin a number
		{
			$funcard_id = find_card_id_by_uid($this->user_id);
			$add_passport = dbconn("insert into extra_item_value (uid, item_id, state) values('".$this->user_id."', '1', '".$funcard_id."')") or die("active_my_passport insert passport failed");
			$add_enable = dbconn("insert into extra_item_value (uid, item_id, state) values('".$this->user_id."', '2', '1')") or die("active_my_passport insert enable failed");
		}
		else if($state == 1)//has a passport, but not enable, so enable the passport
		{
			//echo 'here'.$passport_id;
			$enable_passport = dbconn("update extra_item_value set state = 1 where uid = '".$this->user_id."' and item_id = '2'") or die("update passport is failed");
		}
		else
		break;
		mysql_free_result($card);
	}
	
	public function check_my_passport()
	{
		$result = array("result"=> 0, "passport_id" => 0);//result is 0 means has passport and enabled
		
		$passport = dbconn("select state from extra_item_value where uid = '".$this->user_id."' and item_id = '1'") or die("check_my_passport failed");
		//echo 'here';
		while($line = mysql_fetch_array($passport, MYSQL_ASSOC))
		{
			$result["passport_id"] = $line['state'];
		}
		
		if($result["passport_id"] == 0)
		{
			$result["result"] = 1;//result = 1 means has no passport and not enable
		}
		else
		{
			$enable = dbconn("select state from extra_item_value where uid = '".$this->user_id."' and item_id = '2'") or die("check_my_passport failed");
			$is_enable = 0;
			while($line = mysql_fetch_array($enable, MYSQL_ASSOC))
			{
				$is_enable = $line['state'];
			}
			
			mysql_free_result($enable);
			
			if($is_enable == 0)
			{
				$result["result"] = 2;//result =2 means has passsport but not enable
			}
		}
		mysql_free_result($passport);
		return $result;
	}

	
	public function check_new_passport()
	{
		$used = 1;//if the passport has been used
		$passport_id = 0;
		$passport = dbconn("select passport_id, used from new_passport where passport_id = ".$this->user_passport) or die("check_new_passport failed");
		while($line  = mysql_fetch_array($passport, MYSQL_ASSOC))
		{
			$used = $line['used'];
			$passport_id = $line['passport_id'];
		}
		
		if($passport_id == $this->user_passport && $used == 0)
		{
			return 0;
		}
		else if($passport_id == $this->user_passport &&$used > 0)
		{
			return 1;
		}
		else
		{
			return 2;
		}
	}
	
	public function check_phone()
	{
		$R = dbconn("select phone from coupon_user where name = '".$this->user_name."'") or die("check_email failed");
		$phone = '';
		while($line  = mysql_fetch_array($R, MYSQL_ASSOC))
		{
			$phone = $line['phone'];
		}
		mysql_free_result($R);
		
		if($phone == $this->phone)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function change_pass($pass)
	{
		$pass = Encode($pass);
		$change = dbconn("update coupon_user set password='".$pass."' where name='".$this->user_name."'")or die("change_pass failed");
	}
	
	public function record_aebuserinfo(){
		$username = $_COOKIE['couponUserName'];
		
		if(!$username){
			return false;
		}
		
		$sql = "select uid from users where name = '$username'";
		$res = $this -> db -> fetchOne($sql);
		if($res['uid']){
			$uid = $res['uid'];
			$res = $this -> db -> fetchAll("select fid from profile_values where uid = $uid");	
				
			$bname = false;
			$bday = false;
			$bsex = false;
			if($res){
				foreach($res as $row){
					if($row['fid'] == 2){
						$bname = true;
					}
					else if($row['fid'] == 5){
						$bday = true;
					}
					else if($row['fid'] == 37){
						$bsex = true;
					}					
				}
			}
			
			if($bname){
				$this -> db -> query("update profile_values set value = '$this->baby_name' where uid = $uid and fid = 2");
			}
			else{
				$this -> db -> query("insert into profile_values (fid, uid, value) values(2, $uid, '".$this->baby_name."')");
			}
			
			if($bday){
				$this -> db -> query("update profile_values set value = '".serialize(array('year' => $_POST['year'], 'month' => $_POST['month'], 'day' => $_POST['day']))."' where uid = $uid and fid =5");
			}
			else{
				$this -> db -> query("insert into profile_values (fid, uid, value) values(5, $uid, '".serialize(array('year' => $_POST['year'], 'month' => $_POST['month'], 'day' => $_POST['day']))."')");
			}
			
			$sex = $_POST['baby_sex']=='M'?'男':'女';				
			if($bsex){
				$this -> db -> query("update profile_values set value = '$sex' where uid = $uid and fid =37");
			}
			else{
				$this -> db -> query("insert into profile_values (fid, uid, value) values(37, $uid, '".$sex."')");
			}
		}
	}
	
	public function record_more_info()
	{
		$this->baby_birth = strtotime($this->baby_birth);

		if(!$this->check_info_exist())//inster a new user info
		{
			$this -> db -> query("insert into user_extra_info (uid, baby_name, baby_sex, baby_birth, parent_name, adress) values ('".$this->user_id."', '".$this->baby_name."', '".$this->baby_sex."', '".$this->baby_birth."', '".$this->parent_name."', '".$this->user_adress."')");
		}
		else//update user extra info
		{
			$this -> db -> query("UPDATE user_extra_info SET baby_name='".$this->baby_name."', baby_sex ='".$this->baby_sex."', baby_birth='". $this->baby_birth."', parent_name='".$this->parent_name."', adress='".$this->user_adress."' WHERE uid = ".$this->user_id);
		}
		return 0;//成功
	}
	
	public function record_info_statue($i)
	{//0 is not exist,1 is complete, 2 is not complete, 3 is no info
	
		//check for inster or update
		$R = dbconn("select uid FROM extra_item_value WHERE uid ='".$this->user_id."' and item_id = '3'");
		
		$result = false;
		while ($line = mysql_fetch_array($R, MYSQL_ASSOC))
		{
			$result = true;
		}
		
		if($result)
			$R = dbconn("UPDATE extra_item_value SET state='".$i."' WHERE uid = '".$this->user_id."' and item_id = '3'") or die(mysql_error());//update
		else
			$R2 = dbconn("insert into extra_item_value (uid, item_id, state) values ('".$this->user_id."', (select item_id from extra_item where item_name = 'extra_info'), '".$i."')");//insert
	}
	
	public function check_info_exist()//check there is a user_info or not
	{		
		$res = $this -> db -> fetchOne("select uid FROM user_extra_info WHERE uid =".$this->user_id);			
		if($res['uid']){
			return true;
		}
		return false;
	}
	
	public function check_info_complete()//check the user's info has complete
	{
		$res = $this -> db -> fetchOne("select * FROM user_extra_info WHERE uid =".$this->user_id);
		if(!$res){
			return 0;
		}
		
		if($res['baby_name'] && $res['baby_sex'] && $res['baby_birth'] && $res['parent_name'] && $res['adress']){
			return 1;
		}
		else{
			return 0;
		}

	}
	
	public function my_score_record($limit = 0)
	{
		if($limit == 0)
		{
		$result = dbconn("SELECT consumption_record.time, consumption_merchant.merchant_fullname, consumption_record.score FROM consumption_record, consumption_merchant WHERE consumption_record.uid = '".$this->user_id."' AND consumption_record.mid = consumption_merchant.merchant_id ORDER BY consumption_record.time DESC;") or die("my score record error");//add find merchnt real name
		}
		else
		{
			$result = dbconn("SELECT consumption_record.time, consumption_merchant.merchant_fullname, consumption_record.score FROM consumption_record, consumption_merchant WHERE consumption_record.uid = '".$this->user_id."' AND consumption_record.mid = consumption_merchant.merchant_id ORDER BY consumption_record.time DESC LIMIT ".$limit.";") or die("my score record error");
		}
		
		$r = array();
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			array_push($r, $line);
		}
		
		return $r;
	}
	
	public function search_ad()
	{
		$result = dbconn("SELECT adress FROM user_extra_info WHERE uid = ".$this->user_id) or die("search adress error");
		$ad='';
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$ad = $line['adress'];
		}
		return $ad;
	}
	
	public function search_name()
	{
		$result = dbconn("SELECT parent_name FROM user_extra_info WHERE uid = ".$this->user_id) or die ("search user parent name error");
		$name='';
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$name = $line['parent_name'];
		}
		return $name;
	}
	
	public function find_card_id_by_uid()
	{
		$cid = search_from_table("card_id", "card", "uid", $this->user_id);
		return $cid;
	}
	
	public function select_all_my_info()
	{	
		$res = $this -> db -> fetchOne("select * FROM user_extra_info WHERE uid =".$this->user_id);

		return $res;
	}
	
	public function search_ecoupon_record()
	{
		$result = dbconn("SELECT extra_coupon_value.cid, consumption_coupon.title, consumption_record.uid, coupon_user.mail, coupon_user.phone, user_extra_info.baby_name, user_extra_info.baby_sex, user_extra_info.baby_birth, user_extra_info.parent_name, user_extra_info.adress FROM extra_coupon_value,consumption_record,consumption_coupon,coupon_user LEFT JOIN user_extra_info ON coupon_user.uid = user_extra_info.uid WHERE extra_coupon_value.item_id = 8 AND extra_coupon_value.value = 1 AND consumption_record.cid = extra_coupon_value.cid AND coupon_user.uid = consumption_record.uid AND consumption_coupon.cid = consumption_record.cid;");
		$list = array();
		
		while($line  = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			array_push($list, $line);
		}
		
		return $list;
	}
	
	public function search_present_exchange()
	{
		$result = dbconn("SELECT consumption_exchange.pid, consumption_exchange.uid, consumption_exchange.date, consumption_exchange.send, coupon_user.name, coupon_user.phone, coupon_user.mail, consumption_present.title, user_extra_info.parent_name, user_extra_info.adress FROM coupon_user,consumption_present,consumption_exchange LEFT JOIN user_extra_info ON consumption_exchange.uid = user_extra_info.uid WHERE consumption_exchange.uid = coupon_user.uid AND consumption_exchange.pid = consumption_present.pid;");
		$list = array();
		
		while($line  = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			array_push($list, $line);
		}
		
		return $list;
	}
}
?>