<?php
/// 定义项目名称
define("PROJECT_NAME", "passport");
/// 定义项目根路径
define("PROJECT_ROOT_PATH",dirname(__FILE__));
/// 包含基本类文件
include PROJECT_ROOT_PATH."/../common/ini.php";

ini_set("display_errors","Off");
//error_reporting(E_WARNING);


//header模板中用到
$logged_in = global_getuid()>0?true:false;


function global_getuid(){
	$sid = $_COOKIE['PHPSESSID'];
	//获取用户当前状态
	$db = new DB();
	$sql = "select uid from sessions where sid = '$sid'";
	$res = $db -> fetchOne($sql);
	
	return $res['uid'];
}