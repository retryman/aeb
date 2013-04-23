<?php
// $Id: comment-wrapper.tpl.php,v 1.3 2009/11/01 19:47:40 johnalbin Exp $

/**
 * @file
 * Default theme implementation to wrap comments.
 *
 * Available variables:
 * - $content: All comments for a given page. Also contains sorting controls
 *   and comment forms if the site is configured for it.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default value has the following:
 *   - comment-wrapper: The current template type, i.e., "theming hook".
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT_COLLAPSED
 *   - COMMENT_MODE_FLAT_EXPANDED
 *   - COMMENT_MODE_THREADED_COLLAPSED
 *   - COMMENT_MODE_THREADED_EXPANDED
 * - $display_order
 *   - COMMENT_ORDER_NEWEST_FIRST
 *   - COMMENT_ORDER_OLDEST_FIRST
 * - $comment_controls_state
 *   - COMMENT_CONTROLS_ABOVE
 *   - COMMENT_CONTROLS_BELOW
 *   - COMMENT_CONTROLS_ABOVE_BELOW
 *   - COMMENT_CONTROLS_HIDDEN
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_comment_wrapper()
 */
?>
<div id="comments" class="normal-comments <?php print $classes; ?>">
	<div class="banner">
		<h3>帮友评论</h3>
		<a id="collect-link" style="cursor:pointer;display:block;height: 15px;margin-left:474px;width:32px;"></a>
	</div>
	<div id="click-hidden">
	<?php print $content; ?>
	</div>
</div>
<script type="text/javascript">
var click_hidden_div = $("#click-hidden");
$("#collect-link").click(function(){	
	if(click_hidden_div.css('display') == 'none'){
		click_hidden_div.fadeIn("slow");
	}
	else{
		click_hidden_div.fadeOut("slow");
	}
	
});
</script>