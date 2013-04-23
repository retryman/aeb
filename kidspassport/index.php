<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>最棒育儿指南_爱儿帮儿童护照_爱儿帮育儿体验、点评、优惠</title>
<meta name="description" content="儿童护照——为京城精心妈妈准备的育儿手册，儿童自己的护照。爱儿帮，让选择更简单。囊括育儿优惠，成长体验，帮友点评，趣玩活动等，体验、点评、优惠，三位一体。" />
<meta name="keywords" content="育儿指南，儿童护照，爱儿帮儿童护照" />
<link rel="stylesheet" type="text/css" href="CSS/main.css"/>
<link rel="stylesheet" type="text/css" href="CSS/fuzhao.css"/>
<script src="js/jquery-1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".tags_box").tags();
	
	$("#gift li").hover(function(){
		$(this).addClass("hover");					  
	},function(){
		$(this).removeClass("hover");
	})
})

$.fn.tags=function(){
	var obj=$(this);
	var tag=obj.find(".tags a");
	var Item=obj.find(".tag_item");
	
	tag.click(function(){
		tag.removeClass("current");
		$(this).addClass("current");
		Item.find(">div").hide();
		Item.find(">div:eq("+$(this).index()+")").show();
	})
	
}
</script>
<?php
//echo 2;
//error_reporting(E_ALL);
//ini_set('display_errors','On');
//echo 3;

    require_once('../funcard/tools/present.php');//for linux
	require_once('../funcard/tools/my_class.php');//for linux
	$present = new present();
	$my_class = new my_class();
	//echo 1;
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
	<div style="width:970px; margin: 0 auto;">
    	<img src="images/fuzhao_banner.jpg" align="center" />
    </div>
    <div id="login">
    	<div class="login_form" style="padding-top:10px;">
    	<?php if($_COOKIE["couponUserID"] && $_COOKIE["couponUserName"]):?>

    	<?php else:?>
            <form action="../funcard/tools/login.php" method="post">
        	<div class="form_item">
            	<span class="tit">用户名:</span><label class="text" ><input type="text" style="width:156px;" name="name"/></label>
            </div>
            
            <div class="form_item">
            	<span class="tit">密 码:</span><label class="text" ><input style="width:156px;" type="password" name="password" /></label>
            </div>
            
            <div class="form_item">
            	<input type="submit" class="button_submit" value="" />
            </div>
            <?php
			if(isset($_GET['error']))
            	echo '<div class="form_item"><span>用户名或密码错误</span></div>';
			?>
            </form>
            <div class="form_item" style="float:right;">
            	<span style="float:left;"></span>
                <a href="../funcard/register.php" class="button_reg"></a>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>

<div class="row">
	<div class="box">
    	<div class="box_top"></div>
    	<div class="box_mid">
    	    	<div class="login_form" style="padding-top:10px;">
    	<?php if($_COOKIE["couponUserID"] && $_COOKIE["couponUserName"]):?>
    	<div class="location">
    		<?php global $userarr;?>
            您好，<?php echo $_COOKIE["couponUserName"];?>&nbsp;&nbsp;欢迎来到爱儿帮护照国，目前积分是：<?php echo $userarr["score"];?>        <a href="/funcard/mypage.php">我的护照</a>&nbsp;&nbsp;&nbsp;<a href="/funcard/tools/logout.php">登出</a>
            </div><br/>
    	<?php endif?>
        
        	<div class="tags_box">
            	<div class="tags">
                	<a href="javascript:void(0)" class="current"><span>儿童护照介绍</span></a>
                	<a href="javascript:void(0)"><span>爱儿帮</span></a>
                	<a href="javascript:void(0)"><span>趣玩派</span></a>
                	<a href="javascript:void(0)"><span>护照换礼</span></a>
                </div>
            	<div class="tag_item">
                	<div class="tags1"><!--passport introduce-->
                   <div style=" line-height:18pt;">
                   <p align="right">
	<strong>热线：</strong><strong>400-812-2885</strong></p>
<p>&nbsp;
	</p>
<p>
	儿童护照涵盖的19 家护照国，是经过会员推荐，爱儿帮实地探营后精心挑选出来的京城育儿机构和游玩场所，<span style="color:#ff8c00;"><strong>倡导轻松趣玩的育儿生活方式是爱儿帮的一贯的追求</strong>！</span></p>
<p>&nbsp;
	</p>
<p>
	中国儿艺每张票优惠20元！蒲蒲兰绘本馆免费领取礼物！佳能旗舰店免费拍摄儿童证件照！ Astor&Ivy会所免费领取饮品！多家知名机构免费体验！绘本购买有折扣！早教培训有折扣！… 儿童护照关注儿童成长关键期所需的全方位体验，是您的得力助手与指南！不知道带孩子去哪儿玩？现在购买<strong>“爱儿帮儿童护照” ！</strong></p>
<p>&nbsp;
	</p>
<p>爱儿帮微信号： aierbang  <img height="100px" width="100px" src="/funcard/images/ewm.png?20130313" /></p><p>&nbsp;</p>
<p>
	<span style="color:#ff8c00;"><strong><span style="background-color:#d3d3d3;">护照注册温馨提示</span></strong></span></p>
<p style="margin-left:18.0pt;">
	1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 购买：请移步“爱儿帮淘宝小铺”，通过<a href="http://item.taobao.com/item.htm?spm=686.1000925.1000774.5.730242&id=20071160226" target="_blank" style="color:blue;text-decoration: underline;">支付宝支付（28元/单）</a>购买，付款后2个工作日内会发送儿童护照及激活码。</p>
<p style="margin-left:18.0pt;">
	2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 激活：点击右上角“注册”按钮，按提示填写信息和激活码</p>
<p style="margin-left:18.0pt;">
	<strong>3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 您的护照激活后，请牢记官网提示的护照号码（六位数字：如590***）并完善个人信息</strong></p>
<p style="margin-left:18.0pt;">
	4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请自助填写护照信息页; 详细阅读护照内容后持护照至各护照国游玩（为保证服务质量，建议您按照说明提前电话预约）。 </p>
<p style="margin-left:18.0pt;">
	5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 积分换礼：用激活码激活护照的会员可参加积分换礼活动。您在网站购买优惠或至各护照国游玩时，请告知护照号、手机号码及签证项目，以便积累您的积分。积分可在官网换取礼物（礼品及活动，不断更新中）！</p>
<p style="margin-left:18.0pt;">联系方式：aeb_kidspassport@126.com  400-812-2885</p>
	<p>&nbsp;</p>
<p>每一家护照国都是一个神奇的国度，带给孩子不一样的体验感受，带给家长一刻轻松育儿的惊喜，今天，你申领儿童护照了么？</p><p>&nbsp;</p>
<p align="left">
<span style="color:red; font-size:18px;"><strong>【爱儿帮儿童护照】</strong></span><span style="color:#ff8c00;font-size:18px;"><strong>家庭趣玩</strong></span><strong>+</strong><span style="color:#008000; font-size:18px;"><strong>育儿优惠</strong></span><strong>+</strong><span style="color:#0000ff; font-size:18px;"><strong>创意游戏</strong></span><strong style="font-size:18px;">，一个也不能少！</strong></p>
<p>&nbsp;</p>
<p style="font-size:18px;">这是一本集合了爱儿帮<span style="color:#ff00ff">精选</span>的京城育儿亲子好玩的机构和场所，并以孩子为中心的<span style="color:#ff00ff">儿童护照</span>，孩子们可以体验到四种不同的签证类型：</p><p>&nbsp;</p>	
<p align="left" style="font-size:18px;">
	<strong><span style="color:#339966;">过境签证</span>---</strong>持护照可在护照国盖章并积分（有些护照国免费发放礼物哦）</p>
<p align="left" style="font-size:18px;">
	<strong><span style="color:#339966;">旅游签证</span>---</strong>持护照可在旅游签证护照国参加体验项目，并盖章和积分。</p>
<p align="left" style="font-size:18px;">
	<strong><span style="color:#339966;">多次往返签证</span>---</strong>持护照可在护照国多次享有优惠，并盖章和积分。</p>
<p align="left" style="font-size:18px;">
	<strong><span style="color:#339966;">电子签证</span>---</strong>在护照官网可直接申领的电子签证。</p>
<p>&nbsp;</p>	
<p style="font-size:18px;">这是一本集合了<span style="color:#ff00ff;">好玩、优惠、成长记录</span>的护照。带孩子去体验游玩的同时，可以盖章，可以积分，当然，也帮助家长不知不觉中记录了孩子的成长。</p><p>&nbsp;</p>
<p style="font-size:18px;">这是一本倡导<span style="color:#ff00ff;">轻松、趣玩</span>的生活方式，在游戏中培养儿童美德、儿童社交的护照。孩子不再缺少玩伴，让我们一起游戏、一起体验，一起长大！</p><p>&nbsp;</p>
<p style="color:grey;">儿童护照发放解释权归爱儿帮育儿俱乐部所有</p><p>&nbsp;</p>
<p style="font-size:18px;color:#ff6600;">儿童护照上的每一家护照国都来自爱儿帮会员推荐或实地探营，祝您玩得开心！</p><p>&nbsp;</p>	
	
</div>
                    
                    </div><!--end of passport introduce-->
                    
                    
                    
                	<div class="tags2" style="display:none"><!--aeb introduce-->
                    
                    <p>
	爱儿帮，致力于给爱孩子，爱生活的父母家人们提供的一方纯净、积极、自由、互助的交流分享空间。帮友们可以在此畅所欲言：分享趣玩，点评商户，介绍经验，问题互助，疑惑辩论，甚至，投票决定！这样，虽然我们每个家庭只有一个或两个孩子，虽然我们之前没有养育孩子的丰富经验，虽然我们或多或少对孩子的未来成长之路有点忐忑和不安，可是我们有&ldquo;爱儿帮&rdquo;。<br><br>在这里，当我们面对繁芜的信息不知如何选择时，有帮友们的点评和投票会帮助我们把决定变得简单；当我们把育儿心得共享时，我们得到的就是大家的经验；当我们了解到帮友的成长经历时，我们对未来的养育之路就多了几分自如和掌控。一个人遇到的是问题，大家遇到的，就不再是问题，而是收获了。简单说，爱儿帮就是：人多力量大，大家帮大家！</p>
<p>&nbsp;
	</p>
<p>
	<span style="color:#808080;"><strong>我们要培养的孩子的目标：</strong>自由、自然、自信，国际化的中国人</span></p>
<p>&nbsp;
	</p>
<p align="left">
	<span style="color:#808080;"><strong>爱儿帮所选择四叶草的含义：</strong></span><br />
	&nbsp;&nbsp;&nbsp; <span style="color:#669933;">爱儿帮所选择的四叶草，每片叶子都赋予着不同的含义：<br />
	&nbsp;&nbsp;&nbsp; 第一片叶子是希望和信心<br />
	&nbsp;&nbsp;&nbsp; 第二片叶子是智慧和荣誉<br />
	&nbsp;&nbsp;&nbsp; 第三片叶子是爱和力量<br />
	&nbsp;&nbsp;&nbsp; 第四片叶子是健康和幸福</span></p>
<p align="left">&nbsp;
	</p>
<p align="left">
	<span style="color:#808080;">希望我们的帮友们，都能找到属于自己的四叶草，都能在各自的人生旅途中拥有不变的新鲜和幸福！</span></p>
<p>&nbsp;
	</p>
                    
                    </div><!--aeb introduce end-->
                	<div class="tags3" style="display:none">
                    	<p>爱儿帮FamilyFun趣玩派是爱儿帮育儿俱乐部的主题系列活动，秉承了爱儿帮的家庭趣玩社交理念，精选京城好玩有趣有品质的亲子活动场所，号召孩子们在活动中相互交流，共同成长！同时父母们沟通育儿心得，交流育儿理念，让养孩子的过程更加简单轻松！趣玩派组织的活动类型很多，如：春天的摄影、夏季的游园会、秋天的帐篷会、冬季的室内体验汇等。更有妈妈沙龙、宝宝烘焙等小规模活动。</p>
                        <p>爱儿帮2012下半年的家庭趣玩派活动拟有：天文馆一日游、宝贝当家High翻天、万圣节系列活动、圣诞狂欢Party等，请登录网站“我的护照”栏目浏览最新信息。</p>
                        <p>爱儿帮是一家以提倡儿童社交、家庭趣玩为核心理念，通过以育儿点评网（www.aierbang.org/dianping）为平台，组织推荐FamilyFun 趣玩派系列家庭活动（www.aierbang.org/notices）为家趣玩主题，同时提供为父母们提供精选的育儿优惠的俱乐部！</p>
                        
                        <p><img src="images/tag3.jpg" align="center" /></p>
                    </div>
                    
                    <div id="gift" style="display:none">
                    	<ul>
								<?php 
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
											
											if($_COOKIE['couponUserID']){
												$js = "window.location='../../funcard/mypage.php?status=present&pid=$pid'";
											}
											else{
												$js="alert('请您登录后查看');";
											}
			                                echo '<li>
                                    			<a style="cursor:pointer;" onclick="'.$js.'"><img src="/'.$pic.'" title="'.$full_title.'" /></a>
                                        		<a style="cursor:pointer;" onclick="'.$js.'" title="'.$full_title.'" ><span>'.$title.'</span></a>
												<span>剩余数量：'.$counts.'</span>
                                        		<span><font color="#ff9204" style="font-weight:bold;">所需积分：'.$score.'</font></span>';
											
											
										}
								?>
                                </ul>
                    </div>
                
                </div>
            </div>
        	
        </div>
    	<div class="box_bottom"></div>
    </div>
</div>

<?php include '../funcard/common/footer.php';?>


</body>
</html>
