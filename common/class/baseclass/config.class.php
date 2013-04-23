<?
/**
 *@filename config.class.php
 *@desc 读取配置信息
 * 只提供读取功能，读取的config目录下的/PROJECT_NAME.config.php
 * 如果没有检测到则读取：config目录下的/example.config.php
 * PROJECT_NAME要在写在项目的配置文件里面
 * 只读取因调试等因素，因服务器和本地调试变量不一致时使用
 * 要查找的配置一定要在配置文件里面有
 * 项目头文件：
 * ini.php:
 * <?
 * ...
 * define PROJECT_NAME "condenast"
 * ....
 * ?>
 * 配置文件：
 * condenast.config.php:
 * <?
 *  $CONFIG["logpath"] = "/tmp/log/".PROJECT_NAME."/".date("Ymd")."/";
 *  $CONFIG["db_read"] = array("host"=>"192.168.1.1","port"=>3306,"user"=>"root","password"=>"");
 *  $CONFIG["db_write"] = array("host"=>"192.168.1.1","port"=>3306,"user"=>"root","password"=>"");
 * ?>
 * 
 * 使用方式：
 * demo.php:
 * <?
 *  ...
 *  $logfilename = Config::get("logpath")."filename.txt";
 *  ...
 * ?>
 *@author alfa@condenast
 *@date 2011-6-29
 */
class Config
{
	/**
	 * @desc 保存所有配置文件 
	 * @var array
	 */
	static private $configArr = array();
	/**
	 * 
	 * @desc 读取变量名称 
	 * @param  $key 要读取配置文件的名称
	 * @return mixed
	 * @author alfa@condenast
	 * @date 2011-6-29
	 */
	static public function get($key)
	{
		/// 这个项目的配置文件是否被加载过
		if(empty(self::$configArr[PROJECT_NAME]))
		{
			/// 自动加载并赋值
			/// 存在项目文件加载项目文件，否则加载示例文件
			/// 依次检测域名、项目、默认的配置，有哪个载入哪个
			if(isset($_SERVER['SERVER_NAME']) && file_exists(dirname(__FILE__)."/../../config/".$_SERVER['SERVER_NAME']."config.php"))
			{
				require_once dirname(__FILE__)."/../../config/".$_SERVER['SERVER_NAME']."config.php";
			}
			else if(file_exists(dirname(__FILE__)."/../../config/".PROJECT_NAME.".config.php"))
			{
				require_once dirname(__FILE__)."/../../config/".PROJECT_NAME.".config.php";
			}
			else
			{
				require_once dirname(__FILE__)."/../../config/example.config.php";
			}
			self::$configArr[PROJECT_NAME] = $CONFIG;
		}
		/// 查找第一个配置
		if(isset(self::$configArr[PROJECT_NAME][$key]))
		{
			return self::$configArr[PROJECT_NAME][$key];
		}
	}
}

?>