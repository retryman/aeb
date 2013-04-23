<?php 
//dpm($node);
?>

<div id="node-<?php print $node->nid; ?>" class=" node<?php echo $node -> type; ?> node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<h1><?php echo $node -> title;?></h1>
<div class="top-content">
	<div class="top-description">
	    <div class="image">
	    	<div class="image-inner">
	    	<span>
		    	<a>
		    	<?php echo theme('imagecache', 'camp-logo', $node -> field_org_logo[0]['filepath']);?>
		    	</a>
	    	</span>
			</div>
		</div>
		<div class="text">
		<?php echo $node -> content['body']['#value'];?>		
		</div>
	</div>
  	
<?php if($firstImage): ?>
<?php echo $firstImage;?>
<?php endif;?>
   
</div><!-- end top-content -->
	
<div class="imgNavigation">
<?php echo $node -> content['gallery']['#value']; ?>
</div>

<div class="nodebotton">
<?php echo $node -> content['fivestar_widget']['#value'];?>
<?php echo $node -> links['flag-want_use']['title']?>
<?php echo $node -> links['flag-used']['title']?>
<a class="link-comment" href="#edit-comment">我来说几句</a>
<!--  
<a class="view-comment" href="#" class="viewcomment">看看爱儿帮点评</a>
-->
<div class="clear"></div>
</div>

</div>
<script type="text/javascript">

$(".imgNavigation ul li a").click(getbigImage);	
$("#bigImgage .pre-link a").click(getbigImage);	
$("#bigImgage .next-link a").click(getbigImage);	

function getbigImage(){
	
	var bigImage = $("#bigImgage");
	var bigImageText = $("#image-dct");
	bigImage.html('<div class="loading">正在载入图片...</div>');
	bigImageText.empty();
	
	//get nid
	var nid = $(this).attr('nid');

	if(nid == null){
		nid = $(this).attr('href');
		nid = nid.split('/');
		nid = nid[2];
		//alert(nid);
	}

	//get image and description
	$.ajax({
		   type: "GET",
		   url: rooturl+"/camp/ajaximg",
		   data: "nid="+nid,
		   success: function(data){	  	   
		      data_arr = data.split('###&&&');
		      bigImage.html(data_arr[0]);
		      bigImageText.html(data_arr[1]);
		      $("#bigImgage .pre-link a").click(getbigImage);	
		      $("#bigImgage .next-link a").click(getbigImage);		      
		   }
		 });

	return false;
}

</script>