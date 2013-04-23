<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form method="post" action="add_present.php" enctype="multipart/form-data">
        <p><input type="hidden" name="MAX_FILE_SIZE" value="2000000" />fun pictures:
        <input name="file" type="file"  value="浏览" /><br/>
        <label for="file_name">title</label><input type="text" name="file_name"><br/>
        <label for="des">describe</label><input type="text" name="des" /><br/>
        <label for="count">count</label><input type="text" name="count" /><br/>
        <label for="price">price</label><input type="text" name="price" /><br/>
        <label for="score">score</label><input type="text" name="score" /><br/>
        <?php require_once('function.php'); merchant_droplist();?>
        <input type="submit" value="OK" name="B1" /></p>
        </form>
		<?php 
       require_once('present.php');
	   $present = new present();
		if(isset($_FILES['file']['name']))
		{
			$present->upload_file_name = $_FILES['file']['name'];
			$present->upload_file_temp_name = $_FILES['file']['tmp_name'];
			$present->pic = time();
			$present->title = $_POST['file_name'];
			$present->describe = $_POST['des'];
			$present->counts = $_POST['count'];
			$present->price = $_POST['price'];
			$present->score = $_POST['score'];
			$present->mid = $_POST['mid'];
			$present->upload_present();
			
			//echo 'this is mid '.$present->mid;
		}
		?>
        </body>
</html>
