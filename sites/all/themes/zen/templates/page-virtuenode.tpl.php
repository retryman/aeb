<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php echo $head_title;?></title>
  <?php print $head; ?>
  <?php print $scripts; ?>

<link type="text/css" rel="stylesheet" href="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/css/jscal2.css'; ?>" />
<link href="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/css/virtue.css?20130310'; ?>" rel="stylesheet" type="text/css" />

<body class="virtue">
<div class="main">

<?php include_once 'common/header.php';?>

<div class="content">

<?php include_once 'common/topnav.php';?>

<div id="topsliderbox">
<div id="topslider" class="nivoSlider">
<img src="/sites/all/themes/zen/zen-internals/images/pinknew/banner_bj.jpg"  alt="" data-transition="slideInLeft"/>
<img src="/sites/all/themes/zen/zen-internals/images/pinknew/banner_db.jpg"  alt="" data-transition="slideInLeft"/>
<img src="/sites/all/themes/zen/zen-internals/images/pinknew/banner_dld.jpg"  alt="" data-transition="slideInLeft"/>
<img src="/sites/all/themes/zen/zen-internals/images/pinknew/banner_meb.jpg"  alt="" data-transition="slideInLeft"/>
<img src="/sites/all/themes/zen/zen-internals/images/pinknew/banner_ny.jpg"  alt="" data-transition="slideInLeft"/>
</div>
<link rel="stylesheet" href="/sites/all/themes/zen/zen-internals/plugins/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript" src="/sites/all/themes/zen/zen-internals/plugins/nivo-slider/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $('#topslider').nivoSlider();
    });
</script>
</div>

<?php echo $breadcrumb;?>

<div class="content-inner">

<?php echo $content;?>

</div>
<div class="clear"></div>
</div>

<?php include_once 'common/footer.php';?>

</div>
</body>
</html>

<script src="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/js/jcarousellite_1.0.1.min.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
$(".awardusers").jCarouselLite({
    auto: 1100,
    speed: 1000,
    scroll: 1,
    visible: 4
});
</script> 

 <script src="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/js/jscal2.js' ?>"></script>
 <script src="<?php echo $base_path.drupal_get_path('theme', 'zen').'/zen-internals/js/cn.js' ?>"></script>
 <script type="text/javascript">
 var LEFT_CAL = Calendar.setup({
     cont: "cont",
     weekNumbers: false,
     selectionType: Calendar.SEL_MULTIPLE,
     //showTime: 12,
		onSelect      : function() {	
			var date = this.selection.get()[0];		
			var datestr = date.toString();
			year = datestr.substr(0,4);
			month = datestr.substr(4,2);
			day = datestr.substr(6,4);
			window.location = '/virtue/'+year+'-'+month+'-'+day;
	    }
     // titleFormat: "%B %Y"
});

LEFT_CAL.setLanguage('cn');
</script> 
 
  <?php print $closure; ?>

</body>
</html>