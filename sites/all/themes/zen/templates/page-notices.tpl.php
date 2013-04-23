<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
<title><?php echo $head_title;?></title>
<?php print $head; ?>
<link href="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/css/notice.css'; ?>" rel="stylesheet" type="text/css" />
<body class="notices">
<div class="main">

<?php include_once 'common/header.php';?>

<div class="content">

<?php include_once 'common/topnav.php';?>

<div id="topsliderbox">
<div id="topslider" class="nivoSlider">
<img src="/sites/all/themes/zen/zen-internals/images/pinknew/banner.jpg"  alt="" data-transition="slideInLeft"/>
</div>
<link rel="stylesheet" href="/sites/all/themes/zen/zen-internals/plugins/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript" src="/sites/all/themes/zen/zen-internals/plugins/nivo-slider/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $('#topslider').nivoSlider();
    });
</script>
</div>

<div class="breadcrumb">
<a href="/">首页</a> › <a>趣玩活动</a>
</div>

<div class="content-inner">

<div class="leftbar">
<?php if($content['leftbar']):?>
<ul>
<?php foreach($content['leftbar'] as $item):?>
<li <?php if($item->parents[0]>0):?>class="child"<?php else:?>class="parent"<?php endif;?>><a  href="/category/<?php echo $item->vid;?>/<?php echo $item->tid;?>"><?php echo $item->name;?></a></li>
<?php endforeach;?>
</ul>
<?php endif;?>
</div>
<script type="text/javascript">
$(".leftbar ul li.child").hover(function(){$(this).addClass('cur');},function(){$(this).removeClass('cur');})
</script>

<div class="right-box">
<div class="probox">
    <ul>
    <?php foreach($content['promotes'] as $row):?>
        <li>
        <a href="<?php echo $row->link;?>">
        <?php echo $row->image;?>
        <span><?php echo $row->title;?></span>
        </a>
        </li>
	<?php endforeach;?>
    </ul>
</div>

<ul class="newslist">
<?php foreach($content['content'] as $row):?>
<li><?php echo l($row->node_title,'node/'.$row->nid);?></li>
<?php endforeach;?>
</ul>

<div class="pagerbox">
<?php echo $content['pager'];?>
<script type="text/javascript">
$("ul.pager li").hover(function(){$(this).addClass("hover");},function(){$(this).removeClass("hover");});
</script>
</div>
<div class="clear"></div>
</div>

</div>
<div class="clear"></div>
</div>

<?php include_once 'common/footer.php';?>

</div>
</body>
</html>

<script src="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/js/jcarousellite_1.0.1.min.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
$(".probox").jCarouselLite({
    auto: 1100,
    speed: 1000,
    scroll: 1,
    visible: 4
});
</script>
 

  <?php print $closure; ?>

</body>
</html>