<?php ob_start(); session_start();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>找回密码</title>
<link rel="stylesheet" type="text/css" href="CSS/main.css"/>
<link rel="stylesheet" type="text/css" href="CSS/reg.css"/>
<link rel="stylesheet" type="text/css" href="CSS/jqtransform.css"/>
<script src="js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="js/jquery.jqtransform.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/verification.js"></script>

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
	})*/
	
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
<form action="tools/retrieve_password.php" method="post">
<div class="row">
	<div class="box">
    	<div class="box_top"></div>
    	<div class="box_mid">
        	<div id="reg">
        		<h2><span class="welcome">修改您的密码</span><span class="login"><a href="#"></a></span></h2>
               <!-- <div id="step_bur">
                	<a href="javascript:void(0)" id="step_bur_1"><span></span></a>
                	<a href="javascript:void(0)" id="step_bur_2"><span class="current"></span></a>
                	<a href="javascript:void(0)" id="step_bur_3"><span></span></a>
                </div>-->
                
                <div class="reg_form">
                <?php 
				$result = 0;
				$error = '';
				$name = '';
	   			if(isset($_SESSION['retrieve_pass']))
	   			{
		   			if($_SESSION['retrieve_pass'] == 2)
					{
						$result = $_SESSION['retrieve_pass'];
						$error = '手机号不匹配';
						unset($_SESSION['retrieve_pass']);
		   			}
					else if($_SESSION['retrieve_pass'] == 3)//new pass not matched
		   			{
						$result = $_SESSION['retrieve_pass'];
						$error = '新密码不匹配';
						unset($_SESSION['retrieve_pass']);
		   			}
					else if($_SESSION['retrieve_pass'] == 1)//phone is correct, input new password
		   			{
						$result = $_SESSION['retrieve_pass'];
						$name = $_SESSION['retrieve_pass'];
						 unset($_SESSION['username']);
			 			 unset($_SESSION['retrieve_pass']);
		   			}
	   			}
				else
	   			{
					$result = 0;
					unset($_SESSION['retrieve_pass']);
				}
				
				if($result == 0 || $result == 2 || $result == 3)//new entry or has error
				{
					echo '
                    <div id="step2" style="padding-top:20px;">
                    <div class="msg">'.$error.'</div>
                    	<div class="form_item">
                        <span class="tit" style="width:170px; padding-left:30px;">用户名</span><label class="text" ></span><input type="text" size="30" name="username" id="username" /> </label>
                        </div>
                    	<div class="form_item">
                        <span class="tit" style="width:170px; padding-left:30px;">手机号</span><label class="text" ></span><input type="text" size="30" name="phone" id="phone" /> </label>
                        </div>
						
			  		  <input type="hidden" name="state" value="check_phone" />
                        
                      <div class="form_item" style="height:20px;"></div>
                        
                        <div class="form_item">
                        	<span class="tit">&nbsp;</span><label><input type="submit" value="" class="but_confirm" /></label>
                        </div>
                        
                        <div class="step_control">
                        	<a class="down"></a>
                        </div>
                    </div>
					';
				}
				else if($result == 1)//correct phone and user name, input new password
				{
					echo '
                    <div id="step2" style="padding-top:20px;">
                    <div class="msg">请输入新密码</div>
                    	<div class="form_item">
                            <span class="tit" style="width:170px; padding-left:30px;">新密码</span><label class="text" ></span><input type="password" size="30" name="newpass" id="newpass"  onblur="checkPW(this.id)" /> </label>
                        </div>
                    	<div class="form_item">
                          <span class="tit" style="width:170px; padding-left:30px;">新密码确认</span><label class="text" ></span><input type="password" size="30"" name="renewpass" id="renewpass"  onblur="checkPW(this.id)" /> </label>
                        </div>
                        
			  		  <input type="hidden" name="username" value="'.$name.'" />
					  <input type="hidden" name="state" value="change_pass" />
					  
                      <div class="form_item" style="height:20px;"></div>
                        
                        <div class="form_item">
                        	<span class="tit">&nbsp;</span><label><input type="submit" value="" class="but_confirm" /></label>
                        </div>
                        
                        <div class="step_control">
                        	<a class="down"></a>
                        </div>
                    </div>
					';
				}
				?>                    
                </div>
                
            </div>
        </div>
    	<div class="box_bottom"></div>
    </div>
</div>

<div class="row">
	<div id="footer">
    	<p><a href="#">关于我们</a> |  <a href="#">网站地图</a> | <a href="#">联系我们</a> | <a href="#">诚聘英才</a></p>
        <p class="copyright">Copyright by AIERBANG & All rights reserved 京ICP备*******号</p>
    </div>
</div>
</form>
</body>
</html>
