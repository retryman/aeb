<?php 
ob_start(); session_start();

require_once('tools/user.php');
if(!isset($_COOKIE['couponUserID']))
{
	$url = "../../kidspassport.php"; 
	echo "<script language='javascript' type='text/javascript'>"; 
	echo "window.location.href='$url'"; 
	echo "</script>";
}

$user = new users();
$user->user_id = $_COOKIE['couponUserID'];
$pass = $user->check_my_passport();

	$babyname = '';
	$babysex = 'M';
	$babybirth = '';
	$parentname = '';
	$adress = '';
	$y= '1990';
	$m = '1';
	$d = '1';
	
/*if($user->check_info() == 1)
{
	echo '您的信息已经完善';
}*/

$info = $user->select_all_my_info();

if($info)
{
	$babyname = $info['baby_name'];
	$babysex = $info['baby_sex'];
	$babybirth = date("Y-n-j",$info['baby_birth']);
	if($babybirth != '')
	{
		$babybirth = explode('-', $babybirth);
		$year = $babybirth[0];
		$month = $babybirth[1];
		$day = $babybirth[2];
	}
	$parentname = $info['parent_name'];
	$adress = $info['adress'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户信息</title>
<link rel="stylesheet" type="text/css" href="CSS/main.css"/>
<link rel="stylesheet" type="text/css" href="CSS/reg.css"/>
<link rel="stylesheet" type="text/css" href="CSS/jqtransform.css"/>
<script src="js/jquery-1.4.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/verification.js"></script>
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

<div class="row">
	<div class="box">
    	<div class="box_top"></div>
    	<div class="box_mid">
        	<div id="reg">
        		<h2><span class="welcome">欢迎加入爱儿帮，请填写注册资料吧~</span></h2>
                <div id="step_bur">
                	<a href="javascript:void(0)" id="step_bur_1"><span></span></a>
                	<a href="javascript:void(0)" id="step_bur_2"><span></span></a>
                	<a href="javascript:void(0)" id="step_bur_3"><span class="current"></span></a>
                </div>
                <div class="reg_form">
                    <!--第三步-->
                    <form  action="tools/moreinfo.php" method="post">
                    <div id="step2" style="padding-top:20px;">
                    	<h3 style="font-size:18px; color:#ff9204; font-family:'微软雅黑', '宋体'; height:40px; line-height:40px;">完善个人信息</h3>
                        
                        <div class="form_item">
                            <span class="tit">家长姓名：</span><label class="text" ><input type="text" style="width:350px;"  name="parent_name" id="parent_name" value="<?php echo $parentname;?>" onblur="checkName(this.id)" /></label>
                        </div>
                        
                        <div class="form_item">
                            <span class="tit">居住地址：</span><label class="text" ><input type="text" style="width:350px;"  name="adress" id="adress" value="<?php echo $adress;?>" onblur="checkAdress(this.id)" /></label>
                        </div>
                        
                    	<div class="form_item">
                            <span class="tit">宝宝姓名：</span><label class="text" ><input type="text" style="width:350px;"  name="baby_name" id="baby_name" value="<?php echo $babyname;?>" onblur="checkName(this.id)" /></label>
                        </div>
                    	<div class="form_item">
                            <span class="tit" >出生日期：</span>
                          <label>
                            	<select name="year" id="year">
                                <?php
                                for($i=0; $i<25; $i++)
								{
									if($y == $year)
										echo '<option value="'.$y.'" selected="selected">'.$y.'</option>';
									else
										echo '<option value="'.$y.'">'.$y.'</option>';
									$y++;
								}
								?>
                                </select>
                          </label>
                            <span style="padding-left:5px;padding-right:10px;">年</span> <label>
                            	<select name="month" id="month">
                                <?php
                                for($i=0; $i<12; $i++)
								{
									if($m == $month)
										echo '<option value="'.$m.'" selected="selected">'.$m.'</option>';
									else
										echo '<option value="'.$m.'">'.$m.'</option>';
									
									$m++;
								}
								?>
                                </select>
                            </label>
                            <span style="padding-left:5px;padding-right:10px;">月</span> <label>
                            	<select name="day" id="day">
                                	<?php
                                	for($i=0; $i<31; $i++)
									{
										if($d == $day)
											echo '<option value="'.$d.'" selected="selected">'.$d.'</option>';
										else
											echo '<option value="'.$d.'">'.$d.'</option>';
											
										$d++;
									}
									?>
                                </select>
                            </label>
                            <span>日</span>
                        </div>
                    	<div class="form_item">
                            <span class="tit" >性别：</span><label><input type="radio" name="baby_sex" value="M" <?php if($babysex == 'M')echo'checked="checked"';?>/> 男孩</label> <label><input type="radio" name="baby_sex" value="F" <?php if($babysex == 'F')echo'checked="checked"';?>/> 女孩</label>
                        </div>
                        
                      <div class="form_item" style="height:20px;"></div>
                        
                        <div class="form_item"><span class="tit">&nbsp;</span><label><input type="submit" class="but_confirm" value="" />
                        <?php 
						if(isset($_SESSION['new_reg']))
						{
							echo '<a href="mypage.php" class="but_jump"></a>';
							unset($_SESSION['new_reg']);
						}
						?>
                            </label>
                        </div>
                        
                        
                    </div>
                    </form>
                    <!--第三步-->
                    
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
</body>
</html>
