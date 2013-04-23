<?php
/**
 *@filename string.class.php
 *@desc 字符串的一些操作
 *
 *@author alfa@condenast
 *@date 2011-6-22
 */

class String
{

	/**
	 *
	 * @desc 判断一传递进来的是否为字符串
	 * @param $email string 字符串
	 * @return boolean
	 * @author alfa@condenast
	 * @date 2011-6-22
	 */
	static public function isEmail($email)
	{
		return filter_var($email,FILTER_VALIDATE_EMAIL);
	}


	/**
	 *
	 * @desc 判断是否为手机号
	 * @param  $mobile string 手机号
	 * @return boolean
	 * @author alfa@condenast
	 * @date 2011-6-22
	 */
	static public function isMobileChina($mobile)
	{
		if(!preg_match('/^[1]{1}[3|4|5|8]{1}[0-9]{9}$/', $mobile))
		{
			return false;
		}
		return $mobile;
		
	}

	/**
	 *
	 * @desc 生成一个随机字符串
	 * @param  $len 字符串长度
	 * @param  $type 类型 0=数字 1=全小写 2=全大写 3=大小写 4=大小写+数字 其它=4
	 * @return string
	 * @author alfa@condenast
	 * @date 2011-6-22
	 */
	static public function RandStr($len,$type=4)
	{
		/// 可使用的字符
		$sourceStr= array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
		$typeArr = array(
			0=>array("min"=>0,"max"=>9),	/// 全数字
			1=>array("min"=>10,"max"=>35),	/// 全小写
			2=>array("min"=>36,"max"=>61),	/// 全大写
			3=>array("min"=>10,"max"=>61),	/// 大小写
			4=>array("min"=>0,"max"=>61),	/// 数字+大小写
			);
		/// 如果类型错误默认为4
		if(!isset($typeArr[$type]))
		{
			$type = 4;
		}
		/// 生成随机码
		$randstr="";
		for($i=0;$i<$len;$i++)
		{
			$randstr .= $sourceStr[rand($typeArr[$type]["min"],$typeArr[$type]["max"])];
		}
		return $randstr;
	}
	
	/**
	 * @desc 转义用户提交数据中的有害字符，只针对mysql数据库
	 * @param  $str 用户提交的字符串 
	 * @return string
	 * @author edward
	 * @date 2012-4-13
	 */
	static public function EscapeMysqlStr($str)
	{		
		static $status;
		if($status === null){
			$status = get_magic_quotes_gpc();
		}
		else if($status){
			$str = stripslashes($str);
		}
				
		return mysql_escape_string($str);
	}
	
	/**
	 *  @desc 
	 *  		把数组处理为适合 sql 查询时的 in 语句 
	 *  
	 *  @example
	 *  		$uid_array = array(1, 2, 3);
	 *  		$uids_sql = String::Dimplode($uid_array);
	 *  		$db->query("SELECT * FROM user_table WHERE uid IN ($uids_sql)");
	 *  
	 * @param array $array
	 * @return string|boolean
	 */
	static public function Dimplode($array) 
	{
		if(!empty($array)) {
			return "'".implode("','", is_array($array) ? $array : array($array))."'";
		} else {
			return false;
		}
	}
}
?>