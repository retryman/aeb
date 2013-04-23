<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件上传</title>
<?php
//upload images for games
require_once('function.php');
$result = dbconn("select coupon_name from coupons");
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
<form method="post" action="upload.php" enctype="multipart/form-data">
        <p><input type="hidden" name="MAX_FILE_SIZE" value="2000000" />fun pictures:
        <input name="file" type="file"  value="浏览" />
        <input type="submit" value="上传" name="B1" /></p>
     <p>   pic type<input type="text" name="picType" /> 1 for  logo, 2 for coupon, 3 for icon</p>
     <p>
     coupon's name<input type="text" name="cname" />
     </p>
</form>
</body>
</html>