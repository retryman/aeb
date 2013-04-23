<?php
ob_start();
session_start();
require_once('function.php');
require_once('class_code.php');
require_once('class_record.php');

$userobj = new users();

$code = new code();

$other = $_GET['other'];

switch($other)
{
	case "na"://注册			
		if(isset($_POST['passport']))//use passport for register
		{
		
		}
		else//normal register
		{
			$name = $_POST[ 'name'];
			$pass = $_POST[ 'password'];
			$rpass = $_POST[ 'repassword'];
			$mail = $_POST[ 'email'];
			$phone = $_POST['phone'];
			$other = $_GET['other'];
			$code_no = $_POST['invent_code'];
			
			$error = 0;
			$code_use = 0;//does user has a invent code?
			
			if($name == '' || $pass == '' || $rpass == '' || $mail == '' || $phone == '')//check for info is complete
			{
				
				$info = array('name'=>$name, 'email'=>$mail, 'phone'=>$phone);
				$_SESSION['info'] = $info;
				//信息不完整
				$error = 1;
			}
			else if($code_no != '')//check for invent code
			{
				$code_use = 1;
				if($code->check_code($code_no) != 0)//not 0, error
				{
					$info = array('name'=>'', 'email'=>$mail, 'phone'=>$phone);
					$_SESSION['info'] = $info;
					//邀请码错误
					$error = 3;
				}
			}
			
			if($error == 0)//info is OK, try register
			{
				$e = register($name, $pass, $rpass, $mail, $phone, $other);
				if($e == 0)//register($name, $pass, $rpass, $mail, $phone, $other) == 0
				{
					$id = findUserIdbyName($name);//find out user id
					
					if($code_use == 1)//if the user has a code
					{
						//reocrd the code's score
						$code->record_code($code_no, $id);//record the invent code
						$record = new my_record();
						
						$record->uid = $id;
						$record->cid = 59;//VIP's coupon id
						$record->mid = 28;//VIP's merchant id
						$record->card_id = $record->find_card_by_uid();
						$record->score = 100;//VIP code score
						$record->shop_time = date("Y-m-d H:i:s");
						$record->price = 0;
						$record->counts = -1;
						
						$record->record_all();
					
					}
					
					

					$error = 0;
				}
				else if($e == 2)
				{
					$info = array('name'=>'', 'email'=>$mail, 'phone'=>$phone);
					$_SESSION['info'] = $info;
					//用户名重复
					$error = 2;
				}
				else if($e == 1)//密码不匹配
				{
					$info = array('name'=>'', 'email'=>$mail, 'phone'=>$phone);
					$_SESSION['info'] = $info;
					$error = 4;
				}
			}
		}
		
		if($error == 0)//complete, return error or go to next step
		{			
				$userobj -> setUserCookie($name, $id);


				$_SESSION['new_reg'] = 1;//first time registe;
				
				
				$aebres = dbconn("select uid from users where name='".$name."'");
				$row = mysql_fetch_array($aebres, MYSQL_ASSOC);
			
				if($row['uid']){
					setcookie("uid", $row['uid'], time()+2600000, "/","aierbang.org");
					$userobj -> aebUserLogin($row['uid']);
				}
				
				
				$url = "../active.php"; 
				echo "<script language='javascript' type='text/javascript'>"; 
				echo "window.location.href='$url'"; 
				echo "</script>"; 
		}
		else
		{
			$url = "../register.php?error=".$error; 
			echo "<script language='javascript' type='text/javascript'>"; 
			echo "window.location.href='$url'"; 
			echo "</script>"; 
		}			
	break;
	
	
	case "ibm"://ibm注册
		$name = $_POST[ 'name'];
		$pass = $_POST[ 'password'];
		$rpass = $_POST[ 'repassword'];
		$mail = $_POST[ 'email'];
		$phone = $_POST['phone'];
		if($name == '' || $pass == '' || $rpass == '' || $mail == '' || $phone == '')
		{
			$info = array('name'=>$name, 'email'=>$mail, 'phone'=>$phone);
			$_SESSION['info'] = $info;
			header("location: ../register.php?error=1");//信息不完整
		}		
		else if(register($name, $pass, $rpass, $mail, $phone, $other) == 0)
		{
			setcookie("couponUserName", $name, time()+2600000, "/funcard", "aierbang.org");					
			$id = findUserIdbyName($name);					
			setcookie("couponUserID", $id, time()+2600000, "/funcard", "aierbang.org");					
			header("location: ../mypage.php"); //head to another page
		}
		else
		{
			$info = array('name'=>'', 'email'=>$mail, 'phone'=>$phone);
			$_SESSION['info'] = $info;
			header("location: ../register.php?error=2");//用户名重复
		}
	break;
	
	
	case "aeb"://aeb注册
		$name = $_POST['name'];
		$pass = $_POST['pass'];
		if($name == '' || $pass == '')
		{
				$info = array('name'=>$name, 'email'=>$mail, 'phone'=>$phone);
				$_SESSION['info'] = $info;
				header("location: ../register.php?error=1");//信息不完整
		}
		else
		{
			$re = register_aeb($name, $pass);
			if($re != '')
			{
				setcookie("couponUserName", $name, time()+2600000, "/", "aierbang.org");
			
				$id = findUserIdbyName($name);
		
				setcookie("couponUserID", $id, time()+2600000, "/", "aierbang.org");

				header("location: ../mypage.php"); //head to another page
			}
			else
			{
				$info = array('name'=>'', 'email'=>$mail, 'phone'=>$phone);
				$_SESSION['info'] = $info;
				header("location: ../register.php?error=2");//用户名重复
			}
		}
	break;
	
	case "phone"://更新电话号码
		$phone = $_POST["phone"];
		
		if($_COOKIE["couponUserID"]){
			$_SESSION['new_reg'] = 1;
			$userobj -> setUserPhone($phone, $_COOKIE["couponUserID"]);
			recordCard($_COOKIE["couponUserID"]);
			core_redirect("/funcard/active.php?type=phone");
		}
		break;
	
}

		
?>