<?php
// $Id: views-view.tpl.php,v 1.1.2.1 2010/01/12 16:32:29 johnalbin Exp $

/**
 * @file
 * Main view template
 *
 * Variables available:
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - view
 *   - view-[name]
 *   - view-id-[name]
 *   - view-display-id-[display id]
 *   - view-dom-id-[dom id]
 * - $css_name: A css-safe version of the view name.
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>
<div class="expericen-argument-stage <?php print $classes; ?>">
   <div class="inside">
   	 <div class="border">
		  <?php if ($admin_links): ?>
		    <div class="views-admin-links views-hide">
		      <?php print $admin_links; ?>
		    </div>
		  <?php endif; ?>
		<div class="left">
		
		</div>
		<div class="right">
			<div class="text">
			    <span>育儿就是一个不断试错、不断纠错的过程，没有孰对孰错，只有适合不适合。但有多少个孩子，就有多少个属于自己的育儿经验与心得。
			                           育儿经验是每个妈妈都关注的话题，爱儿帮特别开辟育儿经验辩论台，不为争辩高低，只为在讨论中了解到更多妈妈的心声、更多孩子的故事、
			                           让更多家长学习到适合自己的育儿经验。
			    </span>
				<span>这里不崇拜早教专家，这里不迷信育儿高手，这里只有一颗颗真诚的希冀孩子健康幸福幸运成长的妈妈的心。</span>				  
				<span>来吧，“理越辩越明”，说出你的观点，说出你的经验，享受赞许或批评，因为，我们有责任。</span>				 
			 <div class="clear"></div>
			</div>
<!--  		
		  <?php if ($rows): ?>
		    <div class="view-content">
		      <h3>往期辩论话题</h3>
		      <?php //print $rows; ?>
		    </div>
		  <?php endif;?>  
-->			  
		</div>
		</div>
		<div class="clear"></div>	
	</div>	
</div> <!-- /.view -->