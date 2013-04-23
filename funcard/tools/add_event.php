<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body><form method="post" action="add_event.php" enctype="multipart/form-data">
<p><input type="hidden" name="MAX_FILE_SIZE" value="2000000" />event text, use utf-8 .txt:
<input name="file" type="file"  value="浏览" /><br/>
<label for="title">title</label><input type="text" name="title"><br/>
<label for="stage">use ";" for spread mutile stages</label><input type="text" name="stage" /><br/></p>
        <input type="submit" value="OK" />
        </form>
<?php
require_once('event_class.php');
if(isset($_FILES['file']['name']))
{
	//echo $_FILES['file']['name'];
	$event = new events(0);
	$event->add_event($_POST['title'], $_FILES['file']['name'], $_POST['stage']);
	
	$upload = new uploader();
	echo $_POST['title'];
	$upload->upload_file($_FILES['file']['name'], $_FILES['file']['tmp_name'], $_FILES['file']['name']);
}
?>
</body>
</html>