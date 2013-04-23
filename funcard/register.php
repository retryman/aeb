<?php
	require_once('tools/function.php');

		$name = '';
		$email = '';
		$phone = '';
	
	if($_COOKIE["couponUserID"] && $_GET["type"] != 'phone')
	{		
		$url = "./mypage.php"; 
		echo "<script language='javascript' type='text/javascript'>"; 
		echo "window.location.href='$url'"; 
		echo "</script>"; 
	}
	
	session_start();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册</title>
<link rel="stylesheet" type="text/css" href="CSS/main.css"/>
<link rel="stylesheet" type="text/css" href="CSS/reg.css"/>
<link rel="stylesheet" type="text/css" href="CSS/jqtransform.css"/>
<script src="js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="js/jquery.jqtransform.js" type="text/javascript"></script>

<script language="javascript">
$(document).ready(function(){
	$('form').jqTransform({imgPath:'js/img/'});	
	$(".reg_form").step();
	$(".but_reg").hover(function(){
		$(this).addClass("but_regHover");							
	},function(){
		$(this).removeClass("but_regHover");
	})
	
	$(".but_reset").hover(function(){
		$(this).addClass("but_resetHover");							
	},function(){
		$(this).removeClass("but_resetHover");
	})
})

$.fn.step=function(){
	var obj=$(this);
	var i=0;
	var steps=obj.find(">div");
	var down=$(".step_control .down");
	var up=$(".step_control .up");
	var step_bur=$("#step_bur");
	var step_burs=step_bur.find("a");
	obj.find(">div").hide();
	obj.find(">div:eq("+i+")").show();
	
	/*down.click(function(){
		obj.find(">div:eq("+i+")").hide();
		obj.find(">div:eq("+(i+1)+")").show();
		i++;
		step_burs.find("span").removeClass("current");
		step_bur.find("a:eq("+i+") span").addClass("current");
	})
	
	up.click(function(){
		obj.find(">div:eq("+i+")").hide();
		obj.find(">div:eq("+(i-1)+")").show();
		i--;
		step_burs.find("span").removeClass("current");
		step_bur.find("a:eq("+i+") span").addClass("current");
	})
	*/
}

//用于用户名注册，，用户名只 能用 中文、英文、数字、下划线、4-20个字符。

//hansir和解决方案弄成正则：

// /^[\u4E00-\u9FA5\uf900-\ufa2d\w]{4,20}$/ 

function alert1()
{
	
var s = document.getElementById("id").value;
	//alert(s);
}

function checkInput()
{
	checkName();
	checkPW();
	checkREPW();
	checkEmail();
	checkPhone();
}

function checkName()
{
	var s = document.getElementById("name").value;
	var patrn=/^[\u4E00-\u9FA5\uf900-\ufa2d\w]{4,20}$/;
  if (!patrn.exec(s)&&s!="")
  {
	 document.getElementById("name").value='';
    alert("请输入合法用户名， 4-20个中英文字符 ");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkPW()
{
	var p = document.getElementById("password").value;
	var patrn_1=/^\S{6,18}$/;
	if (!patrn_1.exec(p)&&p!="")
  {
	  document.getElementById("password").value='';
    alert("请输入合法密码， 6-18位数字，英文或符号");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkREPW()
{
	var p = document.getElementById("repassword").value;
	var patrn_1=/^\S{6,18}$/;
	if (!patrn_1.exec(p)&&p!="")
  {
	  document.getElementById("repassword").value='';
    alert("请输入合法密码， 6-18位数字，英文或符号");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkEmail()
{
	var p = document.getElementById("email").value;
	var patrn_1= /^[a-zA-Z0-9_]+[@][a-zA-Z0-9]/; // full version: /^[a-zA-Z0-9_]+[@][a-zA-Z0-9]+([\\.com]|[\\.cn])/
	if (!patrn_1.exec(p)&&p!="")
  {
	  document.getElementById("email").value='';
    alert("请输入正确的邮箱，例：YourName@aierbang.org");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkPhone()
{
	var p = document.getElementById("phone").value;
	var patrn_1= /^[0-9]{11}$/;
	if (!patrn_1.exec(p)&&p!="")
  {
	  document.getElementById("phone").value='';
    alert("请输入正确的手机号，11位数字");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function clear_all()
{
	 document.getElementById("name").value='';
	 document.getElementById("password").value='';
	 document.getElementById("email").value='';
	 document.getElementById("phone").value='';
	 document.getElementById("repassword").value='';
}
</script>


</head>

<body>
<div class="row">
	<div id="header">
    	<div class="logo"><a href="#"><img src="images/logo.jpg" /></a></div>
    	<div class="ad"><img src="images/ad.jpg" /></div>
    	<div class="search">
        <iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=&c=CHXX0008&l=zh-CHS&p=CMA&a=0&u=C&s=3&m=0&x=1&d=0&fc=&bgc=&bc=&ti=1&in=1&li=2&ct=iframe" frameborder="0" scrolling="no" width="500" height="110" allowTransparency="true"></iframe>
        </div>
    </div>
</div>
<?php if($_GET['type'] == 'phone'):?>
<form action="tools/reg.php?other=phone" method="post">
<div class="row">
	<div class="box">
    	<div class="box_top"></div>
    	<div class="box_mid">
        	<div id="reg">
        		<h2><span class="welcome">欢迎加入爱儿帮，请补充资料吧~</span><span class="login"></span></h2>
                <div id="step_bur">
                	<a href="javascript:void(0)" id="step_bur_1"><span class="current"></span></a>
                	<a href="javascript:void(0)" id="step_bur_2"><span></span></a>
                	<a href="javascript:void(0)" id="step_bur_3"><span></span></a>
                </div>
                
                <div class="reg_form">
                	
                    <!--第一步-->
                    <div id="step1">
                        <div class="msg">
                        </div>
                        <div class="form_item">
                            <span class="tit">手机号码：</span><label class="text" ></span><input type="text"  size="30" name="phone" id="phone" value="" onblur="javascript:checkInput();" /></label>
                        </div>
                      <div class="form_item" style="height:20px;"></div>
                        
                        <div class="form_item">
                            <span class="tit">&nbsp;</span><label><input type="submit" class="but_reg" value="" /> <input type="reset" class="but_reset" value="" /></label>
                        </div>
                        
                        <div class="step_control">
                        	<a class="down"></a>
                        </div>
                    </div>
                    <!--第一步-->
                    
                </div>
                
            </div>
        </div>
    	<div class="box_bottom"></div>
    </div>
</div>
</form>
<?php else:?>
<form action="tools/reg.php?other=na" method="post">
<div class="row">
	<div class="box">
    	<div class="box_top"></div>
    	<div class="box_mid">
        	<div id="reg">
        		<h2><span class="welcome">欢迎加入爱儿帮，请填写注册资料吧~</span><span class="login"><a href="../kidspassport/"></a></span></h2>
                <div id="step_bur">
                	<a href="javascript:void(0)" id="step_bur_1"><span class="current"></span></a>
                	<a href="javascript:void(0)" id="step_bur_2"><span></span></a>
                	<a href="javascript:void(0)" id="step_bur_3"><span></span></a>
                </div>
                
                <div class="reg_form">
                	
                    <!--第一步-->
                    <div id="step1">
                        <div class="msg">
                        <?php 
							if(isset($_GET['error']))
							{
								if($_GET['error'] == 1)
								{
									echo '
									信息不完整，请重新输
									';
								}
								else if($_GET['error'] == 2)
								{
									echo '
									用户名可能已被使用
											   
									';
								}
								else if($_GET['error'] == 3)
								{
									echo '邀请码错误
									';
								}
								else if($_GET['error'] == 4)
								{
									echo '密码不匹配
									';
								}
								
								if(isset($_SESSION['info']))//if the user already filled some info
								{
									$info = $_SESSION['info'];
									$name = $info['name'];
									$email = $info['email'];
									$phone = $info['phone'];
									unset($_SESSION['info']);
								}
							}
						?>
                        </div>
                        <div class="form_item">
                            <span class="tit">用户名<span style="color:red;float:none;">*</span>:</span><label class="text" ><input type="text" size="30" name="name" id="name" onblur="javascript:checkInput();"  value="<?php echo $name;?>" /> </label>
                        </div>
                        <div class="form_item">
                            <span class="tit">密码<span style="color:red;float:none;">*</span>：</span><label class="text" ></span><input type="password"   size="30" name="password" id="password" onblur="javascript:checkInput();" /></label>
                        </div>
                        <div class="form_item">
                            <span class="tit">确认密码<span style="color:red;float:none;">*</span>：</span><label class="text" ></span><input type="password"   size="30" name="repassword" id="repassword" onblur="javascript:checkInput();" /></label>
                        </div>
                        <div class="form_item">
                            <span class="tit">电子邮箱<span style="color:red;float:none;">*</span>：</span><label class="text" ></span><input type="text"  size="30" name="email" id="email" value="<?php echo $email;?>" onblur="javascript:checkInput();" /></label>
                        </div>
                        <div class="form_item">
                            <span class="tit">手机号码<span style="color:red;float:none;">*</span>：</span><label class="text" ></span><input type="text"  size="30" name="phone" id="phone" value="<?php echo $phone;?>" onblur="javascript:checkInput();" /></label>
                        </div>
                        <div class="form_item">
                            <span class="tit">激活码：</span><label class="text" ></span><input type="text"  size="10" name="invent_code" id="invent_code" /></label><span>(可参加积分换礼)</span>
                        </div>
                      <div class="form_item" style="height:20px;"></div>
                        
                        <div class="form_item">
                            <span class="tit">&nbsp;</span><label><input type="submit" class="but_reg" value="" /> <input type="reset" class="but_reset" value="" /></label>
                        </div>
                        
                        <div class="step_control">
                        	<a class="down"></a>
                        </div>
                    </div>
                    <!--第一步-->
                    
                </div>
                
            </div>
        </div>
    	<div class="box_bottom"></div>
    </div>
</div>
</form>
<?php endif;?>


<div class="row">
	<div id="footer">
    	<p><a href="#">关于我们</a> |  <a href="#">网站地图</a> | <a href="#">联系我们</a> | <a href="#">诚聘英才</a></p>
        <p class="copyright">Copyright by AIERBANG & All rights reserved 京ICP备*******号</p>
    </div>
</div>

</body>
</html>
