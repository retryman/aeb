<?php
function conn()
	{
		$result = new mysqli('localhost', 'root', '', 'sitetest');
		if(!$result)
		{
			throw new Exception('could not connect to DB');
		}
		else
		{
			return $result;
		}
		
		/*$con = mysql_connect("localhost", "root","");
	
		if (!$con)
		{
			die("can't connect" .mysql_error());
		}
	
		mysql_select_db("sitetest", $con);
		mysql_query("set character ser 'utf8'");
		$sql = "SELECT * FROM users";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);

		echo "id is ".$row['password']."|||";

		//mysql_close($con);*/
	}
?>