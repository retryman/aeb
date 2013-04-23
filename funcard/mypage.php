<?php ob_start(); session_start();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的页面</title>
<link rel="stylesheet" type="text/css" href="CSS/main.css"/>
<link rel="stylesheet" type="text/css" href="CSS/jifen.css?20121129"/>
<script src="js/jquery-1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var checkList=$("#checkList");
	var list=$("#jifen_list");
	checkList.toggle(function(){
		list.fadeOut(500);
		checkList.removeClass("up");
		checkList.addClass("down");
	},function(){
		list.fadeIn(500);
		checkList.removeClass("down");
		checkList.addClass("up");
	});
	
	$("#jifen dd li").hover(function(){
		$(this).addClass("hover");						 
	},function(){
		$(this).removeClass("hover");
	})
	
	$("#gift li").hover(function(){
		$(this).addClass("hover");					  
	},function(){
		$(this).removeClass("hover");
	})
})
</script>
 <?php

 	   include_once 'tools/function.php';
   
       if(!$_COOKIE['couponUserID'])
	   {
		    $url = "../../kidspassport/"; 
			echo "<script language='javascript' type='text/javascript'>"; 
			echo "window.location.href='$url'"; 
			echo "</script>";
	   }
	   require_once('tools/user.php');
	   require_once('tools/present.php');
	   require_once('tools/class_merchant.php');
	   require_once('tools/class_record.php');
	   require_once('tools/my_class.php');
	   $user = new users();
	   $my_class = new my_class();
	   $present = new present();
	   $epp = new my_merchant();
	   
	   $last_url = 'mypage.php';
	   $user->user_id = $_COOKIE['couponUserID'];
	   
	   $pass = $user->check_my_passport();
	   $myscore = $user->find_score();
	   
	   $info = $user->check_info_complete();

	   ?>
</head>

<body>
<div class="row">
	<div id="header">
    	<div class="logo"><a href="http://www.aierbang.org"><img src="images/logo.jpg" /></a></div>
    	<div class="ad"><img alt="" src="/sites/default/files/1357306275.gif" style="width: 377px; height: 65px;"></div>
    	<div class="search">
        <iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=&c=CHXX0008&l=zh-CHS&p=CMA&a=0&u=C&s=3&m=0&x=1&d=0&fc=&bgc=&bc=&ti=1&in=1&li=2&ct=iframe" frameborder="0" scrolling="no" width="500" height="110" allowTransparency="true"></iframe>
        </div>
    </div>
</div>
<div class="row">
	<div class="box">
    	<div class="box_top"></div>
    	<div class="box_mid">
        	<div class="location">
            您好，<?php echo $_COOKIE["couponUserName"];?>&nbsp;&nbsp;欢迎来到爱儿帮护照国，目前积分是：<?php echo $myscore;?>
        <a href="mypage.php">我的护照</a>&nbsp;&nbsp;&nbsp;<a href=tools/logout.php>登出</a>
            </div>
            
            <div id="jifen">
            	<div class="jifen_left">
                	<dl>
                    	<dt>我的账户</dt><!--我的帐户开始-->
                        <dd>
                        	<ul>
                            	<li><a href="mypage.php">账户首页</a></li>
                            	<li>
                            	<?php if($info): ?>
									<a href="user_info.php">编辑个人信息</a>
								<?php else:?>
									<a href="user_info.php">完善个人信息</a>
								<?php endif;?>
								
                                </li>
                                
                            	<li>
                                <?php 
									switch($pass["result"])
	   								{
		   								case 0:
		   	   							{
			  	   						 	echo '<a>您的护照号是：'.$pass["passport_id"].'</a>';
	   									   break;
	   								   }
		   
	   								   case 1:
	   								   {
	   									   echo '<a href="active.php">您还没有护照，欢迎申领</a>';
	   									   break;
	   								   }
	   								   
	   								   case 2:
	   								   {
	   									   echo '<a href="active.php">护照未激活，点击激活</a>';
	   									   break;
	   								   }
	   							   }
								?>
                                </li>
                            </ul>
                        </dd>
                    </dl><!--我的帐户结束-->
                    
                	<dl><!--我的积分开始-->
                    	<dt>我的积分</dt>
                        <dd>
                        	<ul>
                            	<li><a href="mypage.php?status=myscore">我的积分</a></li>
                            	<li><a href="mypage.php">我的徽章</a></li>
                            	<li><a href="mypage.php?status=present">积分换礼</a></li>
                            </ul>
                        </dd>
                    </dl><!--我的积分结束-->
                    
                    <dl><!--电子签证开始-->
                    	<dt>电子签证中心</dt>
                        <dd>
                        	<ul>
                            	<li><a href="mypage.php?status=coupon&cid=48">特福芬</a></li>
                            	<li><a href="mypage.php?status=coupon&cid=47">乐科立体早教</a></li>
                            	<li><a href="mypage.php?status=coupon&cid=46">拉比盒子</a></li>
                                <li><a href="mypage.php?status=coupon&cid=45">爱儿帮趣玩派</a></li>
                            </ul>
                        </dd>
                    </dl><!--电子签证结束-->
                    
                    <dl><!--公告开始-->
                    	<dt>公告</dt>
                        <dd>
                        	<ul>
                            	<li><a href="mypage.php?status=notice&nid=1">护照国特别提示</a></li>
                            	<li><a href="mypage.php?status=notice&nid=2">会员专享特惠升级！</a></li>
                            </ul>
                        </dd>
                    </dl><!--公告结束-->
                </div>
                
                <div class="jifen_right">
                	<div id="userCenter_home">
                    	<div class="welcome">亲爱的，<?php echo $_COOKIE["couponUserName"];?>, </div>
                        
                        <!--<div class="jifen_box">
                        	<div class="th"><span>个人信息</span></div>
                            <div class="jifen_box_content" id="user_info">
                                <div class="left" style="width:400px;">
                                    <p><span>用户名： linan616</span> <a href="#" class="edit">修改</a> </p>
                                    <p><span>手  机： 15101657355</span><a href="#" class="edit">修改</a>  </p>
                                    <p><span>E-mail： 120558511@qq.com</span> <a href="#" class="edit">修改</a> </p>
                                </div>
                                
                                <div class="right"><a href="#">完善个人资料</a> | <a href="#">修改密码</a></div>
                            </div>
                        </div>-->
                        <?php
                         if(isset($_GET['status']))//显示单独项目
						 {
							 $status = $_GET['status'];
							 switch($status)
							 {
								case "myscore"://myscore
								{
									echo '<div class="jifen_box">
                        				<div class="th"><span>积分账户</span><a class="return" href="mypage.php">返回</a></div>
                            			<div class="jifen_box_content" id="user_jifen">
                            			<div style="overflow:hidden;">
                                		<p class="left">我的目前积分是： '.$myscore.'分。</p><p class="right" id="checkjifen"><a id="checkList" class="up">查看积分明细</a> </p>
                                		</div>
                                		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="jifen_list">
                                  		<tr class="th2">
                                    	<td scope="col">时间</td>
                                    	<td scope="col">护照国</td>
                                    	<td scope="col">积分数</td>
                                    	<td scope="col">有效期</td>
                                  		</tr>';
										
				  						$line = $user->my_score_record();
				   						$counts = count($line);
	   
				  						if($counts == 0 || $counts == null)
				   						{
											 echo '<tr>
                                    			<td>您还没有获得任何签证</td>
                                  				</tr>
											';
										}
										else
										{
				   							for($i = 0; $i < $counts; $i++)
				   							{
											echo'
                                  				<tr>
                                    			<td>'.substr($line[$i]['time'], 0, 10).'</td>
                                    			<td>'.$line[$i]['merchant_fullname'].'</td>
                                    			<td>'.$line[$i]['score'].'</td>
                                    			<td>2013-1-31</td>
                                  				</tr>';
											}
										}
										echo'
                                		</table>
										</div>
                            			</div>
                        			</div>';
									break;
								}
								//end of myscore
								
								//show all my present
								case "mypresent":
								{
									$line = $user->find_my_present();
				   					$counts = count($line);
									echo'
										<div class="jifen_box">
                        				<div class="th"><span>我的礼品</span><a class="return" href="mypage.php">返回</a></div>
			                            <div class="jifen_box_content" id="gift">
			                            	<ul>';
											
									if($counts == 0 || $counts == null)
				  					{
										echo'
											<li>
			                                 <img src="sitePIC/logo.png" />
			                                 <span>您还没有兑换任何礼品</span>
			                                 
			                                 </li>';
				   					}
				   					else
				   					for($i = 0; $i < $counts; $i++)
				   					{
			                                	echo '<li>
			                                    	<img src="/'.$line[$i]['pic'].'" />
			                                        <span>'.$my_class->cut_str($line[$i]['title'],8).'</span>
			                                        <span><font color="#ff9204" style="font-weight:bold;">'.$my_class->cut_str($line[$i]['des'], 30).'</font></span>
			                                    </li>';
									}
                                			echo'</ul>
                           			 	</div>
                       			 	</div>
									</div>
									';
									break;
								}
								//end of all my present
								
								case "present"://show all presents
		   						{
									if(isset($_GET['pid']))//show one present details
									{
										
										$last_url = 'mypage.php?status=present';
										$line = $present->find_present_by_id($_GET['pid']);
						
										$pid = $line[0]['pid'];
										$pic = $line[0]['pic'];
										$title = $line[0]['title'];
										$des = $line[0]['des'];
										$des2 = $line[0]['des2'];
										$score = $line[0]['score'];
										$price = $line[0]['price'];
										$counts = $line[0]['count'];
						
										echo'
					                	  <div class="jifen_box jfhl">
					               	    	<div class="th"><span>积分换礼</span><a class="return" href="mypage.php?status=present">返回</a></div>
					                            <div class="jifen_box_content" id="lipin">
					                              <div class="lipin_img">
					                              	<img src="/'.$pic.'" />
					                              </div>
					                              <div class="lipin_info">
					                              	<h3>'.$title.'</h3>
					                                <p>礼品价值: <span>'.$price.'元</span></p>
					                                <p>剩余数量: <span>'.$counts.'</span></p>
					                                <p class="jifen">所需积分:<span>'.$score.'</span></p>
					                                <p class="but">';
													if($counts > 0)
													{		
							
														if($score > $myscore)
														{
															echo '<span>积分不足</span>';
														}
														else
														{
															//check personal info
															if($info == 1)
															{
																echo '
																<form action="tools/exchange.php" method="post">
																<input type="hidden" name="score" value="'.$score.'"></input>
																<input type="hidden" name="myscore" value="'.$myscore.'"></input>
																<input type="hidden" name="pid" value="'.$pid.'"></input>
																<input type="hidden" name="counts" value="'.$counts.'"></input>
																<input type="hidden" name="url" value="'.$last_url.'"></input>';
								
																echo '<input type="submit" class="duihuan" value="" />';
																echo '</form>';
																//echo '<input type="image" src="sitePIC/button/button_exchange.png" name="exchange" value="">';
															}
															else
															{
																echo '<span>请您先完善用户信息</span>';
															}
														}//end if($score > $myscore)
														}//end if($counts > 0)
														else
														{
															echo '<span>已赠送完毕</span>';
														}//end of check exchange
														
										echo'</p>
					                              </div>
					                                
					                            </div>
					                        </div>';
                        				echo'
					                        <div class="jifen_box jfhl">
					                        	<div class="th"><span>商品介绍</span></div>
					                            <div class="jifen_box_content">
                            	
                                
					                               <p style="padding:10px;">'.$des.'</p>

					                            </div>
					                        </div>';
										if($des2){
										    echo'
					                        <div class="jifen_box jfhl">
					                        	<div class="th"><span>兑换方法</span></div>
					                            <div class="jifen_box_content">
					                               <p style="padding:10px;">'.$des2.'</p>
					                            </div>
                    					    </div>';
										}else{	
											echo'
					                        <div class="jifen_box">
					                        	<div class="th"><span>兑换方法</span></div>
					                            <div class="jifen_box_content">
					                               <p style="padding:10px;">爱儿帮儿童护照会员通过到护照国过境、旅游、消费等获得相应积分后登陆爱儿帮儿童护照官网积分兑换专区进行兑换，该礼品需'.$score.'积分兑换。请认真填写相关信息，并确认您的邮寄地址。活动特惠期间，该礼品爱儿帮育儿俱乐部免邮费，贴心送到家！</p>
					                            </div>
                    					    </div>';
										}
											
										echo'                        
					                    </div>
					                    </div>
					                </div>
										';
									}
									//end of show one present
									else//show all present
									{
										echo'
										<div class="jifen_box">
                        				<div class="th"><span>积分换礼</span><a class="return" href="mypage.php">返回</a></div>
			                            <div class="jifen_box_content" id="gift">';
										
										 if(isset($_GET['error']))
				   						{
					    					$error = $_GET['error'];
					    					if($error == 1)
					    					{
					   		  					echo '<div class="alert">积分不足</div>';
					     					}
				     					}
				   
					  					if(isset($_SESSION['exchange']))
					  					{
						  					echo '<div class="alert">兑换成功</div>';
						  					unset($_SESSION['exchange']);
					  					}
										
			                            echo '<ul>';
										
										$line = $present->find_all_present();
										$c = count($line);
										for($i=0; $i<$c; $i++)
										{
											$pid = $line[$i]['pid'];
											$pic = $line[$i]['pic'];
											$full_title = $line[$i]['title'];
											$title = $my_class->cut_str($line[$i]['title'], 8);
											$score = $line[$i]['score'];
											$counts = $line[$i]['count'];
			                                echo '<li>
                                    			<a href="mypage.php?status=present&pid='.$pid.'"><img src="/'.$pic.'" title="'.$full_title.'" /></a>
                                        		<a href="mypage.php?status=present&pid='.$pid.'" title="'.$full_title.'" ><span>'.$title.'</span></a>
												<span>剩余数量：'.$counts.'</span>
                                        		<span><font color="#ff9204" style="font-weight:bold;">所需积分：'.$score.'</font></span>';
											
											if($counts > 0)
											{		
							
											if($score > $myscore)
											{
												echo '<span>积分不足</span>';
											}
											else
											{
												//check personal info
												if($info == 1)
												{
													echo '
													<div><form id="exchange" action="tools/exchange.php" method="post">
													<input type="hidden" name="score" value="'.$score.'"></input>
													<input type="hidden" name="myscore" value="'.$myscore.'"></input>
													<input type="hidden" name="pid" value="'.$pid.'"></input>
													<input type="hidden" name="counts" value="'.$counts.'"></input>
													<input type="hidden" name="url" value="'.$last_url.'"></input>';
								
													echo '<input type="submit" class="button_submit" value="" />';
													echo '</form></div>';
													//echo '<input type="image" src="sitePIC/button/button_exchange.png" name="exchange" value="">';
												}
												else
												{
													echo '<span>请您先完善用户信息</span>';
												}
											}//end if($score > $myscore)
											}//end if($counts > 0)
											else
											{
												echo '<span>已赠送完毕</span>';
											}//end of check exchange
											
                                    		echo '</li>';
										}
										
											echo'</ul>
                           			 	</div>
                       			 	</div>
									</div>
									';
									}
									break;
								}
								//end of all presents
								
								case "coupon"://e passport exchange
								{
									//show one e-passport
									if(isset($_GET['cid']))
									{
										$cid = $_GET['cid'];
										$merchant = new my_merchant();							
										$myrecord = new my_record();
										
										$R = $merchant->find_my_e_coupon($cid);	
										$myrecord->cid = $R[0]['cid'];
										$myrecord->set_uid($_COOKIE['couponUserID']);
										$used = $myrecord->check_used();
										$counts = count($used);
										
										$title = $R[0]['title'];
										$score = $R[0]['score'];
										$coupon_used = $R[0]['used'];//decide how many time can one user exchanged
										$price = $R[0]['price'];
										$pic = $R[0]['value']; //picture's dir 
										$mid = $R[0]['mid'];//merchant ID
										$coupon_count = $R[0]['count']; //this passport's total count
										$des = $R[0]['des'];
										$rest = $coupon_used-$counts;//times exchanged left
										
										echo'
										<div class="jifen_box dzqz">
                        				<div class="th"><span>电子签证</span><a class="return" href="mypage.php">返回</a></div>
			                            <div class="jifen_box_content" id="gift">';
										if($pass["result"] != 0 && $info == 0)
										{
											echo '<div>请激活护照后并完善信息后再进行兑换，<a href="mypage.php">返回</a></div>';
										}
										else
										{
											if($R == null)
											{
												echo '<div>';
												echo '没有找到该优惠券';
												echo '</div>';
											}
											else
											{
												echo'
												
												<div class="jifen_box_content" id="lipin">
					                              <div class="lipin_img">
					                              	<img src="Mpic/epass/'.$pic.'" />
					                              </div>
					                              <div class="lipin_info">
					                              	<h3>'.$title.'</h3>
					                                <p>可兑换次数: <span>'.$rest.'</span></p>
					                                <p class="jifen">获得积分:<span>'.$score.'</span></p>
					                                ';
													
													
													if($counts >= $coupon_used)
													{
														echo '<p>本签证'.$rest.'次有效，您已成功兑换';
													}
													else if($coupon_count == 0)
													{
									
														echo '<p>改优惠券已经发放完毕';
													}
													else
													{
														if($info == 1)
														{
														echo '<p class="but"><form action="tools/e_coupon.php" method="POST">
														<input type="hidden" value="'.$score.'" name="score" id="score"></input>
														<input type="hidden" value="'.$price.'" name="price" id="price"></input>
														<input type="hidden" value="'.$coupon_count.'" name="count" id="count"></input>
														<input type="hidden" value="'.$mid.'" name="mid" id="mid"></input>
														<input type="hidden" value="'.$cid.'" name="cid" id="cid"></input>
														<input type="submit" class="duihuan" value=""></input>
														</form>';//<input type="image" src="sitePIC/button/button_get.png"></input>
														}
														else
														{
															echo '请您先完善用户信息再进行兑换';
														}
													}
													
															
												echo'</p>
					                              </div>
					                                
					                            </div>
					                        	</div>';
                        						echo'
					                        	<div class="jifen_box">
					                        	<div class="th"><span>签证介绍</span></div>
					                            <div class="jifen_box_content">
                            	
                                
					                               <p style="padding:10px; width:400px; line-height:20px; align:center; padding-left:125px;">'.$des.'</p>

					                            </div>
					                        	</div>';
											
                        						/*echo'
					                        	<div class="jifen_box">
					                        	<div class="th"><span>兑换方法</span></div>
					                            <div class="jifen_box_content">
					                               <p style="padding:10px;">爱儿帮儿童护照会员通过到护照国过境、旅游、消费等获得相应积分后登陆爱儿帮儿童护照官网积分兑换专区进行兑换，该礼品需'.$score.'积分兑换。请认真填写相关信息，并确认您的邮寄地址。活动特惠期间，该礼品爱儿帮育儿俱乐部免邮费，贴心送到家！</p>
					                            </div>
                    					    	</div>';*/
											
												
											}
										}
										echo'
                           			 		</div>
											</div>
											</div>
											';
									}//end of one e-passport
									else//show all passport
									{
									}
									break;
									//end of show all passport
								}
								//e passport exchange
								
								//显示通知
								case "notice":
								{
									if(isset($_GET['nid']))
										$nid = $_GET['nid'];
									else
										$nid = 0;	
									
									//require_once('tools/class_notice.php');
									//$notice = new notice($nid);
									//$filename = $notice->select_notice();
									$content = $my_class->read_text('notice/', $nid.'.txt');
									
									echo'
										<div class="jifen_box">
                        				<div class="th"><span>公告</span><a class="return" href="mypage.php">返回</a></div>
			                            <div class="jifen_box_content" id="gift">';
										
									echo '<div>';
									
									echo $content;
									echo '</div>';
									
									echo'
                           			 		</div>
											</div>
											</div>
											';
								}//通知结束
								break;
							 }
						 }//单独项目结束
						 else//显示全部项目
						 {
							 //我的积分
							 echo '<div class="jifen_box">
                        				<div class="th"><span>积分账户</span><a class="return" href="mypage.php?status=myscore">详细</a></div>
                            			<div class="jifen_box_content" id="user_jifen">
                            			<div style="overflow:hidden;">
                                		<p class="left">我的目前积分是： '.$myscore.'分。</p><p class="right" id="checkjifen"><a id="checkList" class="up">查看积分明细</a> </p>
                                		</div>
                                		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="jifen_list">
                                  		<tr class="th2">
                                    	<td scope="col">时间</td>
                                    	<td scope="col">护照国</td>
                                    	<td scope="col">积分数</td>
                                    	<td scope="col">有效期</td>
                                  		</tr>';
										
				  						$line = $user->my_score_record(3);
				   						$counts = count($line);
	   
				  						if($counts == 0 || $counts == null)
				   						{
											 echo '<tr>
                                    			<td>您还没有获得任何签证</td>
                                  				</tr>
											';
										}
										else
										{
				   							for($i = 0; $i < $counts; $i++)
				   							{
											echo'
                                  				<tr>
                                    			<td>'.substr($line[$i]['time'], 0, 10).'</td>
                                    			<td>'.$line[$i]['merchant_fullname'].'</td>
                                    			<td>'.$line[$i]['score'].'</td>
                                    			<td>2013-1-31</td>
                                  				</tr>';
											}
										}
										echo'
                                		</table>
										</div>
                            			</div>';
							 //我的积分结束
							 
							 //我的徽章
							 	echo'
							 	<div class="jifen_box">
                        		<div class="th"><span>我的徽章</span></div>
                            	<div class="jifen_box_content">
                               	<div class="hz" style="padding: 20px 10px;">
                               	<a href="http://www.aierbang.org/orgnization/4882" target="_blank" ><img src="images/sh/aicafe.jpg" height="30px;" /></a>
                                 <a href="http://www.aierbang.org/orgnization/4885" target="_blank" ><img src="images/sh/twg.jpg" height="30px;" /></a>
                               	 <a href="http://www.aierbang.org/orgnization/4883" target="_blank" ><img src="images/sh/mq.jpg" height="30px;" /></a>
                                 <a href="http://www.aierbang.org/orgnization/4884" target="_blank" ><img src="images/sh/ppl.jpg" height="30px;" /></a>
                               	 <a href="http://www.aierbang.org/orgnization/4886" target="_blank" ><img src="images/sh/yddsj.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/777" target="_blank" ><img src="images/sh/mjm.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4887" target="_blank" ><img src="images/sh/qxjqr.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/121" target="_blank" ><img src="images/sh/hgn.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/1411" target="_blank" ><img src="images/sh/wg.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4888" target="_blank" ><img src="images/sh/ymh.jpg" height="30px;" /></a>
                                  <a href="http://www.baihuibio.com" target="_blank" target="_blank" ><img src="images/sh/tff.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4889" target="_blank" ><img src="images/sh/lk.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4890" target="_blank" ><img src="images/sh/lbhz.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/notices" target="_blank" ><img src="images/sh/aeb.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4891" target="_blank" ><img src="images/sh/zgey.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/428" target="_blank" ><img src="images/sh/bbdj.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4892" target="_blank" ><img src="images/sh/qcd.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4892" target="_blank" ><img src="images/sh/cm.jpg" height="30px;" /></a>
                                  <a href="http://www.aierbang.org/orgnization/4881" target="_blank" ><img src="images/sh/jn.jpg" height="30px;" /></a>
                               	                               	                               	
                               	</div>
                           		</div>
                        		</div>
							 	';
							 	//我的徽章结束
								
								//我的礼品
								$line = $user->find_my_present(4);
				   					$counts = count($line);
									echo'
										<div class="jifen_box">
                        				<div class="th"><span>我的礼品</span><a class="return" href="mypage.php?status=mypresent">详细</a></div>
			                            <div class="jifen_box_content" id="gift">
			                            	<ul>';
											
									if($counts == 0 || $counts == null)
				  					{
										echo'
											<li>
			                                 <img src="sitePIC/logo.png" />
			                                 <span>您还没有兑换任何礼品</span>
			                                 
			                                 </li>';
				   					}
				   					else
				   					for($i = 0; $i < $counts; $i++)
				   					{
			                                	echo '<li>
			                                    	<img src="/'.$line[$i]['pic'].'" />
			                                        <span>'.$my_class->cut_str($line[$i]['title'],8).'</span>
			                                        <span><font color="#ff9204" style="font-weight:bold;">'.$my_class->cut_str($line[$i]['des'], 30).'</font></span>
			                                    </li>';
									}
                                			echo'</ul>
                           			 	</div>
                       			 	</div>
									';
								//我的礼品结束
								
								//全部礼品
								echo'
										<div class="jifen_box">
                        				<div class="th"><span>积分换礼</span><a class="return" href="mypage.php?status=present">详细</a></div>
			                            <div class="jifen_box_content" id="gift">';
										
										 if(isset($_GET['error']))
				   						{
					    					$error = $_GET['error'];
					    					if($error == 1)
					    					{
					   		  					echo '<div class="alert">积分不足</div>';
					     					}
				     					}
				   
					  					if(isset($_SESSION['exchange']))
					  					{
						  					echo '<div class="alert">兑换成功</div>';
						  					unset($_SESSION['exchange']);
					  					}
										
			                            echo '<ul>';
										
										$line = $present->find_all_present(8);
										$c = count($line);
										for($i=0; $i<$c; $i++)
										{
											$pid = $line[$i]['pid'];
											$pic = $line[$i]['pic'];
											$full_title = $line[$i]['title'];
											$title = $my_class->cut_str($line[$i]['title'], 8);
											$score = $line[$i]['score'];
											$counts = $line[$i]['count'];
			                                echo '<li>
                                    			<a href="mypage.php?status=present&pid='.$pid.'"><img src="/'.$pic.'" title="'.$full_title.'" /></a>
                                        		<a href="mypage.php?status=present&pid='.$pid.'" title="'.$full_title.'" ><span>'.$title.'</span></a>
												<span>剩余数量：'.$counts.'</span>
                                        		<span><font color="#ff9204" style="font-weight:bold;">所需积分：'.$score.'</font></span>';
											
											if($counts > 0)
											{		
							
											if($score > $myscore)
											{
												echo '<span>积分不足</span>';
											}
											else
											{
												//check personal info
												if($info == 1)
												{
													echo '
													<div><form id="exchange" action="tools/exchange.php" method="post">
													<input type="hidden" name="score" value="'.$score.'"></input>
													<input type="hidden" name="myscore" value="'.$myscore.'"></input>
													<input type="hidden" name="pid" value="'.$pid.'"></input>
													<input type="hidden" name="counts" value="'.$counts.'"></input>
													<input type="hidden" name="url" value="'.$last_url.'"></input>';
								
													echo '<input type="submit" class="button_submit" value="" />';
													echo '</form></div>';
													//echo '<input type="image" src="sitePIC/button/button_exchange.png" name="exchange" value="">';
												}
												else
												{
													echo '<span>请您先完善用户信息</span>';
												}
											}//end if($score > $myscore)
											}//end if($counts > 0)
											else
											{
												echo '<span>已赠送完毕</span>';
											}//end of check exchange
											
                                    		echo '</li>';
										}
										
											echo'</ul>
                           			 	</div>
                       			 	</div>
									';
								//全部礼品结束
								
								//全部电子签证
								echo'
										<div class="jifen_box">
                        				<div class="th"><span>电子签证</span></div>
			                            <div class="jifen_box_content" id="gift">';
								$epass = $epp->find_all_e_coupon(4);
								//print_r($epass);
								$count_epass = count($epass);
								echo '<ul class="all_e_coupon">';
								for($i = 0; $i<$count_epass; $i++)
								{
									$cid = $epass[$i]['cid'];
									$full_title = $epass[$i]['title'];
									$title = $my_class->cut_str($full_title, 15);
									$score = $epass[$i]['score'];
									$counts = $epass[$i]['count'];
									$pic = $epass[$i]['value'];
									echo '<li>
                                    <a href="mypage.php?status=coupon&cid='.$cid.'"><img src="Mpic/epass/'.$pic.'" title="'.$full_title.'" /></a>
                                    <a href="mypage.php?status=coupon&cid='.$cid.'" title="'.$full_title.'" ><span>'.$title.'</span></a>';
									if($counts >0)
										echo '<span>剩余数量：'.$counts.'</span>';
									else
										echo '<span>剩余数量：不限</span>';
									
                                     echo'<span><font color="#ff9204" style="font-weight:bold;">获得积分：'.$score.'</font></span>';
									 echo '<span><a style="color:#777;" href="mypage.php?status=coupon&cid='.$cid.'" title="'.$full_title.'" >现在获取</a></span>';
									echo'</li>';
								}
										
								echo'</ul>
                           			</div>
                       			 	</div>
									';
								//全部电子签证结束
										
							 echo'</div></div></div>';
						 }//显示全部项目结束
						?>
                    </div>
                    
                </div>
            </div>
    	<div class="box_bottom"></div>
    </div>
</div>

<?php include 'common/footer.php';?>

</body>
</html>
