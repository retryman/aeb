<?php
function dbconn($queryLine)
	{
//		$link = mysql_connect("localhost", "root", "") 
		//$link = mysql_connect("localhost", "abcd", getpwd()) 
  //      or die(" Could not connect "); 
   		//print " Connected successfully "; 
//		mysql_query("SET NAMES 'utf8'");
  //  	mysql_select_db("coupon") or die(" Could not select database ");
	
	$link = mysql_connect("hqu-0042.hichina.com", "hqu00421", "n6y6d2e7") 
        or die(" Could not connect "); 
   	//	print " Connected successfully "; 
mysql_query("set names utf8");    	
mysql_select_db("hqu00421_db") or die(" Could not select database ");
	
    /* Performing SQL query */
	    $query = $queryLine; 
    	$result = mysql_query($query) or die("Query failed");
	
    /* Closing connection */ 
	    mysql_close($link);
		return $result;
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
