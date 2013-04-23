<?php
global $base_path;

//for five star
if($comment -> fivestar_rating <= 20){
	$five_class = 'vote-down';
}
else if($comment -> fivestar_rating >= 80){
	$five_class = 'vote-up';
}
else{
	$five_class = '';
}
$author2 = user_load($comment -> uid);
//dpm($author2);
$image = '<img width="120px" src="'.base_path().$author2 -> picture.'" />';
?>
<?php if(arg(0) == 'orgnization' && arg(1) == 'comment'):?>
<div class="<?php print $classes; ?> clearfix">
  <div class="left">
	  <a href="<?php echo base_path().'user/'.$comment -> uid?>"><?php echo $image;?></a>
	  <div class="<?php echo $five_class;?>"></div>
  </div>
  <div class="right">
  <div class="node-title">
  <h3><?php echo l($comment -> node_title, 'node/'.$comment -> nid);?></h3>
  <div class="time">点评时间：<?php echo date('y-m-d', $comment -> timestamp);?></div>
  <div class="clear"></div>
  </div>
	<div class="clear"></div>
	  <div class="submitted">
	    <?php echo $author;?>
	    <span class="user-level">会员等级:</span>
	    <span class="userlevel<?php echo $author2 -> level;?>"></span>
	    <div class="clear"></div>
	  </div>
	  <div class="custom">
		  	<?php echo $comment -> fivestar_view?>
		  	<div class="vote">
		  	<span><?php echo $comment ->custom['labels']['vote1'].':'.$comment ->custom['vote1']?></span>
		  	<span><?php echo $comment ->custom['labels']['vote2'].':'.$comment ->custom['vote2']?></span>
		  	<span><?php echo '性价比:'.$comment ->custom['vote3']?></span>
		  	<?php if($comment ->custom['money']):?>
		  	<span><?php echo '费用:￥'.$comment ->custom['money']?></span>
		  	<?php endif;?>
		  	</div>
		  	<div class="clear"></div>
	    </div>

	  <div class="content">
	    <?php print str_replace($comment -> fivestar_view, ' ', $content ) ?>
	  </div> 	  
  </div><!-- /.right -->
</div> <!-- /.comment -->
<?php else:?>
<div class="<?php print $classes; ?> clearfix">
  <div class="left">
  	<a href="<?php echo base_path().'user/'.$comment -> uid?>"><?php echo $image;?></a>
    <div class="<?php echo $five_class;?>"></div>
  </div>
  <div class="right">
	
	  <div class="submitted">
	    <?php echo $author;?>
	  </div>
	  <div class="custom">
		  	<?php echo $comment -> fivestar_view?>
		  	<div class="vote">
		  	<span><?php echo $comment ->custom['labels']['vote1'].':'.$comment ->custom['vote1']?></span>
		  	<span><?php echo $comment ->custom['labels']['vote2'].':'.$comment ->custom['vote2']?></span>
		  	<span><?php echo '性价比:'.$comment ->custom['vote3']?></span>
		  	<?php if($comment ->custom['money']):?>
		  	<span><?php echo '费用:￥'.$comment ->custom['money']?></span>
		  	<?php endif;?>
		  	</div>
		  	<div class="clear"></div>
	    </div>

	  <div class="content">
	    <?php print str_replace($comment -> fivestar_view, ' ', $content ) ?>
	  </div>
	  
	  <div class="classified">
		  <?php if($comment ->custom['other']):?>
		  	<span class="label"><?php echo $comment ->custom['labels']['classified-label'].':'; ?></span>
			  <?php foreach($comment ->custom['other'] as $item):?>
			  	<?php if($item):?>
			  	<span><?php echo $item;?></span>
			  	<?php endif;?>			  
			  <?php endforeach;?>
		  <?php endif;?>
	  </div>
	<div class="time"><?php echo date('y-m-d H:i', $comment -> timestamp);?></div>
	  <?php print $links; ?>
  </div><!-- /.right -->
</div> <!-- /.comment -->
<?php endif;?>