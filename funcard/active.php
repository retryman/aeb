<?php ob_start(); session_start();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	})*/
	
}
function remove_disable()
{
	document.getElementById("adress").removeAttribute("disabled");
	document.getElementById("real_name").removeAttribute("disabled");
	
}

function add_disable()
{
	document.getElementById("adress").setAttribute("disabled", "disabled");
	document.getElementById("real_name").setAttribute("disabled", "disabled");
	document.getElementById("real_name").value = "";
	document.getElementById("adress").value = "";
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
        		<h2><span class="welcome">欢迎加入爱儿帮，请填写注册资料吧~</span><span class="login"><a href="#"></a></span></h2>
                <div id="step_bur">
                	<a href="javascript:void(0)" id="step_bur_1"><span></span></a>
                	<a href="javascript:void(0)" id="step_bur_2"><span class="current"></span></a>
                	<a href="javascript:void(0)" id="step_bur_3"><span></span></a>
                </div>
                <?php
	   				require_once('tools/function.php');
	   				$user = new users();
	   				
	    			if($_COOKIE['couponUserID'] && isset($_POST['active']))//active passport
       				{
       					
		     			$user->user_id = $_COOKIE['couponUserID'];
						if(isset($_POST['adress']) && isset($_POST['real_name']))
						{
							$user->user_adress = $_POST['adress'];
							$user->real_name = $_POST['real_name'];
							$user->parent_name = $_POST['real_name'];
						}
						else
						{
							$user->user_adress = '';
							$user->real_name = '';
							$user->parent_name = '';
						}
						
						if($_POST['hasF'] == 'Y')
							$user->has_PP = 1;
						else
							$user->has_PP = 0;
						
						$user->record_adress();
						$user->record_more_info();
						$user->active_my_passport();
						if($_SESSION['new_reg'] == 1)//should be 1
						{
							global $userarr;
							require_once('mes/mes_utf.php');
							
							$mess = new send_message();//send the reg message
							$phone = array($userarr["phone"]);
							
							$card_id = find_card_id_by_uid($user->user_id);
						
							$content = '尊贵的会员，"儿童护照"已激活可使用，您的护照号码是:'.$card_id.'。为方便您使用，请牢记护照号码。【爱儿帮】';
							if($card_id){
								$mess->sendmess($phone, $content);
							}
							
							
							$url = "user_info.php"; 
							echo "<script language='javascript' type='text/javascript'>"; 
							echo "window.location.href='$url'"; 
							echo "</script>"; 
						}
						else
						{
							echo '护照已经被激活';
						}
	   				}
       				else if($_COOKIE['couponUserID'])
       				{
		   				$user->user_id = $_COOKIE['couponUserID'];
						$adress = $user->search_ad();
						$name = $user->search_name();
		   				$pass = $user->check_my_passport();//check my passport state
						$card = $user->find_card_id_by_uid();//get funard id, same as the passport id
						if($pass['result'] == 0)//should be 0
		   				{
			    			echo '
							<div class="form_item">
							<span class="tit" line-height:24px;width:170px; padding-left:30px;>护照已经被激活，<a href="mypage.php">返回</a></span></div>';
		     			}
		     			else
		     			{
							echo '
							<div class="reg_form">
                    		<!--第二步-->
                    		<div id="step2" style="padding-top:20px;">
                    		<form action="active.php" method="post">
                    		<div class="form_item">
                            	<span class="tit" style="height:24px;width:170px; padding-left:30px;display:none;"><input type="radio" checked="checked" name="hasF"  value="Y" id="send" onclick="javascript:add_disable();"/></span> 您的儿童护照号码是:<span style="color:red;float:none;">'.$card.'</span>（请记准您的护照号码，自助填写信息页）<label class="text" style="display:none;" ><input type="text" size="10" name="passport" id="passport" readonly="readonly" value="'.$card.'" /></label>
                        		</div>
                    			<div class="form_item" style="display:none;">
                          		<span class="tit" style="height:24px;width:170px; padding-left:30px;"><input type="radio" name="hasF" value="N"  onclick="javascript:remove_disable();" /> 第一次申领护照，邮寄地址</span><label class="text" ></span><input type="text" size="50"  name="adress" id="adress"/> </label>
								</div>
                    			<div class="form_item" >
								<div style="display:none;">								
                         		<span class="tit" style="height:24px;width:170px; padding-left:30px;">收件人</span><label class="text" ></span><input type="text" size="50" name="real_name" id="real_name"/> </label>
								</div>
								<input type="hidden" value="active_passport" name="active"></input>
                        		</div>
                        
                      		<div class="form_item" style="height:20px;"></div>
                        
                        		<div class="form_item">
                            		<span class="tit">&nbsp;</span><label><input type="submit" value="" class="but_activate" /></label>
                        		</div>
                        		</form>
                        			<div class="step_control">
                        			</div>
                        
                    			</div>
                    			<!--第二步-->
                			</div>
							';
						}
	   				}

		   ?>
                
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
