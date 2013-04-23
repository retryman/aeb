<?php
/**
 * @filename cache.class.php
 * @desc Cache操作类，目前只支持Memcache
 * @author alfa 2011-2-17
 *
 * Demo:
 * $obj = new Cache();
 * $obj ->set("key1","value1");
 * echo $obj->get("key1");
 *
 * 将会输出：
 * value1;
 **/

class Cache
{

	/**
	 * @desc 保存当前的 memcache 对象实例
	 * @var memcache
	 */
	private $memcached;
	/**
	 * @desc 保存所有的memcache类，不用重复链接
	 * @var array
	 */
	static private $instance = array();
	/**
	 * @desc 保存错误信息
	 * @var string
	 */
	private $errorDesc;

	/**
	 * @desc 构造函数，保存Cache信息
	 * @param  $item
	 * @return Cache
	 * @author alfa  2011-2-17
	 */
	public function __construct($item = "memcache")
	{
		if(isset(self::$instance[$item]))
		{
			$this->memcached = self::$instance[$item];
		}
		else
		{
			$configArr = Config::get($item);
			$obj = new Memcached;
			foreach ($configArr as $config)
			{
				$ret = $obj ->addServer($config["host"], $config["port"], $config["weight"]);
			}
			Debug::log("Connet", $configArr,"cache");

			self::$instance[$item] = $obj;
			$this->memcached = self::$instance[$item];
		}
	}


	/**
	 *
	 * @desc 新增加一对键值Key Value
	 * @param  $key 键 ，必须是字符串
	 * @param  $val 值
	 * @param  $expire 过期时间，单位（秒）
	 * @param  $pname 是否在key前加上项目名（默认加上，防止多个项目的key冲突） add by edward.yang
	 * @return boolean
	 * @author alfa  2011-2-17
	 */
	public function add($key, $val,  $expire = 0, $pname = true)
	{
		if(!is_string($key))
		{
			return false;
		}
		
		if($pname){
			$key = PROJECT_NAME.'_'.$key;
		}
		
		Debug::log("add:".$key, $val,"cache");
		if($this->memcached->add($key, $val, $expire)){
			return true;
		}
		return false;
	}

	/**
	 * @desc 设置新的值
	 * @param  $key 键 ，必须是字符串
	 * @param  $val 值
	 * @param  $expire 过期时间，单位（秒）
	 * @param  $pname 是否在key前加上项目名（默认加上，防止多个项目的key冲突） add by edward.yang
	 * @return boolean
	 * @author alfa  2011-2-17
	 */
	public function set($key, $val,  $expire = 0, $pname = true)
	{
		if (!is_string($key))
		{
			return false;
		}
		
		if($pname){
			$key = PROJECT_NAME.'_'.$key;
		}
				
		$ret = $this->memcached->set($key, $val,  $expire);
		Debug::log("set:".$key.":".$ret, $val,"cache");
		
		return $ret;
	}

	/**
	 * @desc 设置多个Key
	 * @param Array $itemArr 要保存的数组
	 * @param int $expire 超时
	 * @param  $pname 是否在key前加上项目名（默认加上，防止多个项目的key冲突） add by edward.yang
	 * @return Mixed 从Memcache取得的数据
	 * @author alfa 2011-10-31
	 */
	public function SetMultipleKey ($itemArr, $expire=300, $pname = true) 
	{
		if($pname){
			foreach($itemArr as $key => $value){
				unset($itemArr[$key]);
				$itemArr[PROJECT_NAME.'_'.$key] = $value;				
			}
		}
		
		$ret = $this->memcached->setMulti($itemArr, $expire);
		Debug::log("setmultiple:".$ret, $itemArr,"cache");
		return $ret;
	}
	
	/**
	 * @desc 得到多个Key的信息
	 * @param string $keyArr 要读取的Key的列表
	 * @param  $pname 是否在key前加上项目名（默认加上，防止多个项目的key冲突） add by edward.yang
	 * @return boolean 保存是否成功
	 * @author alfa 2011-10-31
	 */
	public function GetMultipleKey($keyArr, $pname = true) 
	{	
		if($pname){
			foreach($keyArr as $key => $value){				
				$keyArr[$key] = PROJECT_NAME.'_'.$value;				
			}
		}
			
		$retinfo = $this->memcached->getMulti($keyArr);
		
		Debug::log("GetMultipleKey", $retinfo,"cache");
		return $retinfo;
	}

	/**
	 * @desc 获取对应的Key值
	 * @param  $key 键 ，Stirng
	 * @param  $pname 是否在key前加上项目名（默认加上，防止多个项目的key冲突） add by edward.yang
	 * @return mixed
	 * @author alfa  2011-2-17
	 */
	public function get($key, $pname = true)
	{
		if($pname){
			$key = PROJECT_NAME.'_'.$key;
		}
		
		$result = $this->memcached->get($key);
		Debug::log("get:".$key, $result,"cache");
		return $result;
	}

	/**
	 * @desc 关闭链接
	 * @return boolean
	 * @author alfa  2011-2-17
	 */
	public function close()
	{
		if($this->memcached->close()){
			return true;
		}
		return false;
	}

	/**
	 * @desc 删除一个键值
	 * @param  $key 键值
	 * @param  $pname 是否在key前加上项目名（默认加上，防止多个项目的key冲突） add by edward.yang
	 * @return boolean
	 * @author alfa  2011-2-17
	 */
	public function delete($key, $pname = true)
	{
		if($pname){
			$key = PROJECT_NAME.'_'.$key;
		}
				
		Debug::log("del:".$key, "0","cache");
		if($this->memcached->delete($key, 0)){
			return true;
		}
		return false;
	}

	/**
	 * @desc 设置信息
	 * @param  $errorDesc 错误信息描述
	 * @return NULL
	 * @author alfa  2011-2-17
	 */
	public function setError($errorDesc)
	{
		$this->errorDesc = $errorDesc;
	}

	/**
	 * @desc 返回错误信息
	 * @return 错误信息
	 * @author alfa  2011-2-17
	 */
	public function getError()
	{
		return $this->errorDesc;
	}

}

?>