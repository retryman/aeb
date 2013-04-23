<?php
ob_start();
session_start();
require_once('event_class.php');

if(isset($_POST['state']) && $_POST['state'] == "new")//for new user reigster
{
$name = $_POST["user_name"];
$email = $_POST["user_email"];
$pass = $_POST["password"];
$repass = $_POST["repass"];
$babyName = $_POST["baby_name"];
$babySex = $_POST["baby_sex"];
$babyBirth = $_POST["baby_birth"];
$parentName = $_POST["parent_name"];
$adress = $_POST["adress"];
$phone = $_POST["phone"];
$stage = $_POST["stage"];
$event_id = $_POST["event_id"];
$currentTime = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

if($name == "" || $email == "" ||$pass == "" ||$repass == "" ||$babyName == "" ||$babySex == "" ||$babyBirth == "" ||$parentName == "" ||$adress == "" ||$phone == "" ||$stage == "")
{
	echo '1';
}
else if($pass != $repass)
{
	echo '2';
}
else
{
	$event = new events($event_id);
	
	//record user base info
	$R = $event->record_user($name, $pass, $repass, $email, $phone);
	$R = 0;
	switch($R)
	{
		case 0:
		{
			//echo "OK";
			$user_id = $event->find_user_id($name);
			//record register event
			$event->event_reg($user_id, $currentTime, $stage);
			
			
			//record user info...
			$event->record_user_more($user_id, $babyName, $babySex, $babyBirth, $parentName, $adress);
			
			$_SESSION['event_result'] = '0';
			header("location: ../event.php?eid=".$event_id);
			break;
		}
		
		case 1:
		{
			//echo "passowrd not match";
			$_SESSION['event_result'] = '1';
			header("location: ../event.php?eid=".$event_id);
			break;
		}
		
		case 2:
		{
			//echo "same user name";
			$_SESSION['event_result'] = '2';
			header("location: ../event.php?eid=".$event_id);
			break;
		}
	}
}
}
else if($_POST['state'] == "old")//already has a account
{
	$name = $_POST["user_name"];
	$stage = $_POST["stage"];
	$event_id = $_POST["event_id"];
	$currentTime = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

	$event = new events($event_id);
	$user_id = $event->find_user_id($name);
	//record register event
	$event->event_reg($user_id, $currentTime, $stage);
	
	$_SESSION['event_result'] = '0';
	//echo "OK";
	header("location: ../event.php?eid=".$event_id);
}
?>