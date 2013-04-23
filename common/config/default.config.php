<?php
/**
 * @filename default.config.php
 * @desc 所有文件都要包含的文件，方便以后统一更改
 * @author alfa@CONDENAST
 * @date 2012-7-12
 */

/// 默认关闭所有调试
$CONFIG["debug"] = true;//true;
$CONFIG['debugip'] = "ALL"; // 允许打开调试的IP
//$CONFIG['debugip'] = array("192.168.1.130");

// ******************* 各个应用的接口内部域名, 用户内部 HTTP 通讯 Begin ***************
$CONFIG['local_domain']['bbs']['self'] = 'http://cj.selfbbsdx2.8dev.net/';
$CONFIG['local_domain']['bbs']['gq'] = 'http://cj.gqbbs.8dev.net/';
$CONFIG['local_domain']['bbs']['vogue'] = 'http://cj.voguebbs.8dev.net/';
// $CONFIG['local_domain']['bbs']['ad'] = '';

$CONFIG['local_domain']['cms']['self'] = 'http://lijuan.voguecms.8dev.net/';
$CONFIG['local_domain']['cms']['gq'] = 'http://lijuan.voguecms.8dev.net/';
$CONFIG['local_domain']['cms']['vogue'] = 'http://lijuan.voguecms.8dev.net/';
// $CONFIG['local_domain']['cms']['ad'] = '';
// ******************* 各个应用的接口内部域名, 用户内部 HTTP 通讯 End ***************

/// 接收短信的URL
$CONFIG["smsserver"]["sendurl"]="http://applications.8dev.net/sms/api/sendsms.php";

/// 验证码接口
$CONFIG["seccode_showAPI"] = 'http://applications.domain.com/seccode/show.php';
/// 这里需要改为内部访问域名
$CONFIG["seccode_verifyAPI"] = 'http://applications.8dev.net/seccode/private/verify.php';

/// 为 common 的开放平台接口服务, 获取 access_token 用的.  
$CONFIG['condeweibo_access_token_api'] = 'http://applications.8dev.net/weibo/private/get_access_token.php';

/// 管理员账号允许的后台域名
$CONFIG["adminuserdomainlist"] = array("8dev.net"=>array("managepath"=>"http://applications.8dev.net/adminuser/","validurl"=>"http://applications.8dev.net/adminuser/api/private/validpermission.php"),
"vogue.com.cn"=>array("managepath"=>"http://application.vogue.com.cn/adminuser/","validurl"=>"http://condenast.local/adminuser/api/private/validpermission.php")
);

/// 管理员后台加密验证key
$CONFIG["adminuserseckey"] = "YIYv9Ww2Oo3G4GC7";
?>