<?php
include_once(dirname(__FILE__)."/../../config.php");

global $dblink;
function dbinit(){	
	global $dblink;
	
	$dbconfig = Config::get('mysql_db');
	
	$dblink = mysql_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass']) or die(" Could not connect "); 
	mysql_query("set names utf8");    	
	mysql_select_db($dbconfig['dbname']) or die(" Could not select database ");
}

function dbconn($queryLine)
{
	dbinit();

	$query = $queryLine; 
    $result = mysql_query($query) or die("Query failed");
	global $dblink;
	mysql_close($dblink);
	return $result;
}

function ppdb_affected_rows(){
	global $dblink;
	dbinit();
	$count = mysql_affected_rows($dblink);
	mysql_close($dblink);
	return $count;
}

function ppdb_get_insertID(){	
	dbinit();
	global $dblink;
	$id = mysql_insert_id($dblink);
	mysql_close($dblink);
	return $id;
}
	
function getpwd()
{
	$fileDir = $_SERVER['DOCUMENT_ROOT']."coupon/tools/DB/access/pwd.txt";
	$fileLinuxDir = $_SERVER['DOCUMENT_ROOT']."/funcard/tools/DB/access/pwd2.txt";//absolution directory, change when use Linux
  @$fp = fopen($fileLinuxDir, 'r');
  //@$fp = fopen("/data/aierbang/Game/tools/DB/access/pwd2.txt", 'r')//for linux directroy
  if(!$fp)
  {
	  echo " file open error ".$fileLinuxDir;
	  exit;
  }
  else
  {
	  while(!feof($fp))
	  {
	  	$r = fgets($fp);
		//echo "file is ".$r;
	  }
	  
	  fclose($fp);
  }
  
  return $r;
}
?>
