<?php

//record the pic name and ID into database
require_once('function.php');

/*设置文件保存目录 注意包含*/
$uploaddir = "../Coupon_text/";

/*设置允许上传文件的类型*/
$type=array("txt");

/*程序所在路径*/
//$patch="http://www.dreamdu.com/cr_downloadphp/upload/files/";

/*获取文件后缀名函数*/
function fileext($filename)
{
        return substr(strrchr($filename, '.'), 1);
}

$a = strtolower(fileext($_FILES['file']['name']));

/*判断文件类型*/
if(!in_array(strtolower(fileext($_FILES['file']['name'])),$type))
{
        $text=implode(",",$type);
        echo "您只能上传以下类型文件: ",$text,"<br>";
} 
else
{		
		$coupon_ID = find_coupon_ID_by_name($_POST['cname']);//check coupon ID
		//$coupon_ID = "1";
		$fileName = $_POST['cname'].".".$a;
		$tableName = "merchant";
		$uploadfile=$uploaddir.$fileName;
		file_exists($uploadfile);
		
        if (move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile))
        {
			if(upload_text_to_DB($coupon_ID, $fileName))
			{
                //if(is_uploaded_file($_FILES['file']['tmp_name']))
               // {
                        //输出图片预览
                        echo"<br><center><a href='javascript:history.go(-1)'>j继续上传</a></center>";
                //}
               // else
               // {
               //         echo "上传失败！";
               // }
			}
			else
			{
				echo "ERROR";
			}
        }
}
?>