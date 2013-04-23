<?php

//record the pic name and ID into database
require_once('function.php');

/*设置文件保存目录 注意包含*/
$uploaddir = "../Mpic/";

/*设置允许上传文件的类型*/
$type=array("jpg","gif","bmp","jpeg","png");

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
		$picType = $_POST['picType'];
		
		if($picType == 1)//merchant logo
		{
			$ID = checkID("merchant_ID", "merchant");//check merchant ID
			$picName = $_POST['name']."_logo.".$a;
			$merchant_name = $_POST['name'];
			$tableName = "merchant";
			$uploadfile=$uploaddir.$picName;
			file_exists($uploadfile);
		
        if (move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile))
        {
			if(uploadMerchantToDB($picName, $tableName, $ID, $merchant_name))
			{
                //if(is_uploaded_file($_FILES['file']['tmp_name']))
               // {
                        /*输出图片预览*/
                        echo "<center>您的文件已经上传完毕 上传图片预览: </center><br><center><img src='$uploadfile'></center>";
                        echo"<br><center><a href='javascript:history.go(-1)'>继续上传</a></center>";
                //}
               // else
               // {
               //         echo "上传失败！";
               // }
			}
			else
			{
				echo "pic name is same, try again please";
			}
        }
		}
		
		else if($picType == 2)//coupon pic
		{
			$couponID = checkID("coupon_ID", "coupons");
			$picName = $_POST['name']."_".$couponID.".".$a;
			$tableName = "coupons";
			$uploadfile=$uploaddir.$picName;
			file_exists($uploadfile);
			$merchantID = findMerchantIDbyName($_POST['name']);
			
        if (move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile))
        {
			if(uploadCouponToDB($picName, $tableName, $couponID, $merchantID))
			{
                //if(is_uploaded_file($_FILES['file']['tmp_name']))
               // {
                        /*输出图片预览*/
                        echo "<center>您的文件已经上传完毕 上传图片预览: </center><br><center><img src='$uploadfile'></center>";
                        echo"<br><center><a href='javascript:history.go(-1)'>继续上传</a></center>";
                //}
               // else
               // {
               //         echo "上传失败！";
               // }
			}
			else
			{
				echo "pic name is same, try again please";
			}
        }
		}
		
		else if($picType == 3) //for coupon icon
		{
			$couponID = find_coupon_ID_by_name($_POST['cname']);
			$picName = $couponID."_icon.".$a;
			$tableName = "coupon_icon";
			$uploadfile=$uploaddir.$picName;
			file_exists($uploadfile);
			$merchantID = find_merchantID_by_pic_name($_POST['cname']);
			
        if (move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile))
        {
			if(uploadIconToDB($picName, $tableName, $couponID, $merchantID))
			{
                //if(is_uploaded_file($_FILES['file']['tmp_name']))
               // {
                        /*输出图片预览*/
                        echo "<center>您的文件已经上传完毕 上传图片预览: </center><br><center><img src='$uploadfile'></center>";
                        echo"<br><center><a href='javascript:history.go(-1)'>继续上传</a></center>";
                //}
               // else
               // {
               //         echo "上传失败！";
               // }
			}
			else
			{
				echo "pic name is same, try again please";
			}
        }
        }
	
}
?>