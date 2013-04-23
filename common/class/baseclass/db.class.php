<?php
/**
 * @filename db.class.php
 * @desc 数据库统一操作接口类，
 * @author alfa 2011-2-17
 *
 * Demo:
 * $sql = "SELECT * FROM table_name";
 * $db_obj = new DB("master");
 * //获得一条记录
 * $db_obj->fetchOne($sql);
 * //获得所有记录
 * $db_obj->fetchAll($sql);
 * //获得首行首列
 * $db_obj->fetchSclare($sql)
 **/



class DB
{
	/**
	 * @desc 数据库访问对象
	 * @var obj
	 */
	private $db;
	/**
	 * @desc 保存此次链接的配置名称
	 * @var string
	 */
	private $configname;
	/**
	 * @desc 实例化对象
	 * @var array
	 */
	static private $instance = array();
	/**
	 * @desc Filter 表结构的时候需要用到
	 * @var array
	 */
	static private $tableField = array();

	/**
	 * @desc 初始化数据库
	 * @param  $item 数据库配置文件的Key，数据库的链接数据库在 global $DBCONFIG[$item] 里面
	 * $DBCONFIG = array(
	 * 	"default" => array(
	 * 		"host" => "hostip1:port1",
	 * 		"user" => "username1",
	 * 		"pass" => "password1",
	 * 		"dbname" => "dbname1",
	 * 		"charset" => "UTF8",
	 * 		"pconnect" => true,
	 *  	),
	 *  "master" => array(
	 * 		"host" => "hostip2:port2",
	 * 		"user" => "username2",
	 * 		"pass" => "password2",
	 * 		"dbname" => "dbname2",
	 * 		"charset" => "UTF8",
	 * 		"pconnect" => true,
	 *  	),
	 * );
	 * @return DB
	 * @author alfa  2011-2-17
	 */
	public function __construct($item="mysql_db")
	{
		/// 如果已经链接过就使用当前的链接
		$config = Config::get($item);
		$this->configname = $config;
		$this->db = new Mysql($config['host'], $config['user'], $config['pass'], $config['dbname'], $config['charset'], $config['pconnect']);
//		if(isset(self::$instance[$item]))
//		{
//			$this->db = self::$instance[$item];
//		}
//		else
//		{
//			self::$instance[$item] =  new Mysql($config['host'], $config['user'], $config['pass'], $config['dbname'], $config['charset'], $config['pconnect']);
//			Debug::log("dbconnect", $config,"DB");
//			$this->db = self::$instance[$item];
//		}
	}

	/**
	 * @desc 通过$query获取一行数据
	 * @param  $query 查询语句
	 * @return 数据结果
	 * @author alfa  2011-2-17
	 */
	public function fetch($query)
	{
		$info = $this->db->fetch($query);
		Debug::log($this->configname.":".$query, $info,"DB");
		return $info;
	}

	/**
	 * 如果连接已经断开，则新建连接；
	 * 如果连接还存在，但是已经超时，关闭后再重新连接
	 * @name reconnect
	 * @param Boolean $force_newconnect 是否强制重新创建连接，默认：是。
	 * @desc 重新连接mysql
	 */
	public function reconnect($force_newconnect = true)
	{
		return $this->db->reconnect($force_newconnect);
	}

	/**
	 * @desc 执行SQL语句并返回一行数据
	 * @param  $sql 要执行的sql语句
	 * @return array
	 * @author alfa  2011-2-17
	 */
	public function fetchOne($sql)
	{
		try
		{
			$info = $this->db->fetchOne($sql);
			Debug::log($this->configname.":".$sql, $info,"DB");
		}
		catch (Exception $e)
		{
			$this->halt($e, $sql);
			return false;
		}
		return $info;
	}

	/**
	 *
	 * @desc 执行SQL语句并返回全部数据
	 * @param  $sql 要执行的sql语句
	 * @param  $id Key主键，返回的数组的Key为$id，默认为空,但强烈建议使得此字段
     * @param  $page 是否进行分页 参数：template 分页模板名称 maxnum 显示的记录数 maxpage 显示的最大页数 current 当前页数 modify by yubin
	 * @return array
	 * @author alfa  2011-2-17
	 */
	public function fetchAll($sql, $id = '', $page = false)
	{
		try
		{
            if($page == false)
            {
                $info = $this->db->fetchAll($sql, $id);
            }
            else
            {
                $page['sql'] = $sql;
                $page['db'] = $this;
                $page['id'] = $id;
                $class = Page::getInstance();
                $info = $class->config($page)->get();
                $sql = $info['sql'];
            }
			Debug::log($this->configname.":".$sql, $info,"DB");
				
		}
		catch (Exception $e)
		{
			$this->halt($e, $sql);
			return false;
		}
		return $info;
	}

	/**
	 *
	 * @desc 执行SQL语句并返回第一行第一列
	 * @param  $sql 要执行的sql语句
	 * @return mixed
	 * @author alfa  2011-2-17
	 */
	public function fetchSclare($sql)
	{
		$return = false;
		try
		{
			$info = $this->db->fetchOne($sql, MYSQL_NUM);
			Debug::log($this->configname.":".$sql, $info,"DB");
				
		}
		catch (Exception $e)
		{
			$this->halt($e, $sql);
			return false;
		}
		if(!empty($info))
		{
			$return = $info[0] ;
		}
		return $return;
	}

	/**
	 *
	 * @desc 插入一条记录
	 * @param  $table_name 数据表名
	 * @param  $info 数据表名
	 * @return bool
	 * @author alfa  2011-2-17
	 */
	public function insert($table_name, $info)
	{
		$sql = "INSERT INTO ".$table_name." SET " ;
		foreach ($info as $k => $v)
		{
			$sql .= '`'.$k . "` = '" . $v . "',";
		}
		$sql = substr($sql, 0, -1);
		return $this->query($sql);
	}
	
	/**
	 * @desc 带过滤的插入
	 * @param  $table_name 数据表名
	 * @param  $info 数据表名
	 * @return bool
	 * @author alfa  2011-2-17
	 */
	public function insertWithFillter($table_name, $info, $ignore = false)
	{
		$inssert_ignore = $ignore ? 'IGNORE' : '';
		$fileds = $this->filter($table_name, $info);

		$sql = "INSERT $inssert_ignore INTO ".$table_name." SET " ;
		foreach ($fileds as $field )
		{
			$sql .= '`'. $field . "` = '" . $info[$field] . "',";
		}
		$sql = substr($sql, 0, -1);
		return $this->query($sql);
	}

	/**
	 *
	 * @desc 更新记录
	 * @param  $table_name 数据库表名
	 * @param  $info 需要更新的字段和值的数组
	 * @param  $where 更新条件
	 * @return bool
	 * @author alfa  2011-2-17
	 */
	public function update($table_name, $info, $where)
	{
		if(false === strpos($where, '='))
		{
			return false;
		}
		$sql = "UPDATE ".$table_name." SET " ;
		foreach ($info as $k => $v)
		{
			$sql .= '`'.$k . "` = '" . $v . "',";
		}
		$sql = substr($sql, 0, -1);
		$sql .= " WHERE " . $where ;
		return $this->query($sql);
	}

	/**
	 *
	 * @desc 删除记录
	 * @param  $table_name 数据库表名
	 * @param  $where 删除条件 其中必须要包含"="
	 * @return  bool
	 * @author alfa  2011-2-17
	 */
	public function delete($table_name, $where)
	{
		if(false === strpos($where, '='))
		{
			return false;
		}
		$sql = "DELETE FROM ". $table_name ." WHERE " . $where ;
		return $this->query($sql);
	}
	
	/**
	 *
	 * @desc 事务开始
	 * @return  bool
	 * @author edward.yang  2012-5-4
	 */
	public function tranStart(){
		return $this->query("BEGIN");
	}
	
	/**
	 *
	 * @desc 提交事务
	 * @return  bool
	 * @author edward.yang  2012-5-4
	 */
	public function tranCommit(){
		$res = $this->query("COMMIT");
		if(!$res){
			Debug::log("COMMIT failture", $status,"DB");
			return false;
		}
		return true;
		//return $this->query("END");
	}
	
	/**
	 *
	 * @desc 回滚事务
	 * @return  bool
	 * @author edward.yang  2012-5-4
	 */
	public function tranRollback(){		
		$res = $this->query("ROLLBACK");
		if(!$res){
			Debug::log("ROLLBACK failture", $status,"DB");
			return false;
		}
		return true;
		//return $this->query("END");
	}

	/**
	 *
	 * @desc 执行一条SQL语句
	 * @param  $sql 要执行的sql语句
	 * @return mixed
	 * @author alfa  2011-2-17
	 */
	public function query($sql, $id = '')
	{
		try
		{
			$status = $this->db->query($sql);
			Debug::log($this->configname.":".$sql, $status,"DB");
				
		}
		catch (Exception $e)
		{
			$this->halt($e, $sql);
			return false;
		}
		return $status;
	}

	/**
	 *
	 * @desc 获得前次SQL影响行数
	 * @return int
	 * @author alfa  2011-2-17
	 */
	public function affectedRows()
	{
		$ret = $this->db->affectedRows();
		Debug::log($this->configname.":affectedrows", $ret,"DB");
		return $ret;
	}

	/**
	 *
	 * @desc 获得插入的ID
	 * @return (int) ID
	 * @author alfa  2011-2-17
	 */
	public function insertId()
	{
		$ret =  $this->db->insertId();
		Debug::log($this->configname.":affectedrows", $ret,"DB");
		return $ret;
	}

	/**
	 *
	 * @desc 关闭数据库连接
	 * @return bool
	 * @author alfa  2011-2-17
	 */
	public function close()
	{
		return $this->db->close();
	}

	/**
	 *
	 * @desc 获得错误信息
	 * @return string
	 * @author alfa  2011-2-17
	 */
	public function getError()
	{
		return $this->db->getError();
	}

	/**
	 *
	 * @desc 获得错误编号
	 * @return int
	 * @author alfa  2011-2-17
	 */
	public function getErrno()
	{
		return $this->db->getErrno();
	}

	/**
	 *
	 * @desc 错误处理函数
	 * @param Exception $e
	 * @param  $sql
	 * @return NULL
	 * @author alfa  2011-2-17
	 */
	private function halt(Exception $e, $sql)
	{
		if($e->getCode() > 0)
		{
			$errstr = '' ;
			$errstr .= "Mysql Config:" . $this->configname . "\n";
			$errstr .= "Mysql Errno: ".$e->getCode()."\n" ;
			$errstr .= "Mysql Error: ".$e->getMessage()."\n" ;
			$errstr .= "SQL Statement: " . $sql . "\n" ;
			Debug::log("dberror", $errstr,"DB");
			ErrorLog::addLog($errstr);
			//echo "DataBase Error!";
		}
	}
	
	private function filter($table, $info) 
	{
		$sql = "DESCRIBE " . $table . ";";
		$key = "Field";
		
		if(isset(self::$tableField[$table]))
		{
			return self::$tableField[$table];
		}
		else
		{
			if(false !== ($list = $this->fetchAll($sql))) {
				$fields = array();
				foreach($list as $record)
					$fields[] = $record[$key];
				self::$tableField[$table] = array_values(array_intersect($fields, array_keys($info)));
				return self::$tableField[$table];
			}
		}
		return array();
	}
	
}

?>