<?php //ob_start(); 
session_start();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<!-- BEGIN INSERT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<!-- InstanceBeginEditable name="doctitle" -->
<title>show_coupon</title>
<link href="../CSS/coupon.css" rel="stylesheet" type="text/css" />
<!-- InstanceEndEditable -->
<link href="../CSS/test1.css" rel="stylesheet" type="text/css" />
<link href="CSS/coupon.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #E1FFFF;
	margin-top: 0px;
	margin-bottom: 0px;
}
</style>
<script type="text/javascript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<!-- END INSERT -->
<!-- InstanceBeginEditable name="head" -->
<script>
//用于用户名注册，，用户名只 能用 中文、英文、数字、下划线、4-20个字符。

//hansir和解决方案弄成正则：

// /^[\u4E00-\u9FA5\uf900-\ufa2d\w]{4,20}$/ 

function alert1()
{
	
var s = document.getElementById("id").value;
	alert(s);
}

function checkPrice()
{
	var s = document.getElementById("price").value;
	var patrn=/^[0-9]{1,9}$/;
  if (!patrn.exec(s)&&s!="")
  {
	 document.getElementById("price").value='';
    alert("请输入正确的价格");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}


function checkScore()
{
	var s = document.getElementById("score").value;
	var patrn=/^[0-9]{1,9}$/;
  if (!patrn.exec(s)&&s!="")
  {
	 document.getElementById("score").value='';
    alert("请输入正确的积分");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}
</script>

<!-- InstanceEndEditable -->
</head><body onload="MM_preloadImages('../sitePIC/banner_03.jpg','../sitePIC/banner_04.jpg','../sitePIC/banner_05.jpg','../sitePIC/banner_06.jpg','../sitePIC/banner_07.jpg')">
<div>
<table width="900" border="0" align="center" cellspacing="0" bgcolor="#FCF8EF">
     <tr>
       <td height="70"><img src="../sitePIC/banner_01.jpg" alt="" width="400" height="72" /></td><td><iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=&c=CHXX0008&l=zh-CHS&p=CMA&a=0&u=C&s=3&m=0&x=1&d=0&fc=&bgc=&bc=&ti=1&in=1&li=2&ct=iframe" frameborder="0" scrolling="no" width="500" height="110" allowTransparency="true"></iframe></td>
     </tr>
     <tr>
     <td colspan="2"><img src="../sitePIC/banner_02.jpg" alt="" width="403" height="33" /><a href="http://www.aierbang.org/" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image8','','../sitePIC/banner_03.jpg',1)"><img src="../sitePIC/banner_03.jpg" width="75" height="33" border="0" id="Image8" /></a><a href="http://www.aierbang.org/dianping" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image9','','../sitePIC/banner_04.jpg',1)"><img src="../sitePIC/banner_04.jpg" width="94" height="33" border="0" id="Image9" /></a><a href="http://www.aierbang.org/experience" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','../sitePIC/banner_05.jpg',1)"><img src="../sitePIC/banner_05.jpg" width="94" height="33" border="0" id="Image10" /></a><a href="http://www.aierbang.org/camp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image11','','../sitePIC/banner_06.jpg',1)"><img src="../sitePIC/banner_06.jpg" width="107" height="33" border="0" id="Image11" /></a><a href="http://www.aierbang.org/questions" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image12','','../sitePIC/banner_07.jpg',1)"><img src="../sitePIC/banner_07.jpg" width="94" height="33" border="0" id="Image12" /></a><img src="../sitePIC/banner_08.jpg" alt="" width="30" height="33" /></td>
     </tr>
     <tr>
     <td colspan="2" width="900"><img src="../sitePIC/banner.jpg" alt="" width="900"/>
     </td>
     </tr>
     <tr>
     <td colspan="2" align="right">
     <?php
     require_once(dirname(__FILE__).'/../tools/function.php');
	
	if(isset($_COOKIE["couponUserName"]))
	{
    	$cid = find_card_id_by_uid($_COOKIE["couponUserID"]);
		$date = user_void_date($_COOKIE["couponUserID"]);
        echo '您好，'.$_COOKIE["couponUserName"].'&nbsp;&nbsp;欢迎来到爱儿帮护照国';
        echo ', <a href="mypage.php">我的护照</a>&nbsp;&nbsp;&nbsp;<a href=tools/logout.php>登出</a>';
	}
     ?>
     </td>
     </tr>
     </table>
     <table  width="900" border="0" align="center" cellspacing="0" bgcolor="#FCF8EF">
       <td><!-- InstanceBeginEditable name="EditRegion3" -->
	   <?php
	   require_once('tools/verifi.php');
       if(isset($_GET['cid']))
	   {
		   $merchant = new merchant();
		   $coupon = new coupon();
		   $merchant->cid = $_GET['cid'];
		   $merchant->mid = $_COOKIE['MerchantID'];
		   $result = $merchant->find_coupon_by_cid_mid();
		   
		    $coupon->cid = $result["cid"];
			$coupon->mid = $result["mid"];
			$coupon->counts = $result["count"];
			$coupon->title = $result["title"];
			$coupon->used = $result["used"];
			$coupon->price = $result["price"];
			$coupon->score = $result["score"];
				
		    echo '<div><a href="./">返回上页</a>';
		   if($result["result"] == 1 && !isset($_SESSION['result']))//has no verification, input card id and phone num to verifi the user
		   {
			   echo '<div><ul class="verifi_coupon_by_id">';
			   echo '<li>'.$coupon->title.'</li>';
			   
				//echo '<li>优惠券每人限制使用'.$this->used.'次</li>';
				/*if($coupon->counts > 0)
				{
					echo '
					<li>优惠券剩余'.$coupon->counts.'次</li>
					</ul></div>';
				}
				else if($coupon->counts == 0)
				{
					echo '
						<li>优惠券已没有剩余次数</li></ul></div>';
				}
				else if($coupon->counts < 0)
				{
					echo '
					<li>该优惠券不限制次数</li>';
				}*/
				
			   echo '</ul></div>';
			   
			   echo '</div>
	   				<div class="verifi_alert">
					请输入护照号号和会员手机号码验证优惠有效
		  			<form action="tools/check_funacrd.php" method="post">
       				<label for="card_ID">护照号</label><input type="text" name="card_ID" />
       				<label for="phone">手机号码</label><input type="text" name="phone" />
       				<input type="hidden" name="couponid" value="'.$coupon->cid.'" />
	   				<input type="hidden" name="used" value="'.$coupon->used.'" />
       				<input type="submit" value="查询" />
       				</form> </div>';
		   }
		   else if(!isset($_SESSION['result']))
		   {
			   echo '<div class="verifi_alert">没有找到该优惠券<div>';
		   }
	   }
	   
       if(isset($_SESSION['result']))
       {
       		if($_SESSION['result'] == 1)//find the user, confirm this consumption
            {
				$card_id = $_SESSION['card_id'];
       			echo "<div class=\"verifi_alert_2\">该用户为爱儿帮护照用户<br/>确认消费？</div>";
				
				echo "<div class=\"verifi_alert\">
				
				<form action=\"tools/confirm.php\" method=\"post\">
	    	   <label for=\"card_id\">护照号</label><input type=\"text\" name=\"card_id\" value=\"".$card_id."\" readonly=\"readonly\"/><br/>";
			   
			   //check coupon type and set the price and score
			  $coupon->switch_coupon_type();
			   
			   echo "<input type=\"hidden\" name=\"couponid\" value=\"".$coupon->cid."\"/><br/>
			   <input type=\"hidden\" name=\"coupon_count\" value=\"".$coupon->counts."\" /><br/>
		       <input type=\"submit\" value=\"确认\" />
		       <br/><button onclick=\"window.location.href='show_coupon.php?cid=".$coupon->cid."'\">取消</button>
		       </form></div>";
				unset($_SESSION['card_id']);
				unset($_SESSION['result']);
            }
            else if($_SESSION['result'] == 0)//user not correct
            {
            	echo "<div class=\"verifi_alert\">FUN卡卡号或手机号码错误，请重新输入。<br/><button onclick=\"window.location.href='show_coupon.php?cid=".$coupon->cid."'\">返回</button></div>";
				unset($_SESSION['result']);
            }
       }
	   if(isset($_SESSION['confirm']))//complete
	   {
		   if($_SESSION['confirm'] == 'yes')
		   {
       			echo "<div class=\"verifi_alert\">本次消费已记录</div>";
		   }
		   else if($_SESSION['confirm'] == 'no')
		   {
			   echo "<div class=\"verifi_alert\">本次消费记录失败，请重新输入</div>";
		   }
			unset($_SESSION['confirm']);
	   }
	   ?>
	   <!-- InstanceEndEditable --></td>
     </table>
   <table  width="900" border="0" align="center" cellspacing="0" bgcolor="#FCF8EF">
     <td height="126" colspan="6" align="center" background="../sitePIC/footer.jpg"><p><script type="text/javascript" charset="utf-8">
(function(){
  var _w = 106 , _h = 24;
  var param = {
    url:location.href,
    type:'5',
    count:'', /**是否显示分享数，1显示(可选)*/
    appkey:'', /**您申请的应用appkey,显示分享来源(可选)*/
    title:'爱儿帮网', /**分享的文字内容(可选，默认为所在页面的title)*/
    pic:'', /**分享图片的路径(可选)*/
    ralateUid:'1762156557', /**aierbang:1762156557, 赛特奥莱1774791253关联用户的UID，分享微博会@该用户(可选)*/
    rnd:new Date().valueOf()
  }
  var temp = [];
  for( var p in param ){
    temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
  }
  document.write('<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>')
})()
</script></p>
      <p><a href="http://www.aierbang.org/about">关于我们</a>&nbsp;|&nbsp;<a href="http://aierbang.org/question/3926">爱儿帮FAQ</a>&nbsp;|&nbsp;<a href="http://aierbang.org/contact">联系我们</a></p>
      <p>Copyright by AIERBANG &amp; All rights reserved.</p></td>
     <!--<td><form id="form1" method="post" action="guestLogin.php">
       <p>
         <input type="submit" name="guest" id="guest" value="免费试玩" />
       </p>
     </form></td>-->    </tr>
 </table>
</div>
</body>
<!-- InstanceEnd --></html>
