<?php
/**
 *@filename input.class.php
 *@desc 分析Requst或者终端提交的数据
 *
 *使用方式：
 *Input::Init();	/// 初始化，这个会在程序一开始就会启动
 *Input::getInput('a');	/// 得到 A 的值，先后检测$_GET、$_POST、终端 哪个有就返回哪个
 *Input::getInput('a','userid','POST'); /// 只得到POST的值，如果没有返回 默认值"userid"
 *@author alfa@condenast
 *@date 2011-6-23
 */

class Input
{
	/**
	 * @desc 保存所有的输入变量
	 * @var array
	 */
	static private $inputArr = array();


	/**
	 *
	 * @desc 构造函数
	 * @return
	 * @author alfa@condenast
	 * @date 2011-6-23
	 */
	function __construct()
	{

	}

	/**
	 *
	 * @desc 初始化操作
	 * @return true
	 * @author alfa@condenast
	 * @date 2011-6-23
	 */
	static public function Init()
	{
		/// 保存GET数据
		self::$inputArr["GET"] = $_GET;
		/// 保存POST数据
		self::$inputArr["POST"] = $_POST;

		/// 分析并保存Term数据
		$tempArr = array();
		global $argc,$argv;	/// $argc 和 $argv 不是全局变量，要在这里面再赋值一次 ：（

		/// 如果参数大于 ，就说明有参数
		if($argc > 1)
		{
			$key = "";
			/// 第一位是程序名称，不用分析
			for($i=1;$i<$argc;$i++)
			{
				/// 以“-”开头，说明是变量，保存Key值
				if(substr($argv[$i],0,1) == "-")
				{
					/// 上一个Key还末失效，就赋值为空
					if($key != "")
					{
						$tempArr[$key] = $key;
					}
					$key = substr($argv[$i],1);
					continue;
				}
				/// 有Key设置为key,否则设置此变量为Key
				if($key != "")
				{
					$tempArr[$key] = $argv[$i];
					$key = "";
				}
				else
				{
					$tempArr[$argv[$i]] = $argv[$i];
				}
			}
		}
		self::$inputArr["TERM"] = $tempArr;
		return true;
	}

	/**
	 *
	 * @desc 得到输入的值
	 * @param  $key Key值，stirng
	 * @param  $defaultvalue 默认值，如果没有任何设置值，则返回此值
	 * @param  $type 类型，只能是 "GET","POST","TERM" ，其它会认为是空
	 * @return int 对应值
	 * @author alfa@condenast
	 * @date 2011-6-23
	 */
	static public function getInput($key,$defaultvalue="",$type="")
	{
		
		$typelist = array("GET"=>"GET","POST"=>"POST","TERM"=>"TERM");
		$type = strtoupper($type);
		if(isset($typelist[$type]))
		{
			$typelist = array($typelist[$type]);
		}
		foreach ($typelist as $value)
		{
			if(isset(self::$inputArr[$value][$key]))
			{
				$defaultvalue = self::$inputArr[$value][$key];
				break;
			}
		}
		return $defaultvalue;
	}

	/**
	 *
	 * @desc 得到所有的输入内容
	 * @return array("GET"=>array(),"POST"=>array(),"TERM"=>array())
	 * @author alfa@condenast
	 * @date 2011-6-30
	 */
	static public function getAllInput()
	{
		return self::$inputArr;
	}

	/**
	 *
	 * @desc 得到客户端的IP
	 * @return 客户端的IP
	 * @author alfa@CONDENAST
	 * @date 2012-1-9
	 */
	static public function GetClientIP()
	{
		static $realip = NULL;

		if ($realip !== NULL)
		{
			return $realip;
		}

		if (isset($_SERVER))
		{
			/// 我们的CDN用了这么一个头信息，没办法，只好加在这儿了
			/// 这么2B的CDN是经常有么？  alfa@condenast 2012/03/14
			if(isset($_SERVER['HTTP_CDN_SRC_IP']))
			{
				$realip = $_SERVER['HTTP_CDN_SRC_IP'];
			}
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

				/* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
				foreach ($arr AS $ip)
				{
					$ip = trim($ip);

					if ($ip != 'unknown')
					{
						$realip = $ip;

						break;
					}
				}
			}
			elseif (isset($_SERVER['HTTP_CLIENT_IP']))
			{
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			}
			else
			{
				if (isset($_SERVER['REMOTE_ADDR']))
				{
					$realip = $_SERVER['REMOTE_ADDR'];
				}
				else
				{
					$realip = '0.0.0.0';
				}
			}
		}
		else
		{
			if(getenv('HTTP_CDN_SRC_IP'))
			{
				$realip = getenv('HTTP_CDN_SRC_IP');
			}
			else if (getenv('HTTP_X_FORWARDED_FOR'))
			{
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_CLIENT_IP'))
			{
				$realip = getenv('HTTP_CLIENT_IP');
			}
			else
			{
				$realip = getenv('REMOTE_ADDR');
			}
		}

		preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
		$realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

		return $realip;
	}
}

?>