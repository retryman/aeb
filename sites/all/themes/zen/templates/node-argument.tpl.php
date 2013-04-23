<?php
//dpm($node);

//echo  theme('vud_widget', $node -> nid, 'node', 'vote', 'upanddown', 0, 2);

?>


<?php if(!$teaser):?>
	<div id="node-<?php print $node->nid; ?>" class="<?php echo 'node-argument'; ?> <?php print $classes; ?> clearfix">
	<span class="allcoms">全部评论(<?php echo $node -> comment_count;?>条)</span>
	<h1 class="title"><?php echo $node -> title;?></h1>
	<div class="opinions">
	<div class="opininner">
	    <div class="opinionhd">
	    	<div class="des des-up">
			<h2>正方观点</h2>
			<span><?php echo $node -> upvotecount;?></span>			
			</div>
			<div class="des des-down">
				<h2>反方观点</h2>
				<span><?php echo str_replace('-', '', $node -> downvotecount);?></span>					
			</div>
			<div class="des des-middle">
				<h2>第三方观点</h2>				
			</div>			
	    </div>
	    
	    <div class="clear"></div>
	    
		<div class="up">
			<div class="fdes"><?php echo $node -> content['body']['#value']?></div>
			<?php 
			$upimg = '<img src="/'.drupal_get_path('theme', 'zen').'/zen-internals/images/pink/experience-blocks-up.png" />';
			echo l($upimg, 'vote/node/'.$node -> nid.'/1/vote/upanddown/'.drupal_get_token("vote/node/".$node -> nid."/1/vote/upanddown"), array('html' => true));
			?>
			<?php echo  drupal_get_form("comment_custom_argument_form", 1);?>
			
			<?php if(count($node -> upcomment)):?>			
				<?php foreach($node -> upcomment as $item):?>				
				<div class="comment-item">
					<div class="userinfo">
						<span><?php echo l($item['name'], 'user/' . $item['uid'].'/cover');?></span>
						<?php if($item['edit']):?>
							<span><?php echo $item['edit']; ?></span>
							<span><?php echo $item['delete']; ?></span>
						<?php endif;?>
						
					</div>
					<p><?php echo $item['comment'];?></p>
					<span class="time"><?php echo date('Y-m-d H:i:s',$item['time']);?></span>
				</div>				
				<?php endforeach;?>
				<?php echo theme('pager', '', 10, 1);?>
			<?php endif;?>
						
		</div>
		<div class="down">
			<div class="fdes"><?php echo $node -> field_oppose_opinion[0]["value"]?></div>
			
			<?php 
			$upimg = '<img src="/'.drupal_get_path('theme', 'zen').'/zen-internals/images/pink/experience-blocks-down.png" />';
			echo l($upimg, 'vote/node/'.$node -> nid.'/-1/vote/upanddown/'.drupal_get_token("vote/node/".$node -> nid."/-1/vote/upanddown"), array('html' => true));
			?>
			
			<?php echo  drupal_get_form("comment_custom_argument_form", 2);?>	
			
			<?php if(count($node -> downcomment)):?>			
				<?php foreach($node -> downcomment as $item):?>				
				<div class="comment-item">
					<div class="userinfo">
						<span><?php echo l($item['name'], 'user/' . $item['uid'].'/cover');?></span>
						<?php if($item['edit']):?>
							<span><?php echo $item['edit']; ?></span>
							<span><?php echo $item['delete']; ?></span>
						<?php endif;?>
						
					</div>
					<p><?php echo $item['comment'];?></p>
					<span class="time"><?php echo date('Y-m-d H:i:s',$item['time']);?></span>
				</div>				
				<?php endforeach;?>
				<?php echo theme('pager', '', 10, 2);?>
			<?php endif;?>
									
		</div>	
		<div class="middle">
			<div class="fdes"><?php echo $node -> field_other_opinion[0]["value"]?></div>
			<?php echo  drupal_get_form("comment_custom_argument_form", 3);?>	
			
			<?php if(count($node -> middlecomment)):?>			
				<?php foreach($node -> middlecomment as $item):?>				
				<div class="comment-item">
					<div class="userinfo">
						<span><?php echo l($item['name'], 'user/' . $item['uid'].'/cover');?></span>
						<?php if($item['edit']):?>
							<span><?php echo $item['edit']; ?></span>
							<span><?php echo $item['delete']; ?></span>
						<?php endif;?>
						
					</div>
					<p><?php echo $item['comment'];?></p>
					<span class="time"><?php echo date('Y-m-d H:i:s',$item['time']);?></span>
				</div>				
				<?php endforeach;?>
				<?php echo theme('pager', '', 10, 3);?>
			<?php endif;?>
							
		</div>
		
		<div class="clear"></div>
	</div><!-- end <div class="opininner"> -->		
	</div>

	</div> <!-- /.node -->
<script type="text/javascript">
jQuery.autoheight=function(item1, item2, item3){
	height1 = item1.height();
	height2 = item2.height();
	height3 = item3.height();
	if(height2>height1 && height2>height3){
		item1.css('height',height2);
		item3.css('height',height2);
	}
	else if(height3>height1 && height3>height2){
		item1.css('height',height3);
		item2.css('height',height3);
	}
	else{
		item3.css('height',height1);
		item2.css('height',height1);		
	}
};
$('document').ready(function(){
	updiv = $(".node-argument .up");
	updown = $(".node-argument .down");
	middle = $(".node-argument .middle");
	$.autoheight(updiv, updown, middle);
});

//updiv = $(".node-argument .des-up");
//updown = $(".node-argument .des-down");
//$.autoheight(updiv, updown);
</script>		
<?php else:?>

<?php endif;?>