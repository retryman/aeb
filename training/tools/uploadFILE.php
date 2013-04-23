<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件上传</title>

<script type="text/javascript" src="../scripts/calendar.js"></script>
<?php
//upload images for games
require_once('function.php');
$result = dbconn("select class_title from training_classes");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
	        foreach ($line as $col_value)
			{
				echo $col_value."<br/><br/>";
        	}
    	}
?>
</head>

<body>
<form method="post" action="uploadf.php" enctype="multipart/form-data">
        <p><input type="hidden" name="MAX_FILE_SIZE" value="2000000" />file, text only, MUST use UTF-8 code:
        <input name="file" type="file" value="浏览" />
        <input type="submit" value="上传" name="B1" /></p>
     <p>
     class's title<input type="text" name="ctitle" />
     </p>
     <p>
     class's company<input type="text" name="ccompany" />
     </p>
     <p>
     class's date<input type="text" name="cdate" onclick="new Calendar(1980, 2015).show(this);" size="10" maxlength="10" readonly="readonly"/>
     </p>
     <p>
     class's time<input type="text" name="ctime" />
     </p>
     <p>
     class's lecturer<input type="text" name="clecturer" />
     </p>
     <p>
     class's adress<input type="text" name="cadress" />
     </p>
</form>
</body>
</html>