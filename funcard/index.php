<?php header("Location:http://www.aierbang.org/funcard/coupon.php");exit;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<!-- BEGIN INSERT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<!-- InstanceBeginEditable name="doctitle" -->
<title>优惠集合_爱儿帮育儿优惠_爱儿帮育儿体验、点评、优惠</title>
<meta name="description" content="育儿优惠——提供最好最便捷优惠，更多选择，更多优惠。爱儿帮，让选择更简单。囊括育儿优惠，成长体验，帮友点评，趣玩活动等，最新推出儿童护照，体验、点评、优惠，三位一体。" />
<meta name="keywords" content="优惠集合，育儿优惠，爱儿帮育儿点评网" />
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
       <td><!-- InstanceBeginEditable name="EditRegion3" --><table width="900
  " height="252">
    <tr  valign="top">
      <td width="600"><img src="sitePIC/card_1_front_4.png" width="600"/>
      </td>
      <td width="200">
      <?php
	require_once('tools/function.php');
	
	//echo date('H:i, jS, F, Y');
	
	if(isset($_COOKIE["couponUserName"]))
	{
		echo '<br/>';
		echo '<table width="200"> 您好， ' .$_COOKIE["couponUserName"];
		echo ' <br/><a href=coupon.php>去看看优惠券</a>';
		echo ' </table>';
	}
	else
	{
		echo '<table width="270"><tr height="30" ></tr>';
		echo '<tr > <td><a href=register_aeb.php>爱儿帮会员首次登录入口</a></tr>';
		//echo '<tr><td>已有帐号，请登录</td></tr>';
		//using linux, action should be action="tools/login.php"
		echo '<tr height="30" width="270"> <td><form action="tools/login.php" method="post"></tr><table>
	<tr><td colspan="2" width="300"></td></tr>';
	
	if(isset($_GET['error']))
	{
		echo '<tr><td colspan="2" width="300" style="color:#F00">登录失败，用户名或密码错误</td></tr>';
	}
	
    echo'<tr><td width="50" height="10">
    <label for="AAA2">用户名</label></td>
<td heigt="130">    <input type="text" name="name" id="AAA2" />
  </td></tr>
   <td width="50" height="10"><label for="B">密码</label></td>
    
    <td heigt="130"><input type="password" name="password" id="B" />
  </td>
  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="76">&nbsp;</td>
      <td> <p>
    <input type="submit" name="abcd" id="abcd" value="登录"/>
    <input type="button" name="register" id="register" value="注册" 
    onclick="window.location = \'register.php\'" />
    </table>
   </form>';
	}
	if(array_key_exists('name', $_POST))
	{
		$A = $_POST[ 'name'];
		$B = $_POST[ 'password'];
		
		//$x  = sum($A, $B);
		//$x = Encode($B);
		//echo $x.'</p>';
		//echo "try DB now </p>";
		//selectall();
		if($A == '' || $B == '')
		{
			echo '请输入用户名或密码 ';
		}
		else if(login($A, $B))
		{
			setcookie("couponUserName", $A, time()+2600000);
			
			$id = findUserIdbyName($A);
			
			setcookie("couponUserID", $id, time()+2600000);
			
			//change page
			$url = "./coupon.php"; 
			echo "<script language='javascript' type='text/javascript'>"; 
			echo "window.location.href='$url'"; 
			echo "</script>"; 
		}
		else
		{
			echo ' 密码不正确，请重新输入 ';
		}
	}
	else
	{
		echo '';
	}	
?>
     <!--<form action="index.php" method="post">
     <table><tr><td>
    <label for="AAA2">用户名</label></td>
<td>    <input type="text" name="name" id="AAA2" />
  </td></tr>
   <td><label for="B">密码</label></td>
    
    <td><input type="password" name="password" id="B" />
  </td>
  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="76">&nbsp;</td>
      <td> <p>
    <input type="submit" name="abcd" id="abcd" value="登录"/>
    <input type="button" name="register" id="register" value="注册" 
    onclick="window.location = 'register.php'" />
    </table>
   </form>-->
  </p>
  <p>
 <marquee direction=up loop="99" scrollamount=3 style="color:#F90"><strong><span style="color:#090">爱儿帮帮友妈妈群成立啦！不想错过爱儿帮的好活动，好折扣？</span></br>孕妈及0-3岁宝宝请加入群号"227394063"；</br>3-6岁宝宝请加入"228969023"。</br><span style="color:#090">让我们陪伴宝宝成长，分享吃喝玩乐的高兴事儿！</span>
</strong></marquee> 
  </p>
  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td colspan="3" align="center">
    <table class="logo_table">
    <tr height="20">
    </tr>
    <tr align="center">
    <td class="all_logo"><img src="sitePIC/logos/doudou_logo.png" alt onload="if(this.width>175) this.width=175; if(this.height>65) this.height=65"/>
    </td>
    <td class="all_logo"><img src="sitePIC/logos/thumbnail_2.jpg" alt onload="if(this.height>65) this.height=65; if(this.width>175) this.width=175 "/>
    </td>
    <td class="all_logo"><img src="sitePIC/logos/peek_logo.png" alt onload="if(this.width>175) this.width=175; if(this.height>65) this.height=65"/>
    </td>
    <td class="all_logo"><img src="sitePIC/logos/TTF_logo.png" alt onload="if(this.width>175) this.width=175; if(this.height>65) this.height=65"/>
    </td>
    </tr>
    <tr align="center">
   <td class="all_logo"><img src="sitePIC/logos/kidshow.png" onload="if(this.height>65) this.height=65; if(this.width>175) this.width=175"/>
    </td>
    <td class="all_logo"><img src="sitePIC/logos/youbei.jpg" onload="if(this.height>65) this.height=65; if(this.width>175) this.width=175"/>
    </td>
     <td class="all_logo"><img src="sitePIC/logos/isee_logo.png" onload="if(this.height>65) this.height=65; if(this.width>175) this.width=175 "/>
    </td>
     <td class="all_logo"><img src="sitePIC/logos/mygym.png" onload="if(this.width>175) this.width=175; if(this.height>65) this.height=65"/>
    </td>
    </tr>
    </table>
    </td>
    </tr>
  </table><!-- InstanceEndEditable --></td>
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
