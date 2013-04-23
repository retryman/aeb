<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>add_coupon</title>
</head>
<?php
require_once('verifi.php');
if(isset($_POST['title']))
{
$coupon = new coupon();
$coupon->mid = $_POST['mid'];
$coupon->counts = $_POST['counts'];
$coupon->score = $_POST['score'];
$coupon->title = $_POST['title'];
$coupon->used = $_POST['used'];
$coupon->price = $_POST['price'];
$coupon->type = $_POST['type'];
$coupon->e_coupon = $_POST['e_coupon'];
$coupon->describe = $_POST['describe'];
$coupon->upload_file_name = $_FILES['file']['name'];
$coupon->upload_file_temp_name = $_FILES['file']['tmp_name'];

$coupon->add_coupon();
}
?>
<form action="add_coupon.php" method="post" enctype="multipart/form-data">
merchant name
<?php require_once('../../tools/function.php'); merchant_droplist();?><br/>
coupon count<input type="text" name="counts" /><br/>
coupon score<input type="text" name="score" /><br/>
coupon price<input type="text" name="price" /><br/>
coupon title<input type="text" name="title" /><br/>
coupon used<input type="text" name="used" /><br/>
coupon type<select name="type"><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option></select><br/>
coupon eltric(0 is not E-coupon, 1 is E-coupon)<select name="e_coupon"><option value="0" selected="selected">not E-coupon</option><option value="1">is E-coupon</option></select><br/>
coupon describe(for e-coupon only)<input type="text" name="describe" /><br/>
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />e-coupon pic(for e-coupon only)
        <input name="file" type="file"  value="浏览" /><br />
<input type="submit" />
</form>
<body>
</body>
</html>