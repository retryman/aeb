<?php ob_start(); session_start();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<!-- BEGIN INSERT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<!-- InstanceBeginEditable name="doctitle" --><title>活动报名</title>
<!-- InstanceEndEditable -->
<link href="CSS/test1.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/verification.js"></script>
<!-- InstanceEndEditable -->
</head><body onload="MM_preloadImages('sitePIC/banner_03.jpg','sitePIC/banner_04.jpg','sitePIC/banner_05.jpg','sitePIC/banner_06.jpg','sitePIC/banner_07.jpg')">
<div>
<table width="900" border="0" align="center" cellspacing="0" bgcolor="#FCF8EF">
     <tr>
       <td height="70"><img src="sitePIC/banner_01.jpg" alt="" width="400" height="72" /></td><td><iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=&c=CHXX0008&l=zh-CHS&p=CMA&a=0&u=C&s=3&m=0&x=1&d=0&fc=&bgc=&bc=&ti=1&in=1&li=2&ct=iframe" frameborder="0" scrolling="no" width="500" height="110" allowTransparency="true"></iframe></td>
     </tr>
     <tr>
     <td colspan="2"><img src="sitePIC/banner_02.jpg" alt="" width="403" height="33" /><a href="http://www.aierbang.org/" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image8','','sitePIC/banner_03.jpg',1)"><img src="sitePIC/banner_03.jpg" width="75" height="33" border="0" id="Image8" /></a><a href="http://www.aierbang.org/dianping" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image9','','sitePIC/banner_04.jpg',1)"><img src="sitePIC/banner_04.jpg" width="94" height="33" border="0" id="Image9" /></a><a href="http://www.aierbang.org/experience" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','sitePIC/banner_05.jpg',1)"><img src="sitePIC/banner_05.jpg" width="94" height="33" border="0" id="Image10" /></a><a href="http://www.aierbang.org/camp" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image11','','sitePIC/banner_06.jpg',1)"><img src="sitePIC/banner_06.jpg" width="107" height="33" border="0" id="Image11" /></a><a href="http://www.aierbang.org/questions" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image12','','sitePIC/banner_07.jpg',1)"><img src="sitePIC/banner_07.jpg" width="94" height="33" border="0" id="Image12" /></a><img src="sitePIC/banner_08.jpg" alt="" width="30" height="33" /></td>
     </tr>
     <tr>
     <td colspan="2" width="900"><img src="sitePIC/banner.jpg" alt="" width="900"/>
     </td>
     </tr>
     <tr>
     <td colspan="2" align="right">
     <?php
     require_once('tools/function.php');
	
	if(isset($_COOKIE["couponUserName"]))
	{
    	$cid = find_card_id_by_uid($_COOKIE["couponUserID"]);
		$date = user_void_date($_COOKIE["couponUserID"]);
        echo '您好，'.$_COOKIE["couponUserName"].'&nbsp;&nbsp;您的卡号是'.$cid.',&nbsp;您的优惠卡有效期截止到2012年12月31日';
        echo ', <a href="mypage.php">我的页面</a>&nbsp;&nbsp;&nbsp;<a href=tools/logout.php>登出</a>';
	}
     ?>
     </td>
     </tr>
     </table>
     <table  width="900" border="0" align="center" cellspacing="0" bgcolor="#FCF8EF">
       <td><!-- InstanceBeginEditable name="EditRegion3" -->
       <div class="outer_event">
       <?php
	   require_once('tools/event_class.php');
	   $event_id = $_GET['eid'];
       $event = new events($event_id);
	   
	   echo '<div class="event_title">'.$event->get_title().'</div>';
	   
	   echo '<div class="inner_event">'.$event->get_content().'</div>';
	   
	   if(isset($_SESSION['event_result']))
	   {
		   echo '<div class="verifi_alert">';
		   switch ($_SESSION['event_result'])
		   {
		   		case 0:
		   		{
					echo '注册成功</div>';
					unset($_SESSION['event_result']);
					break;
		   		}
		   		case 1:
		   		{
					echo '密码不匹配</div>';
					unset($_SESSION['event_result']);
					break;
		   		}
		   		case 2:
		   		{
					echo '用户名相同</div>';
					unset($_SESSION['event_result']);
					break;
		   		}				
		   }
	   }
	   
	   if(isset($_COOKIE['couponUserID']))//for logged in user
	   {
		   require_once('tools/user.php');
		   $user = new users();
		   $user->user_id = $_COOKIE['couponUserID'];
		   if($user->check_info_complete() == 1)
		   {
		   echo '<div><ul class="event_ul"><form action="tools/event_register.php" method="post">
		   <input type="hidden" value="'.$_COOKIE['couponUserName'].'" name="user_name" />
		   <input type="hidden" name="event_id" id="event_id" value="'.$event_id.'">
		   ';
		   echo '<input type="hidden" value="old" name="state">';
		   echo '<li><div>Stage</div><select name="stage" id="stage">';
			$event->get_stage();
			echo '</select></li>';
			echo '<input type="submit" value="报名"/>';
			echo '</form></ul></div>';
		   }
		   else
		   {
			   echo '<div><a href="user_info.php">请完善您的个人信息再进行报名</a></div>';
		   }
	   }
	   else
	   {
	   //echo user info table for new user
	   echo '<ul class="event_ul"><form action="tools/event_register.php" method="post">
       <li><div>用户名</div><input type="text" name="user_name" id="user_name" onblur="checkName(this.id)"/></li>
	   <li><div>电子邮箱</div><input type="text" name="user_email" id="user_email" onblur="checkEmail()"/></li>
	   <li><div>密码</div><input type="password" name="password" id="password" onblur="checkPW(this.id)"/></li>
	   <li><div>确认密码</div><input type="password" name="repass" id="repass" onblur="checkPW(this.id)"/></li>
	   <li><div>VIP code</div><input type="text" name="vip" id="vip"/></li>
	   <li><div>宝宝姓名</div><input type="text" name="baby_name" id="baby_name" onblur="checkName(this.id)"/></li>
	   <li><div>宝宝性别</div><input type="radio" name="baby_sex" value="M" checked="checked">男</input><input type="radio" name="baby_sex" value="F">女</input></li>
	   <li><div>宝宝生日</div><input type="text" name="baby_birth" id="baby_birth" onclick="new Calendar(1980, 2015).show(this);" size="10" maxlength="10" readonly="readonly" /></li>
	   <li><div>父母姓名</div><input type="text" name="parent_name" id="parent_name" onblur="checkName(this.id)"/></li>
	   <li><div>居住地址</div><input type="text" name="adress" id="adress" onblur="checkAdress(this.id)"/></li>
	   <li><div>手机号</div><input type="text" name="phone" id="phone" onblur="checkPhone(this.id)"/></li>
	   <input type="hidden" value="new" name="state">
	   <input type="hidden" name="event_id" id="event_id" value="'.$event_id.'">
	   ';//event id, for register
	   
	   //echo the stages
	   echo '<li><div>场次</div><select name="stage" id="stage">';
		$event->get_stage();
		echo '</select></li>';
		echo '<input type="submit" value="报名"/>';
		echo '</form></ul>';
	   }
       ?>
       </div>
	   <!-- InstanceEndEditable --></td>
     </table>
   <table  width="900" border="0" align="center" cellspacing="0" bgcolor="#FCF8EF">
     <td height="126" colspan="6" align="center" background="sitePIC/footer.jpg"><p><script type="text/javascript" charset="utf-8">
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
