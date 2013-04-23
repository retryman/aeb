<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php echo $head_title;?></title>
  <?php print $head; ?>
  <?php //print $scripts; 
  ?>

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
<!-- content start -->
<?php global $base_url;?>
<div id="content" class="row">
	<div class="left">
    	<div class="virtueth"></div>
        <div class="ningjiangtai">
	        <div class="awardusers">
	        	<?php
				$block = module_invoke('content_custom', 'block', 'view', 20);
				print $block['content'];		
				?>

			</div> 
        </div>
        
        <div class="box">
        <?php if($content['uservirtues']):?>
        	<div class="box_top"></div>
            
            <div id="list" class="box_content">
            <?php foreach($content['uservirtues'] as $item):?>
            	<dl>
                	<dt>
                    	<p class="user"><a href="/user/<?php echo $item["uid"]?>/cover"><?php echo $item['uname'];?></a></p>
                        <p><span class="title"><?php echo $item['title'];?></span><?php echo l('查看全部', 'node/'.$item['nid'])?></p>
                        <?php if($item["image"]):?>
                        <p>
                        <img class="commentimg" style="width:100px;cursor:pointer;" src="/<?php echo $item["image"] ?>">
                        </p>
                        <?php endif;?>
                    </dt>
                    <dd>
                    	<div class="date"><?php echo $item['date'];?></div>
						
						<!-- Baidu Button BEGIN -->
						<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{'text':'<?php echo $item['title'];?>','pic':'<?php echo $base_url.'/'.$item["image"]; ?>'}">
						<a class="bds_qzone"></a>
						<a class="bds_tsina"></a>
						<a class="bds_tqq"></a>
						<a class="bds_renren"></a>
						<a class="bds_t163"></a>
						<span class="bds_more"></span>
						<a class="shareCount"></a>
						</div>
						<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
						<script type="text/javascript" id="bdshell_js"></script>
						<script type="text/javascript">

						document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
						</script>
						<!-- Baidu Button END -->
                    	
                    	<div class="button">
                    		<?php echo l('评论', 'node/'.$item['nid'],array('attributes' => array('class'=>'comment')));?>
                    		<div class="comcount"><?php if($content['uservirtues_count'][$item['nid']] ->count):?><?echo $content['uservirtues_count'][$item['nid']] ->count; ?><?php else:?>0<?php endif;?></div>
                    		<?php echo $item["vote"];?>
                        </div>
                    </dd>
                </dl>
                
            <?php endforeach;?> 
            </div>
            
            <div class="box_bottom"></div>
            <?php endif;?>
            
			<div class="pagerbox">
			<?php echo theme('pager', array('','','','',''));?>
			<script type="text/javascript">
			$("ul.pager li").hover(function(){$(this).addClass("hover");},function(){$(this).removeClass("hover");});
			</script>
			</div>
			<div class="clear"></div>
        </div>
    </div>
    
    <div class="right">
		<a <?php if($logged_in):?>href="/node/add/daily-virtue"<?php endif;?> ><div class="calendar-top"></div></a>        
        <div class="calendar">   
<div id="cont"></div>
        </div>
        <div class="clear"></div>
        <div class="form">
        	<?php echo drupal_get_form('_cc_custom_virtue_form');?>
        </div>
    </div>
</div>
<!-- content end -->
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
<script type="text/javascript">
$(document).ready(function(){
	 $("#edit-content").focus(function(){
	    if($(this).attr("value") == "请填入成长记录"){
	 		$(this).attr("value", "");
	 	}	
	 });
	$("#edit-submit-1").hover(function(){$(this).addClass("hover");},function(){$(this).removeClass("hover");});

	$(".commentimg").click(function(){
		if($(this).css("width") == '100px'){
			$(this).css("width",'auto').css('max-width','600px');
		}
		else{
			$(this).css("width",'100px').css('max-width','');
		}
	});
	
})
</script>
</html>