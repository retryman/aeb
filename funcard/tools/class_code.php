<?php
require_once('function.php');
class code
{
	private $code;
	private $uid;
	private $used;
	private $level;
	
	public function __construct($code='')
	{
		$this->code = $code;
	}
	
	public function set_uid($uid)
	{
		$this->uid = $uid;
	}
	
	public function creat_code($number, $level)
	{
		for($i = 0; $i<$number; $i++)
		{
			$code = $this->random(8);
			$R = dbconn("insert into invent_code (code, used, level) values ('".$code."', '0', '".$level."');") or die(mysql_error());
		}
	}
	
	private function random($pw_length = 5)   
	{  
		$randpwd = '';  
		for ($i = 0; $i < $pw_length; $i++)  
		{  
			$randpwd .= chr(mt_rand(65, 90));  
		}  
		return $randpwd;  
	}
	
	public function check_code($code)
	{
		$R = dbconn("select used from invent_code where code ='".$code."'");
		$used = 1;
		while($line  = mysql_fetch_array($R, MYSQL_ASSOC))
		{
			$used = $line['used'];
		}
		mysql_free_result($R);
		return $used;//0 is new one, 1 is used
	}
	
	public function record_code($code, $uid)
	{	
		$R = dbconn("UPDATE invent_code SET used='1', uid='".$uid."' WHERE code = '".$code."'");
	}
	
	public function search_user_by_code()//find out which one is used and all the user's info
	{
		$result = dbconn("SELECT invent_code.uid, invent_code.code,extra_item_value.state, coupon_user.mail,coupon_user.phone,user_extra_info.baby_name,user_extra_info.baby_sex,user_extra_info.baby_birth,user_extra_info.parent_name,user_extra_info.adress FROM invent_code,coupon_user,user_extra_info,extra_item_value WHERE invent_code.used = '1' AND invent_code.uid = coupon_user.uid AND invent_code.uid = user_extra_info.uid AND invent_code.uid = extra_item_value.uid AND extra_item_value.item_id = 1;");
		
		$list = array();
		
		while($line  = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			array_push($list, $line);
		}
		
		return $list;
	}
}
?>