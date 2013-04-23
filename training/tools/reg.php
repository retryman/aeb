<?php
require_once('function.php');
		
		if(isset($_GET['other']))
		{
			$name = $_POST[ 'user_name'];
			$pass = $_POST[ 'user_pass'];
			$rpass = $_POST[ 'user_repass'];
			$mail = $_POST[ 'user_email'];
			$P_name = $_POST['user_P_name'];
			$phone = $_POST['user_phone'];
			$company = $_POST['user_company'];
			$baby_name = $_POST['user_baby_name'];
			$baby_birth = $_POST['user_baby_birth'];
			$adress = $_POST['user_adress'];
			if($name == '' || $pass == '' || $rpass == '' || $mail == '' || $P_name == '' || $phone == ''|| $company == '')
			//if($name == '' || $pass == '' || $rpass == '' || $mail == '' || $P_name == '' || $phone == ''|| $company == ''|| $baby_name == '' || $baby_birth == '')
			{
				echo '<div align="center"><a href="../register_aeb.php"><img src="../sitePIC/error.jpg" border="0"></a></div';
			}		
			else if(register_update($name, $pass, $rpass, $mail, $P_name, $phone, $company, $baby_name, $baby_birth, $adress) == 0)
			{
				setcookie("trainingUserName", $name, time()+2600000, "/training", "aierbang.org");
				//setcookie("trainingUserName", $username, time()+2600000, "/");		
				$id = findUserIdbyName($name);
			
				setcookie("trainingUserID", $id, time()+2600000, "/training", "aierbang.org");
				$url = "../classes.php"; 
				//change page
				header("location: ../classes.php"); //head to another page
			}
			else
			{
				echo '<div align="center"><a href="../register_aeb.php"><img src="../sitePIC/error.jpg" border="0"></a></div';
			}
		}
		else
		{
		
		//$x  = sum($A, $B);
		//$x = Encode($B);
		//echo $x.'</p>';
		//echo "try DB now </p>";
		//selectall();
			$name = $_POST[ 'user_name'];
			$pass = $_POST[ 'user_pass'];
			$rpass = $_POST[ 'user_repass'];
			$mail = $_POST[ 'user_email'];
			$P_name = $_POST['user_P_name'];
			$phone = $_POST['user_phone'];
			$company = $_POST['user_company'];
			$baby_name = $_POST['user_baby_name'];
			$baby_birth = $_POST['user_baby_birth'];
			$adress = $_POST['user_adress'];
			if($name == '' || $pass == '' || $rpass == '' || $mail == '' || $P_name == '' || $phone == ''|| $company == '')
			{
				echo '<div align="center"><a href="../register_aeb.php"><img src="../sitePIC/error.jpg" border="0"></a></div';
			}		
			else if(register($name, $pass, $rpass, $mail, $P_name, $phone, $company, $baby_name, $baby_birth, $adress) == 0)
			{
				setcookie("trainingUserName", $name, time()+2600000, "/training", "aierbang.org");
				//setcookie("trainingUserName", $username, time()+2600000, "/");		
				$id = findUserIdbyName($name);
			
				setcookie("trainingUserID", $id, time()+2600000, "/training", "aierbang.org");
				$url = "../classes.php"; 
				//change page
				header("location: ../classes.php"); //head to another page
			}
			else
			{
				echo '<div align="center"><a href="../register.php"><img src="../sitePIC/error.jpg" border="0"></a></div';
			}
		}
?>