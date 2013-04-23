<?php
// $Id: node.tpl.php,v 1.10 2009/11/02 17:42:27 johnalbin Exp $

/**
 * @file
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 *   The following applies only to viewers who are registered users:
 *   - node-by-viewer: Node is authored by the user currently viewing the page.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $build_mode: Build mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $build_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * The following variables are deprecated and will be removed in Drupal 7:
 * - $picture: This variable has been renamed $user_picture in Drupal 7.
 * - $submitted: Themed submission information output from
 *   theme_node_submitted().
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess()
 * @see zen_preprocess_node()
 * @see zen_process()
 */
global $base_url;

//dpm($node);
?>
<?php if(!$teaser):?>
<?php $author = user_load($node -> uid);?>
	<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix">
	
	<div class="left">
	         <?php if($node -> field_image[0]['view']):?>		 
		 <?php echo $node -> field_image[0]['view']?>
		 <?php endif;?>
	</div>
	
	<div class="right">
	  
	   <h2 class="title"><?php print $title; ?></h2>  
	   <div class="votes"><div class="text">综合评价: </div>
	   <?php echo $node -> content['fivestar_widget']['#value'];?>
	   	<div class="vote">		  	
		  	<?php if($node ->average['votes'] -> vote1):?>
		  		<span><?php echo $node ->average['labels']['vote1'].':'.round($node ->average['votes'] -> vote1, 1)?></span>
		  	<?php endif;?>
		  	<?php if($node ->average['votes'] -> vote2):?>
		  		<span><?php echo $node ->average['labels']['vote2'].':'.round($node ->average['votes'] -> vote2, 1)?></span>
		  	<?php endif;?>
		  	<?php if($node ->average['votes'] -> vote3):?>
		  		<span><?php echo '性价比:'.round($node ->average['votes'] -> vote3, 1)?></span>
		  	<?php endif;?>
		  	<?php if($node ->average['money'] -> money):?>
		  		<span><?php echo '费用:￥'.round($node ->average['money'] -> money, 0)?></span>
		  	<?php endif;?>		  	
	  	</div>
	  	<div class="clear"></div>
	  	</div>	
	
	  <div class="content">
	  <?php if($node -> field_address[0]['view']):?>
	   	<div class="field">
	        <div class="field-label">地址:</div>
	        <div class="field-items">
	        	<div class="field-item odd"><?php echo $node -> field_address[0]['view'];?></div>
	        </div>
		</div>
	  <?php endif;?>
	  <?php if($node -> field_phone[0]['view']):?>
		<div class="field">
	        <div class="field-label">联系电话:</div>
	        <div class="field-items">
	        	<div class="field-item odd"><?php echo $node -> field_phone[0]['view'];?></div>
	        </div>
		</div>
		 <?php endif;?>
		<?php if($node -> field_website[0]['view']):?>
		<div class="field">
	        <div class="field-label">网址:</div>
	        <div class="field-items">
	        	<div class="field-item odd"><a target="_blank" href="<?php echo $node -> field_website[0]['view']?>"><?php echo $node -> field_website[0]['view'];?></a></div>
	        </div>
		</div>
		 <?php endif;?>
		<?php if($node -> field_price_area[0]['view'] && $node -> field_price_end[0]['view']):?>
		<div class="field">
	        <div class="field-label">价格区间:</div>
	        <div class="field-items">
	        	<div class="field-item odd"><?php echo $node -> field_price_area[0]['view'];?>-<?php echo $node -> field_price_end[0]['view'];?></div>
	        </div>
		</div>
		 <?php endif;?>
		<?php if($node -> field_fit_age[0]['view'] && $node -> field_fit_age_end[0]['view']):?>
		<div class="field">
	        <div class="field-label">适合年龄:</div>
	        <div class="field-items">
	        	<div class="field-item odd"><?php echo $node -> field_fit_age[0]['view'];?>-<?php echo $node -> field_fit_age_end[0]['view'];?></div>
	        </div>
		</div>
		 <?php endif;?>
		<?php if( $node -> content['body']['#value']):?>		
			 
			 <?php echo $node -> content['body']['#value'];?>
        
         <?php endif;?>	
         

	  </div><!-- end content -->
	
	   <?php if ($terms): ?>
	      <div class="terms"><span>分类：</span><?php print $terms; ?></div>
	   <?php endif; ?>
	   <div class="buttons">
	   <a class="comment" href="#edit-comment">我要点评</a>
	   <a class="czjl" href="#">添加为我的成长经历</a>
	   </div>
	  <?php if($links):?>
	  <div class = "node-links">
	  	<?php print $links; ?>
	  	</div>
	  <?php endif;?>
	</div><!-- /.right -->
	</div> <!-- /.node -->
	<div class="author-info">
		此商户由<?php echo l($author -> name, 'user/'.$author -> uid);?>添加,<?php echo l($fc_author['name'], 'user/'.$fc_author['uid']);?>为第一点评人,共有<?php echo $node -> comment_count;?>人点评。
	</div>
<?php else:?><!-- teaser view -->
	<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix">
	
	<div class="left">
	<a href="<?php echo $base_url.'/node/'.$node -> nid?>"><img width="120px" height="80px" src="<?php echo base_path().$node -> field_image[0]['filepath'];?>" /></a>
	</div>
	
	<div class="right">
	  
	   <h2 class="title"><?php print l($title, 'node/'.$node -> nid); ?></h2>  
	
	  <div class="tea-con">
	    <span class="address">地址：<?php print $node -> field_address[0]['value']; ?></span>
	    <span class="phone">电话：<?php print $node -> field_phone[0]['value']; ?></span>
	  </div>

	</div><!-- /.right -->
	</div> <!-- /.node -->
	
<?php endif;?>