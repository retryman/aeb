<?php
/**
 * @filename mysql.class.php
 * @desc Mysql的一些基本操作
 *
 * @author alfa 2011-2-17
**/

class Mysql
{
	/**
	 * @desc 字符集
	 * @var string
	 */
	private $language;
	/**
	 * @desc 主机名称
	 * @var string
	 */
	private $host;
	/**
	 * @desc 用户名
	 * @var string
	 */
	private $user;
	/**
	 * @desc 密码
	 * @var string
	 */
	private $password;
	/**
	 * @desc 数据库名
	 * @var string
	 */
	private $dbname;
	/**
	 * @desc 是否使用pconnet方式链接 
	 * @var bool
	 */
	private $pconnect;

	/**
	 * @desc 是否已经链接到数据库
	 * @var bool
	 */
	private $link = false;
	
	/**
	 * @desc 构造函数 不建议开发人员直接使用此类，建议使得DB类
	 * @param  $host 主机名称
	 * @param  $user 用户名
	 * @param  $password 密码
	 * @param  $dbname 数据库名称
	 * @param  $charset 字符集
	 * @param  $pconnect 是否使用pconnet方式链接
	 * @author alfa  2011-2-17
	 */
	public  function __construct($host, $user, $password, $dbname, $charset, $pconnect) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->language = $charset;
		$this->pconnect = $pconnect;
	}
	/**
	 * @desc 创建一个链接，链接到数据库
	 * @return boolean 链接是否成功
	 * @author alfa  2011-2-17
	 */
	private function connect()
	{

		if($this->pconnect)
		{
			$this->link = @mysql_pconnect($this->host, $this->user, $this->password);
		}else 
		{
			$this->link = @mysql_connect($this->host, $this->user, $this->password, 1);
		}		
/*		
		if($this->link === false)
		{
			if($this->pconnect)
			{
				$this->link = @mysql_pconnect($this->host, $this->user, $this->password);
			}else 
			{
				$this->link = @mysql_connect($this->host, $this->user, $this->password, 1);
			}
			if( false ===  $this->link ) 
			{
				return false;
			}
			if($this->language) 
			{
				$this->query("SET NAMES ".$this->language."");
			}
		}
*/		
		if($this->language) 
		{			
			mysql_query("SET NAMES ".$this->language."");
		}
		mysql_select_db($this->dbname);
		return true ;
	}
	

	/**
	 * 
	 * @desc 重新链接数据库
	 * @param  $force_newconnect 是否强制重新链接，默认为 true
	 * @return 链接是否成功 
	 * @author alfa  2011-2-17
	 */
	public function reconnect($force_newconnect = true)
	{
		if ($force_newconnect)
		{	// 强制重新连接
			$this->close();
			$this->connect();
		}
		else if ($this->link == false)
		{	// 连接已经断开，重新连接
			$this->connect();
		}
		else if (!@mysql_ping($this->link))
		{	// 连接超时断开，关闭后重新连接
			$this->close();
			$this->connect();
		}
	}

	/**
	 * @desc 关闭此次链接
	 * @return 关闭是否成功
	 * @author alfa  2011-2-17
	 */
	public function close() {
		$ok = @mysql_close($this->link);
		$this->link = false;
		return $ok;
	}

	/**
	 * @desc 查询语句
	 * @param  $sql 要执行的Sql语句
	 * @throws Exception 抛出标准异常
	 * @return 返回的结果或者false
	 * @author alfa  2011-2-17
	 */
	public function query($sql) {
		if(false === $this->connect())
		{
			//抛出错误信息
			throw new Exception($this->getError(), $this->getErrno());
			return false;
		}
		$query = @mysql_query($sql,$this->link);
		if(false === $query)
		{
			if (in_array($this->getErrno(), array(2006, 2013)))
			{	// 出现 2006, 2013 的异常代码，重连后再次执行
				$this->reconnect(false);
				$query = @mysql_query($sql,$this->link);
				if ($query !== false)
				{
					return $query;
				}
			}
			//抛出错误信息
			throw new Exception($this->getError(), $this->getErrno());
			return false;
		}
		return $query;
	}

	/**
	 * @desc 检测影响行数
	 * @param $query 查询语句
	 * @return (int)影响的行数
	 * @author alfa  2011-2-17
	 */
	public function numRows($query) {
		$query = @mysql_num_rows($query);
		return $query;
	}

	/**
	 * @desc 上一次查询影响的行数
	 * @return (int)行数
	 * @author alfa  2011-2-17
	 */
	public function affectedRows() {
		return @mysql_affected_rows($this->link);
	}
	
	/**
	 * @desc 取得结果集中字段的数目
	 * @param $query 查询语句
	 * @return (int)字段数
	 * @author alfa  2011-2-17
	 */
	public function numFields($query) {
		return @mysql_num_fields($query);
	}

	/**
	 * @desc 获得完整结果集
	 * @param  $sql SQL语句
	 * @param  $id 是否把  id 作为数组的 key, 选项 - TRUE | FALSE, 默认为 FALSE
	 * @param  $method 排列顺序
	 * @return mixed 数据
	 * @author alfa  2011-2-17
	 */
	public function fetchAll($sql, $id = FALSE , $method = MYSQL_ASSOC) {
		$res = $this->query($sql);
		if(false === $res) return false;
		$result = array();
		if ($id)
		{
			while($row = $this->fetch($res,$method)){
				$result[$row[$id]]=$row;
			}
		}
		else
		{
			while($row = $this->fetch($res,$method)){
				$result[]=$row;
			}
		}
		return $result;
	}

	/**
	 * @desc 得到一条数据
	 * @param  $sql SQL 语句
	 * @param  $method 排列顺序
	 * @return 查询结果
	 * @author alfa  2011-2-17
	 */
	public function fetchOne($sql, $method=MYSQL_ASSOC){
		$res = $this->query($sql);
		if(false === $res) return false;
		$result = $this->fetch($res,$method);
		return $result;
	}
	/**
	 * @desc 得到所有数据
	 * @param  $query SQL语句
	 * @param  $method 排列方式
	 * @return 数据结果
	 * @author alfa  2011-2-17
	 */
	public function fetch($query, $method = MYSQL_ASSOC) {
		$res = @mysql_fetch_array($query, $method);
		return $res;
	}
	
	/**
	 * 
	 * @desc 得到上一次插入产生的ID
	 * @return int 
	 * @author alfa  2011-2-17
	 */
	public function insertId(){
		$id = @mysql_insert_id($this->link);
		return $id;
	}

	/**
	 * 
	 * @desc 释放结果内存
	 * @param  $query SQL语句
	 * @return  Boolean
	 * @author alfa  2011-2-17
	 */
	public function freeResult($query){
		return @mysql_free_result($query);
	}

	/**
	 * @desc 得到错误编号
	 * @return (int)错误编号
	 * @author alfa  2011-2-17
	 */
	public function getErrno()
	{
		return mysql_errno();
	}

	/**
	 * 
	 * @desc 得到错误消息
	 * @return (string)错误消息
	 * @author alfa  2011-2-17
	 */
	public function getError()
	{
		return mysql_error();
	}
}
?>