<?php ob_start(); session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<!-- BEGIN INSERT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>CLASSES</title>
<link href="CSS/training.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="scripts/ratingsys.js"></script> 
<script type="text/javascript">
//用于用户名注册，，用户名只 能用 中文、英文、数字、下划线、4-20个字符。

//hansir和解决方案弄成正则：

// /^[\u4E00-\u9FA5\uf900-\ufa2d\w]{4,20}$/ 
function alert1()
{
	
var s = document.getElementById("id").value;
	alert(s);
}

function checkInput()
{
	checkContent();
}

function checkContent()
{
	var s = document.getElementById("comment").value;
	var patrn=/^[\u4E00-\u9FA5\uf900-\ufa2d\w]{2,200}$/;
  if (!patrn.exec(s)&&s!="")
  {
	document.getElementById("comment").value='';
    alert("评论在2-200个中英文字符之间");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}
</script>
		<style type="text/css">
    #rateStatus{float:left; clear:both; width:100%; height:20px;}
    #rateMe{ clear:both; width:100%;  padding:0px; margin:0px;}
    #rateMe li{float:left;list-style:none;}
    #rateMe li a:hover,
    #rateMe .on{background:url(sitePIC/star_on.gif) no-repeat;width:12px;height:12px;}
    #rateMe a{float:left;background:url(sitePIC/star_off.gif) no-repeat;width:12px; height:12px;}
    #ratingSaved{display:none;}
    .saved{color:red; }
   </style> 
<!-- InstanceEndEditable -->
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
<link href="CSS/training.css" rel="stylesheet" type="text/css" />
</head><body onload="MM_preloadImages('sitePIC/banner_03.jpg','sitePIC/banner_04.jpg','sitePIC/banner_05.jpg','sitePIC/banner_06.jpg','sitePIC/banner_07.jpg')">
<div>


<div>
<ul class="banner">
<li><img src="sitePIC/banner_01.jpg" width="400" height="72" /></li>
<li><iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=&c=CHXX0008&l=zh-CHS&p=CMA&a=0&u=C&s=3&m=0&x=1&d=0&fc=&bgc=&bc=&ti=1&in=1&li=2&ct=iframe" frameborder="0" scrolling="no" width="500" height="110" allowTransparency="true"></iframe></li>
</ul>
</div>
 <div>
     <ul class="navigation">
     <li><a href="http://www.aierbang.org">首页</a></li>
     <li><a href="www.aierbang.org">帮友点评</a></li>
     <li><a href="www.aierbang.org">经验分享</a></li>
     <li><a href="www.aierbang.org">爱儿帮探营</a></li>
     <li><a href="www.aierbang.org">你问我答</a></li>
     </ul>
     </div>
     <div class="banner_2">
     <img src="sitePIC/banner.jpg"/>
     </div>
     <div class="loginfo">
     <?php
     require_once('tools/function.php');
     
	 if(isset($_GET['statue']) && isset($_COOKIE["trainingUserName"]))
    {
    	$username = $_COOKIE['couponUserName'];
		$uid = $_COOKIE['couponUserID'];
		setcookie("couponUserName", $username, time()-2600000);					
        setcookie("couponUserName", $uid, time()-2600000);
    }
	if(isset($_COOKIE["trainingUserName"]))
	{
    	$name = $_COOKIE["trainingUserName"];
        echo '亲爱的'.$name.'，欢迎加入父母课堂，好好学习哦~ <a href=myclasses.php>查看我的课程</a>';
        echo '&nbsp;&nbsp;&nbsp;<a href=tools/logout.php>登出</a>';
	}
   
     ?>
     </div>
     <table  width="900" border="0" cellspacing="0" bgcolor="#FCF8EF">
     <tr>
       <td align="center"><!-- InstanceBeginEditable name="EditRegion3" -->
       <table>
       <tr>
       <td class="inner_table">
       <?php
       require_once('tools/function.php');
	   
	   if(!isset($_GET['class_ID']))
	   {
		   echo '
       <div>
       <form action="classes.php" method="post">
       <div class="date_select">
       <select name="class_year" id="class_year">
       <option value="2012">2012</option>
       <option value="2013">2013</option>
       </select>
       </div>
       <div class="date_select"><label for="class_year">年</label></div>
       <div class="date_select">
       <select name="class_month" id="class_month">
       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       </select>
       </div>
       <div class="date_select"><label for="class_month">月</label></div>
       <div class="date_select"><button type="submit" value="OK">查找课程</button></div>
       </form>
       </div>';
	   }
	   if(!isset($_COOKIE['trainingUserName']))
	   {
		   header("location: ./user_login.php");
		   ob_end_flush();
	   }
	   else
	   {
			if(isset($_GET['class_ID']))
			{
				$id = $_GET['class_ID'];
				
				select_class_by_id($id);
			}
	   		else if(isset($_POST['class_year']))
		   {
			   $cname = find_company_by_name($_COOKIE['trainingUserName']);
			   $year = $_POST['class_year'];
			   $month = $_POST['class_month'];
			   echo "<table class=\"c_table\">";
			   echo "<tr><td class=\"class_table_title\">课程</td><td class=\"class_table_title\">公司</td><td class=\"class_table_title\">日期</td><td class=\"class_table_title\">时间</td><td class=\"class_table_title\">讲师</td><td class=\"class_table_title\">地址</td><td class=\"class_table_title\">报名</td></tr>";
			   echo "<tr class=\"table_tr\" height=\"1\"><td colspan=\"9\"></td></tr>";
			   select_class_by_date($year, $month, $cname);
			   echo "</table>";
		   }
		   else
		   {		   
			    $cname = find_company_by_name($_COOKIE['trainingUserName']);
				$year = date("Y");
				$month = date("n");
				if(date("j") > 20)
				{
					$month++;
				}
				
			    echo "<table class=\"c_table\">";
				echo "<tr><td class=\"class_table_title\">课程</td><td class=\"class_table_title\">公司</td><td class=\"class_table_title\">日期</td><td class=\"class_table_title\">时间</td><td class=\"class_table_title\">讲师</td><td class=\"class_table_title\">地址</td><td class=\"class_table_title\">报名</td></tr>";
			   echo "<tr class=\"table_tr\" height=\"1\"><td colspan=\"9\"></td></tr>";
	       		select_class();
				echo "</table>";
		   }
	   }
	   
	   
	   ob_end_flush();
	   ?>
       </td>
       </tr>
       </table>
	   <!-- InstanceEndEditable --></td></tr>
     </table>
   <table  width="900" border="0" align="center" cellspacing="0" bgcolor="#000000">
   <tr>
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
