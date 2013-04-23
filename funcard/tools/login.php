<?php
require_once('function.php');
$username = $_POST['name'];
$passowrd = $_POST['password'];

$userobj = new users();

$userobj -> doUserLogin($username, $passowrd);

?>