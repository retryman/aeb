<?php
include 'class/coupon.class.php';
$couponobj = new Coupon_a();
$data = $couponobj->getCoupons();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>育儿优惠</title>

</head>

<body>
<div class="main">
<?php include_once PROJECT_ROOT_PATH.'/../sites/all/themes/zen/templates/common/header.php';?>
<link href="/funcard/CSS/couponnew.css?20130104-2" rel="stylesheet" />
<div class="content">

<?php include_once PROJECT_ROOT_PATH.'/../sites/all/themes/zen/templates/common/topnav.php';?>

<div id="banner"></div>

<div class="row" id="content">
	<div id="list">
	<?php if($data["res"]):?>
	<?php foreach($data["res"] as $key => $row):?>
    	<dl>
        	<dt> 
        	<a target="_blank" href="/node/<?php echo $row["nid"];?>">
        	<img src="/<?php echo $row["filepath"];?>" width="258" height="190" /></a>
        	<div class="tagitems">
        	<?php foreach($row['tags'] as $item):?>
        	<a class="tagitem" href="/funcard/coupon.php?tid=<?php echo $item['tid']; ?>"><?php echo $item['name']; ?></a>
        	<?php endforeach;?>
        	</div>
        	</dt>
            <dd>
            	<a target="_blank" href="/node/<?php echo $row["nid"];?>"><h5><?php echo $row["title"];?></h5></a>
                <p><a target="_blank" href="/node/<?php echo $row["nid"];?>"><?php echo $row['body'];?></a></p>
            </dd>
        </dl>
        <?php endforeach;?>
    <?php endif;?> 
    </div>
</div>

<div class="clear"></div>
</div>

<?php include_once PROJECT_ROOT_PATH.'/../sites/all/themes/zen/templates/common/footer.php';?>
	
</div>
<br/>
<br/>
</body>
<script type="text/javascript">
$(document).ready(function(){
	$("#nav").nav();
	$("#list dl").each(function(){
		$(this).hover(function(){
			$(this).addClass("hover");				   
		},function(){
			$(this).removeClass("hover");
		})						
	})
})
$.fn.nav=function(){
	var obj=$(this);
	var li=obj.find(">ul >li");
	li.each(function(){
		$(this).hover(function(){
			$(this).find("ul").show().css("left",$(this).offset().left);				   
		},function(){
			$(this).find("ul").hide();
		})				 
	})
}
</script>
</html>
