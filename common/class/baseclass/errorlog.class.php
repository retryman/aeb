<?
/**
 *@filename errorlog.class.php
 *@desc 记录日志类
 * 自动读取记录错误日志
 * 会自动记录日志时间，及Iput等参数
 * 
 * 提示：如果只是想调试，请使用Debug::log
 * 在这里记录的数据会运维会每天定时发送给相关人员
 * 使用方式：
 * ErrorLog::addLog("log msg");
 * ErrorLog::addLog("log msg","orderlog");
 *@author alfa@condenast
 *@date 2011-6-30
 */

class ErrorLog
{
	/**
	 * 
	 * @desc 记录错误日志 
	 * @param  $logmsg 记录内容
	 * @param  $filename 文件名称  不需要加路径 , 系统会自动加上 ".log" 扩展名
	 * @return true
	 * @author alfa@condenast
	 * @date 2011-6-30
	 */
	static public function addLog($logmsg,$filename="errorlog") 
	{
		if(trim($filename) == "")
		{
			$filename = "errorlog";
		}
		$path = Config::get("logpath")."/".date("Ymd")."/".PROJECT_NAME."/".$_SERVER["SERVER_ADDR"]."/" ;
		$logname = $path.$filename.".log";
		//// 如果是第一次建立失败，可能是目录不存在，就建立一次目录
		if(!error_log("============================\n",3,$logname))
		{
			mkdir($path,0777,true);
			@chmod(Config::get("logpath")."/".date("Ymd")."/",0777);
			@chmod(Config::get("logpath")."/".date("Ymd")."/".PROJECT_NAME."/",0777);
			@chmod($path,0777);
			error_log("============================\n",3,$logname);
			@chmod($logname,0777);
		}
		/// 得到调用信息
		$trace = debug_backtrace();
		$traceinfo = array();
		foreach ($trace as $value) 
		{
			array_push($traceinfo,$value["file"].":".$value["line"]." => ".$value["function"]);
		}
		/// 根据调用产生一个MD5值，方便统计
		$callmd5 = md5(var_export($traceinfo,true));
		/// 合成要写入的信息
		$log = "Time:".date("Y-m-d H:i:s")."\n" . 
			"Input:".var_export(Input::getAllInput(),true)."\n" .
			"Log:".$logmsg."\n" .
			"CallMD5:".$callmd5."\n".
			"Call:" .var_export($traceinfo,true)."\n" ;
		/// 写入日志
		error_log($log,3,$logname);
	}
}

?>