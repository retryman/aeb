<?php
//dpm($node);
?>

<div id="node-<?php print $node->nid; ?>" class="nodetype_mem_camp clearfix">
<?php if($node->field_coupon_ctitle):?>
<?php foreach($node->field_coupon_ctitle as $key => $item):?>
	<div class="area_item area_<?php echo $key+1; ?>">
		<h2><?php echo $item['safe']; ?></h2>
		<div class="dcp-tex">
		<?php echo $node->field_coupon_cdes[$key]['safe'];?>
		</div>	
	</div>
<?php endforeach;?>	
<?php endif;?>	

<?php if($logged_in):?>
<!-- 
<input id="getmsgBtn" type="button" value="获取优惠券" />
 -->
<?php endif;?>
</div> <!-- /.node -->

<script type="text/javascript">
$(".nodetype_mem_camp img").each(function(){
	var width = $(this).attr("width");
	width = parseInt(width);
	if(width>760){		
		$(this).css('width','760px');
	}
});

$("#getmsgBtn").click(function(){
	var submitaddr = '<?php echo $base_url;?>/ajax/getcouponmsg';
	var nid = <?php echo $node->nid;?>;
	$.post(submitaddr,{'nid':nid},function(result){  	 
	   if(typeof(JSON) == 'undefined'){
		  result =  eval("(" + result + ")");
	   }
	   else{
		   result = JSON.parse(result);
	   }
  		if(result.status == 1){
			alert("优惠短信已经成功发送到您的手机，请查收。");
	  	}
  		else if(result.status == 2){
  			alert("完善您的手机信息");
  			window.location = '<?php echo $base_url;?>/funcard/mypage.php';
	  	}
  		else{

	  	}
	});	
});
</script>