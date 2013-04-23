<?php
set_time_limit(0);

header("Content-Type: text/html; charset=utf-8");
	
	/**
	 * 定义程序绝对路径
	 */
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once ('include/Client.php');

class send_message
{
/**
 * 网关地址
 */	
private $gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';


/**
 * 序列号,请通过亿美销售人员获取
 */
private $serialNumber = '3SDK-DJL-0130-MFQUP';

/**
 * 密码,请通过亿美销售人员获取
 */
private $password = '348360';

/**
 * 登录后所持有的SESSION KEY，即可通过login方法时创建
 */
private $sessionKey = '123456';

/**
 * 连接超时时间，单位为秒
 */
private $connectTimeOut = 2;

/**
 * 远程信息读取超时时间，单位为秒
 */ 
private $readTimeOut = 10;

/**
	$proxyhost		可选，代理服务器地址，默认为 false ,则不使用代理服务器
	$proxyport		可选，代理服务器端口，默认为 false
	$proxyusername	可选，代理服务器用户名，默认为 false
	$proxypassword	可选，代理服务器密码，默认为 false
*/	
private 	$proxyhost = false;
private 	$proxyport = false;
private 	$proxyusername = false;
private 	$proxypassword = false; 

function sendmess($phone = array(), $content)
{
	$client = new Client($this->gwUrl,$this->serialNumber,$this->password,$this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
	/**
 	* 发送向服务端的编码，如果本页面的编码为utf，请使用utf
 	*/
	$client->setOutgoingEncoding("utf-8");
	//$status = $client->login();
	//print_r($phone);
	$message = $client->sendSMS($phone, $content); //send the message
	//$client->logout();
	return $message;
}

/**
 * 短信充值 用例
 */
function chargeUp()
{
	$client = new Client($this->gwUrl,$this->serialNumber,$this->password,$this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
	/**
	 * $cardId [充值卡卡号]
	 * $cardPass [密码]
	 * 
	 * 请通过亿美销售人员获取 [充值卡卡号]长度为20内 [密码]长度为6
	 * 
	 */
		
	$cardId = 'EMY00000000000000000';
	$cardPass = '000000';
	$statusCode = $client->chargeUp($cardId,$cardPass);
	echo "处理状态码:".$statusCode;
}

/**
 * 查询单条费用 用例
 */
function getEachFee()
{
	$client = new Client($this->gwUrl,$this->serialNumber,$this->password,$this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
	$fee = $client->getEachFee();
	return $fee;
}


/**
 * 企业注册 用例
 */
function registDetailInfo()
{
	$client = new Client($this->gwUrl,$this->serialNumber,$this->password,$this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
	
	$eName = "xx公司";
	$linkMan = "陈xx";
	$phoneNum = "010-1111111";
	$mobile = "159xxxxxxxx";
	$email = "xx@yy.com";
	$fax = "010-1111111";
	$address = "xx路";
	$postcode = "111111";
	
	/**
	 * 企业注册  [邮政编码]长度为6 其它参数长度为20以内
	 * 
	 * @param string $eName 	企业名称
	 * @param string $linkMan 	联系人姓名
	 * @param string $phoneNum 	联系电话
	 * @param string $mobile 	联系手机号码
	 * @param string $email 	联系电子邮件
	 * @param string $fax 		传真号码
	 * @param string $address 	联系地址
	 * @param string $postcode  邮政编码
	 * 
	 * @return int 操作结果状态码
	 * 
	 */
	$client->login();
	$statusCode = $client->registDetailInfo($eName,$linkMan,$phoneNum,$mobile,$email,$fax,$address,$postcode);
	$client->logout();
	
	echo "处理状态码:".$statusCode;
	
}

/**
 * 余额查询 用例
 */
function getBalance()
{
	$client = new Client($this->gwUrl,$this->serialNumber,$this->password,$this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
	$balance = $client->getBalance();
	return $balance;
}

function logout()
{
	$client = new Client($this->gwUrl,$this->serialNumber,$this->password,$this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
	$status = $client->logout();
	return $status;
}

function login()
{
	$client = new Client($this->gwUrl,$this->serialNumber,$this->password,$this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
	$status = $client->login('123456');
	return $status;
}

}
?>