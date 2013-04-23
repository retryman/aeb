<?php
/// 默认关闭所有调试
$CONFIG["debug"] = true;//true;
$CONFIG['debugip'] = "ALL"; // 允许打开调试的IP
//$CONFIG['debugip'] = array("192.168.1.130");

/// 日志目录
$CONFIG["logpath"] = dirname(__FILE__)."/../log";


//测试数据库配置
$CONFIG["mysql_db"] = array("host" => "127.0.0.1",
                        "user" => "root",
                        "pass" => "123456",
                        "dbname" => "aeb",
                        "charset" => "UTF8",
                        "pconnect" => false,
);

//线上数据库配置
//$CONFIG["mysql_db"] = array("host" => "hqu-0042.hichina.com",
//                        "user" => "hqu00421",
//                        "pass" => "n6y6d2e7",
//                        "dbname" => "hqu00421_db",
//                        "charset" => "UTF8",
//                        "pconnect" => false,
//);

/*
$CONFIG["baseurl"] = 'http://edward.comment.8dev.net/trunk/';
$CONFIG["imgurl"] = 'http://edward.comment.8dev.net/trunk/';

$CONFIG["fronturl"] = 'http://edward.comment.8dev.net/trunk/ajax/';


$CONFIG['memcache'] = array(
	array("host"=>"192.168.1.205","port"=>11211,"weight"=>100),
);
*/
?>