<?php

global $base_url;
$author = user_load($node -> uid);
//dpm($node);
$total = db_result(db_query("SELECT c.field_activity_image_index_value FROM content_type_activity c LEFT JOIN node n ON c.nid = n.nid WHERE n.title='%s' ORDER BY c.field_activity_image_index_value DESC", $title));
$current_index = $node -> field_activity_image_index[0]['value'];
function _get_next_activity_nid($title, $current_index, $total){
  if($current_index == $total){
    $current_index = 0;
  }
  $next_nid = db_result(db_query("SELECT c.nid FROM content_type_activity c LEFT JOIN node n ON c.nid = n.nid WHERE n.title = '%s' AND field_activity_image_index_value = %d", $title, $current_index+1));
  if(!$next_nid){
    _get_next_activity_nid($title, $current_index+1);
  }
  return $next_nid;
}
function _get_last_activity_nid($title, $current_index, $total){
  if($current_index == 1){
    $current_index = $total;
  }
  $last_nid = db_result(db_query("SELECT c.nid FROM content_type_activity c LEFT JOIN node n ON c.nid = n.nid WHERE n.title = '%s' AND field_activity_image_index_value = %d", $title, $current_index-1));
  if(!$last_nid){
    _get_last_activity_nid($title, $current_index-1);
  }
  return $last_nid;
}
$next_nid = _get_next_activity_nid($title, $current_index, $total);
$last_nid = _get_last_activity_nid($title, $current_index, $total);
?>
	<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix">
	
   <h2 class="title"><?php print $title." ($current_index/$total)"; ?></h2>  
  <div class="navigation">
		  <a class="last" href=<?php echo $base_url.'/node/'.$last_nid;?>>上一张</a>
		  <a class="next" href=<?php echo $base_url.'/node/'.$next_nid; ?>>下一张</a>
  </div>
  <div class="images">
	     <?php if($node -> field_activity_image[0]['view']):?>		 
		  
		  <a href=<?php echo $base_url.'/node/'.$next_nid; ?> title="点击进入下一张">
		  <?php echo $node -> field_activity_image[0]['view']?>
		  </a>
		 <?php endif;?>
	   	<?php if( $node -> content['body']['#value']):?>		
			 <div class='activity-description'>
			 <?php echo $node -> content['body']['#value'];?>
			</div>
         <?php endif;?>
  </div>
	<div class="left">
	<div class="votes">
	   <?php echo $node -> content['fivestar_widget']['#value'];?>
	  	</div>
	</div>
	
	<div class="right">
	  
	   	<div class="buttons">
	   <a class="comment" href="#comment-form">我要点评</a>
	   </div>
	  </div><!-- /.right -->
	</div> <!-- /.node -->
