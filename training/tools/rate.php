<?php
require_once('function.php');
$score = $_GET['score'];
$cid = $_GET['cid'];
class_rate($cid, $score);
header("location: ../classes.php?class_ID=".$cid); //head to another page
?>