<?php
// $Id: date-navigation.tpl.php,v 1.1.4.10 2009/04/30 10:44:43 karens Exp $
/**
 * @file
 * Template to display date navigation links.
 *
 * $nav_title
 *   The formatted title for this view. In the case of block
 *   views, it will be a link to the full view, otherwise it will 
 *   be the formatted name of the year, month, day, or week.
 * 
 * $prev_url
 * $next_url
 *   Urls for the previous and next calendar pages. The links are 
 *   composed in the template to make it easier to change the text,
 *   add images, etc.
 * 
 * $prev_options
 * $next_options
 *   Query strings and other options for the links that need to
 *   be used in the l() function, including rel=nofollow.
 * 
 * $block: 
 *   Whether or not this view is in a block.
 * 
 * $view
 *   The view object for this navigation.
 * 
 * The &nbsp; in the prev and next divs is to be sure they are never
 * completely empty, needed in some browsers to prop the header open
 * so the title stays centered.
 * 
 */
$urlYear = date('Y', time());

if($_GET['mini']){
	$date_arr = explode('/', $_GET['mini']);
	$yearTemp = explode('-', $date_arr[1]);
	$urlYear = $yearTemp[0];
}
?>
<?php if(arg(0) == 'virtue'):?><!-- 每日美德首页 -->

	<div class="date-nav clear-block">
	  <div class="date-prev">
	    <?php if (!empty($prev_url)) : ?>
	      <span class="next"> <?php print l('« ' . ($block ? '' : date_t('Prev', 'date_nav')), $prev_url, $prev_options); ?></span>
	    <?php endif; ?>
	  &nbsp;</div>
	
	<?php for($i = 1; $i < 13; $i++){?>
	
		<?php 
		
			$month = $i < 10?'0'.$i:$i;
		
			$current_class = '';
			if('calendar/'.$urlYear.'-'.$month == $_GET['mini']){				
				$current_class = 'current';
			}
			else if(!$_GET['mini'] && $i == date('m', time())){
				$current_class = 'current';
			}
			
			
		?>	
	
	  <div class="monnav <?php echo 'monnav'.$i;?> <?php echo $current_class; ?> " >
	    <a href="<?php echo '/virtue?mini=calendar%2F'.$urlYear.'-'.$month?>#calendar"><?php echo $i?>月</a>
	  </div>
	  
	<?php }?>
	  <div class="date-next">&nbsp;
	    <?php if (!empty($next_url)) : ?>
	      <span class="next"> <?php print l(($block ? '' : date_t('Next', 'date_nav')) . ' »', $next_url, $next_options); ?></span>
	    <?php endif; ?>  
	  </div>
	</div>
<?php else:?>
	<div class="date-nav clear-block">
	  <div class="date-prev">
	    <?php if (!empty($prev_url)) : ?>
	      <span class="next"> <?php print l('« ' . ($block ? '' : date_t('Prev', 'date_nav')), $prev_url, $prev_options); ?></span>
	    <?php endif; ?>
	  &nbsp;</div>
	  <div class="date-heading">
	    <h3><?php print $nav_title ?></h3>
	  </div>
	  <div class="date-next">&nbsp;
	    <?php if (!empty($next_url)) : ?>
	      <span class="next"> <?php print l(($block ? '' : date_t('Next', 'date_nav')) . ' »', $next_url, $next_options); ?></span>
	    <?php endif; ?>  
	  </div>
	</div>
<?php endif;?>

