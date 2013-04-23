<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php echo $head_title;?></title>
  <?php print $head; ?>


<body>
<div class="main">

<?php include_once 'common/header.php';?>
<link href="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/css/home.css'; ?>" rel="stylesheet" type="text/css" />
<div class="content">
<div class="box11 box1">
</div>
<div class="box12 box1">
<h2>育儿点评</h2>
<ul>
<li><a href="<?php echo $base_url;?>/dianping">帮友点评</a></li>
<li><a href="<?php echo $base_url;?>/camp">爱儿帮探营</a></li>
</ul>
</div>
<div class="box13 box1"></div>
<div class="box14 box1"></div>
<div class="box15 box1">
<h2>会员服务</h2>
<ul>
<li><a href="<?php echo $base_url;?>/user/login">登录</a></li>
<li><a href="<?php echo $base_url;?>/funcard/register.php">注册</a></li>
<li><a href="">个人会员</a></li>
<li><a href="<?php echo $base_url;?>/ka">大客户服务</a></li>
</ul>
</div>

<div class="box21 box2"></div>
<div class="box22 box2"></div>
<div class="box23 box2">
<h2>儿童护照</h2>
<ul>
<li><a href="<?php echo $base_url;?>/funcard/mypage.php">我的护照</a></li>
<li><a href="<?php echo $base_url;?>/funcard/coupon.php">育儿优惠</a></li>
</ul>
</div>
<div class="box24 box2"></div>
<div class="box25 box2"></div>

<div class="box31 box3"></div>
<div class="box32 box3"></div>
<div class="box33 box3"></div>
<div class="box34 box3">
<h2>趣玩派</h2>
<ul>
<li><a href="<?php echo $base_url;?>/notices">趣玩活动</a></li>
<li><a href="<?php echo $base_url;?>/experience">经验分享</a></li>
<li><a href="<?php echo $base_url;?>/questions">你问我答</a></li>
<li><a href="<?php echo $base_url;?>/virtue">成长记录</a></li>
</ul>
</div>
<div class="box35 box3"></div>
</div>

<?php include_once 'common/footer.php';?>

</div>
</body>
</html>

<script type="text/javascript">
$(".box12 ul li").hover(function(){$(this).css("background-color",'#ffab48');},function(){$(this).css("background-color",'#FFA133');});
$(".box15 ul li").hover(function(){$(this).css("background-color",'lightgreen');},function(){$(this).css("background-color",'#9AD072');});
$(".box23 ul li").hover(function(){$(this).css("background-color",'#ffdc47');},function(){$(this).css("background-color",'#FFCC00');});
$(".box34 ul li").hover(function(){$(this).css("background-color",'lightpink');},function(){$(this).css("background-color",'#FF8BBA');});
</script>
 

  <?php print $closure; ?>

</body>
</html>